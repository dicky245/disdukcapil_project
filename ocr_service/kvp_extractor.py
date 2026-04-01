"""
================================================================================
PYTHON OCR API - KVP EXTRACTION (ROBUST)
================================================================================
KVP Extraction dengan Anchor-Based Logic untuk KTP Indonesia.

Engine: EasyOCR (Indonesian language)
Strategy: Anchor word detection + Relative position search

Created by: Senior ML Engineer
Date: 2026-03-20
================================================================================
"""

from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
import easyocr
import cv2
import numpy as np
from PIL import Image
import re
from typing import Optional, Dict, Any, List, Tuple
import logging
from datetime import datetime
import os

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Initialize FastAPI
app = FastAPI(
    title="KTP OCR API - KVP Extraction",
    description="Robust KVP Extraction untuk KTP Indonesia",
    version="2.0.0"
)

# Configure CORS
app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)

# Initialize EasyOCR Reader
reader = None

def get_reader():
    """Get or initialize EasyOCR reader"""
    global reader
    if reader is None:
        logger.info("Initializing EasyOCR reader...")
        reader = easyocr.Reader(['id'], gpu=False)
        logger.info("EasyOCR reader initialized")
    return reader


class RobustKTPExtractor:
    """
    Robust KVP Extractor dengan Anchor-Based Logic.

    Strategy:
    1. Find anchor words (NIK, Nama, Tgl Lahir, Alamat)
    2. Extract values based on relative position
    3. Use fuzzy matching untuk anchor detection
    4. Handle various KTP layouts
    """

    def __init__(self):
        self.reader = None

        # Anchor words dengan variations (fuzzy matching)
        self.anchors = {
            'nik': ['NIK', 'NIK', 'nik', 'NlK'],  # Include common OCR errors
            'nama': ['Nama', 'NAMA', 'nama', 'Narna', 'Ham a'],  # Fuzzy variations
            'tanggal_lahir': ['Tgl Lahir', 'TGL LAHIR', 'Tgl. Lahir', 'Tanggal Lahir', 'TglLahir'],
            'alamat': ['Alamat', 'ALAMAT', 'alamat', 'Aiamat'],
        }

        # Patterns
        self.patterns = {
            'nik': re.compile(r'\b\d{16}\b'),
            'tanggal': re.compile(r'\b\d{2}[-./]\d{2}[-./]\d{4}\b'),
        }

    def extract_from_image(self, image_path: str) -> Dict[str, Any]:
        """
        Extract KTP data dengan robust KVP logic.

        Args:
            image_path: Path ke image file

        Returns:
            Dictionary dengan extracted data
        """
        try:
            # Get reader
            if not self.reader:
                self.reader = get_reader()

            # Read image
            image = cv2.imread(image_path)
            if image is None:
                raise ValueError("Gagal membaca image")

            # Preprocess image
            image = self._preprocess_image(image)

            # Perform OCR
            results = self.reader.readtext(image)

            # Build structured data dengan bounding box info
            ocr_data = []
            for (bbox, text, confidence) in results:
                if confidence > 0.3:  # Lower threshold untuk tidak miss data
                    ocr_data.append({
                        'text': text.strip(),
                        'confidence': float(confidence),
                        'bbox': bbox,  # [[x1,y1], [x2,y2], [x3,y3], [x4,y4]]
                        'center': self._get_bbox_center(bbox),
                        'bottom_left': (bbox[0][0], bbox[0][1]),
                        'bottom_right': (bbox[2][0], bbox[2][1]),
                    })

            # Extract fields menggunakan KVP logic
            extracted = {
                'nik': self._extract_nik_kvp(ocr_data),
                'nama': self._extract_nama_kvp(ocr_data),
                'tanggal_lahir': self._extract_tanggal_kvp(ocr_data),
                'alamat': self._extract_alamat_kvp(ocr_data),
                'raw_text_count': len(ocr_data),
                'extraction_confidence': 0.0,
            }

            # Calculate confidence
            extracted['extraction_confidence'] = self._calculate_confidence(extracted, ocr_data)

            return extracted

        except Exception as e:
            logger.error(f"Error extracting KTP: {str(e)}")
            raise

    def _preprocess_image(self, image: np.ndarray) -> np.ndarray:
        """Preprocess image untuk better OCR"""
        # Convert ke grayscale
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

        # Apply adaptive threshold
        thresh = cv2.adaptiveThreshold(
            gray, 255,
            cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
            cv2.THRESH_BINARY, 11, 2
        )

        # Denoise
        denoised = cv2.fastNlMeansDenoising(thresh, None, 10, 7, 21)

        # Convert back ke BGR
        return cv2.cvtColor(denoised, cv2.COLOR_GRAY2BGR)

    def _get_bbox_center(self, bbox: List) -> Tuple[float, float]:
        """Calculate center point dari bounding box"""
        x_coords = [point[0] for point in bbox]
        y_coords = [point[1] for point in bbox]
        center_x = sum(x_coords) / 4
        center_y = sum(y_coords) / 4
        return (center_x, center_y)

    def _fuzzy_match_anchor(self, text: str, anchor_variants: List[str]) -> bool:
        """
        Fuzzy matching untuk anchor words.
        Handle common OCR errors.
        """
        text_lower = text.lower().replace(' ', '')

        for anchor in anchor_variants:
            anchor_lower = anchor.lower().replace(' ', '')

            # Exact match
            if text_lower == anchor_lower:
                return True

            # Contains match
            if anchor_lower in text_lower or text_lower in anchor_lower:
                return True

            # Levenshtein distance (untuk very fuzzy match)
            if selflevenshtein(text_lower, anchor_lower) <= 2:
                return True

        return False

    def _extract_nik_kvp(self, ocr_data: List[Dict]) -> Optional[str]:
        """Extract NIK menggunakan anchor-based logic"""
        # Find NIK anchor
        nik_idx = self._find_anchor_index(ocr_data, 'nik')

        if nik_idx is not None:
            # NIK biasanya di kanan atau bawah anchor
            # Cari di area sekitar anchor
            search_area = ocr_data[nik_idx:min(nik_idx + 3, len(ocr_data))]

            for item in search_area:
                match = self.patterns['nik'].search(item['text'])
                if match:
                    nik = match.group()
                    if self._is_valid_nik(nik):
                        return nik

        # Fallback: Cari NIK di seluruh dokumen
        for item in ocr_data:
            match = self.patterns['nik'].search(item['text'])
            if match:
                nik = match.group()
                if self._is_valid_nik(nik):
                    return nik

        return None

    def _extract_nama_kvp(self, ocr_data: List[Dict]) -> Optional[str]:
        """Extract Nama menggunakan anchor-based logic"""
        # Find Nama anchor
        nama_idx = self._find_anchor_index(ocr_data, 'nama')

        if nama_idx is not None:
            # Nama biasanya di kanan anchor
            # Cari 1-3 kata setelah anchor
            nama_parts = []

            for i in range(nama_idx + 1, min(nama_idx + 5, len(ocr_data))):
                item = ocr_data[i]
                text = item['text']

                # Stop jika ketemu anchor lain
                if self._is_any_anchor(text):
                    break

                # Filter noise
                if self._is_valid_nama_text(text):
                    nama_parts.append(text)
                    # Nama biasanya 2-4 kata
                    if len(nama_parts) >= 2:
                        break

            if nama_parts:
                nama = ' '.join(nama_parts)
                return self._clean_nama(nama)

        return None

    def _extract_tanggal_kvp(self, ocr_data: List[Dict]) -> Optional[str]:
        """Extract Tanggal Lahir menggunakan anchor-based logic"""
        # Find Tgl Lahir anchor
        tanggal_idx = self._find_anchor_index(ocr_data, 'tanggal_lahir')

        if tanggal_idx is not None:
            # Tanggal biasanya di kanan anchor
            # Cari di area sekitar anchor
            for i in range(tanggal_idx + 1, min(tanggal_idx + 3, len(ocr_data))):
                item = ocr_data[i]
                text = item['text']

                # Cek pattern tanggal
                match = self.patterns['tanggal'].search(text)
                if match:
                    tanggal = match.group()
                    # Normalize ke DD-MM-YYYY
                    tanggal = re.sub(r'[./]', '-', tanggal)
                    if self._is_valid_tanggal(tanggal):
                        return tanggal

        # Fallback: Cari pattern tanggal di seluruh dokumen
        for item in ocr_data:
            match = self.patterns['tanggal'].search(item['text'])
            if match:
                tanggal = match.group()
                tanggal = re.sub(r'[./]', '-', tanggal)
                if self._is_valid_tanggal(tanggal):
                    # Prefer tanggal yang dekat dengan anchor
                    return tanggal

        return None

    def _extract_alamat_kvp(self, ocr_data: List[Dict]) -> Optional[str]:
        """Extract Alamat menggunakan anchor-based logic"""
        # Find Alamat anchor
        alamat_idx = self._find_anchor_index(ocr_data, 'alamat')

        if alamat_idx is not None:
            # Alamat bisa multi-line
            # Cari beberapa baris setelah anchor
            alamat_lines = []

            for i in range(alamat_idx + 1, len(ocr_data)):
                item = ocr_data[i]
                text = item['text']

                # Stop jika ketemu anchor lain
                if self._is_any_anchor(text, exclude='alamat'):
                    break

                # Stop jika sudah terlalu banyak baris
                if len(alamat_lines) >= 4:
                    break

                # Filter
                if len(text) > 2:
                    alamat_lines.append(text)

            if alamat_lines:
                alamat = ' '.join(alamat_lines)
                return self._clean_alamat(alamat)

        return None

    def _find_anchor_index(self, ocr_data: List[Dict], field: str) -> Optional[int]:
        """Find index dari anchor word dengan fuzzy matching"""
        anchor_variants = self.anchors.get(field, [])

        for idx, item in enumerate(ocr_data):
            text = item['text']
            if self._fuzzy_match_anchor(text, anchor_variants):
                return idx

        return None

    def _is_any_anchor(self, text: str, exclude: str = None) -> bool:
        """Check jika text adalah salah satu anchor"""
        for field, variants in self.anchors.items():
            if field == exclude:
                continue
            if self._fuzzy_match_anchor(text, variants):
                return True
        return False

    def _is_valid_nik(self, nik: str) -> bool:
        """Validate NIK"""
        if len(nik) != 16 or not nik.isdigit():
            return False
        provinsi = int(nik[:2])
        return 1 <= provinsi <= 94

    def _is_valid_nama_text(self, text: str) -> bool:
        """Check jika text valid untuk nama"""
        if len(text) < 2:
            return False
        if text.isdigit():
            return False
        digit_ratio = sum(c.isdigit() for c in text) / len(text)
        if digit_ratio > 0.3:
            return False
        return True

    def _is_valid_tanggal(self, tanggal: str) -> bool:
        """Validate tanggal format DD-MM-YYYY"""
        try:
            parts = tanggal.split('-')
            if len(parts) != 3:
                return False

            day, month, year = int(parts[0]), int(parts[1]), int(parts[2])

            if not (1 <= day <= 31):
                return False
            if not (1 <= month <= 12):
                return False
            if not (1900 <= year <= 2010):
                return False

            return True
        except (ValueError, IndexError):
            return False

    def _clean_nama(self, nama: str) -> str:
        """Clean nama dari noise"""
        nama = re.sub(r'\.+', ' ', nama)
        nama = re.sub(r'\d{2}-\d{2}-\d{4}', '', nama)
        nama = ' '.join(nama.split())
        return nama.strip()

    def _clean_alamat(self, alamat: str) -> str:
        """Clean alamat dari noise"""
        alamat = re.sub(r'[./]', '-', alamat)
        alamat = ' '.join(alamat.split())
        return alamat.strip()

    def _calculate_confidence(self, extracted: Dict, ocr_data: List) -> float:
        """Calculate overall confidence"""
        fields = ['nik', 'nama', 'tanggal_lahir', 'alamat']
        extracted_count = sum(1 for f in fields if extracted.get(f))

        base_confidence = extracted_count / len(fields)

        # Boost jika critical fields ada
        critical = ['nik', 'nama']
        critical_count = sum(1 for f in critical if extracted.get(f))
        if critical_count == len(critical):
            base_confidence = min(base_confidence + 0.15, 1.0)

        return round(base_confidence, 2)

    def selflevenshtein(self, s1: str, s2: str) -> int:
        """Simple Levenshtein distance"""
        if len(s1) < len(s2):
            return self.levenshtein(s2, s1)

        if len(s2) == 0:
            return len(s1)

        previous_row = range(len(s2) + 1)
        for i, c1 in enumerate(s1):
            current_row = [i + 1]
            for j, c2 in enumerate(s2):
                insertions = previous_row[j + 1] + 1
                deletions = current_row[j] + 1
                substitutions = previous_row[j] + (c1 != c2)
                current_row.append(min(insertions, deletions, substitutions))
            previous_row = current_row

        return previous_row[-1]


# Global extractor instance
extractor = RobustKTPExtractor()


@app.get("/")
async def root():
    """Root endpoint"""
    return {
        "service": "KTP OCR API - KVP Extraction",
        "version": "2.0.0",
        "status": "running",
        "engine": "easyocr",
        "strategy": "anchor-based kvp",
        "timestamp": datetime.now().isoformat()
    }


@app.get("/health")
async def health_check():
    """Health check endpoint"""
    try:
        # Test reader
        get_reader()
        return {
            "status": "healthy",
            "ocr_engine": "easyocr",
            "language": "indonesian",
            "strategy": "anchor-based kvp extraction",
            "timestamp": datetime.now().isoformat()
        }
    except Exception as e:
        raise HTTPException(status_code=503, detail=f"Service unhealthy: {str(e)}")


@app.post("/api/extract-ktp")
async def extract_ktp(file: UploadFile = File(...)):
    """
    Extract KTP data dengan robust KVP logic.

    Args:
        file: Uploaded image file

    Returns:
        JSON dengan extracted data
    """
    try:
        # Validate file type
        if not file.content_type.startswith('image/'):
            raise HTTPException(
                status_code=400,
                detail="File harus berupa image (PNG, JPG, JPEG)"
            )

        # Read file
        contents = await file.read()

        # Save temp
        temp_path = f"temp_{file.filename}"
        with open(temp_path, "wb") as f:
            f.write(contents)

        try:
            # Extract
            logger.info(f"Processing KTP: {file.filename}")
            result = extractor.extract_from_image(temp_path)

            # Format response
            response = {
                "success": True,
                "data": {
                    "nik": result.get('nik'),
                    "nama": result.get('nama'),
                    "tanggal_lahir": result.get('tanggal_lahir'),
                    "alamat": result.get('alamat'),
                },
                "confidence": result.get('extraction_confidence', 0),
                "raw_text_count": result.get('raw_text_count', 0),
                "timestamp": datetime.now().isoformat()
            }

            logger.info(f"Extraction complete. Confidence: {response['confidence']}")

            return response

        finally:
            # Cleanup
            if os.path.exists(temp_path):
                os.remove(temp_path)

    except Exception as e:
        logger.error(f"Error: {str(e)}")
        return JSONResponse(
            status_code=500,
            content={
                "success": False,
                "error": str(e),
                "message": "Gagal memproses KTP"
            }
        )


if __name__ == "__main__":
    import uvicorn

    logger.info("Starting KTP OCR API - KVP Extraction")
    logger.info("Strategy: Anchor-Based KVP Extraction")

    uvicorn.run(app, host="127.0.0.1", port=8000, log_level="info")
