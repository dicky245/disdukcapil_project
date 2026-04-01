r"""
================================================================================
PYTHON OCR API - Tesseract (Windows)
================================================================================
KVP Extraction menggunakan Tesseract OCR dengan path Windows.

Tesseract Path: C:\\Program Files\\Tesseract-OCR

Created by: Senior ML Engineer
Date: 2026-03-20
================================================================================
"""

from fastapi import FastAPI, File, UploadFile, HTTPException
from fastapi.middleware.cors import CORSMiddleware
from fastapi.responses import JSONResponse
from PIL import Image
import pytesseract
import cv2
import numpy as np
import re
from typing import Optional, Dict, Any, List, Tuple
import logging
from datetime import datetime
import os

# Configure logging
logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

# Tesseract Path untuk Windows
TESSERACT_PATH = r"C:\Program Files\Tesseract-OCR"

# Set TESSDATA_PREFIX ke tessdata directory di project
TESSDATA_PREFIX = os.path.join(os.path.dirname(__file__), 'tessdata')
os.environ['TESSDATA_PREFIX'] = TESSDATA_PREFIX

# Set Tesseract path (string, not list)
pytesseract.pytesseract.tesseract_cmd = os.path.join(TESSERACT_PATH, 'tesseract.exe')

# Initialize FastAPI
app = FastAPI(
    title="KTP OCR API - Tesseract",
    description="KVP Extraction untuk KTP Indonesia dengan Tesseract",
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


class TesseractKTPExtractor:
    """
    KVP Extractor menggunakan Tesseract OCR.

    Strategy:
    1. Convert image ke grayscale
    2. Apply preprocessing (threshold, denoise)
    3. Use Indonesian language model
    4. Parse text dengan KVP logic
    """

    def __init__(self):
        self.tesseract_path = TESSERACT_PATH
        self.last_enhanced_image = None  # Store enhanced image for preview

        # Anchor words dengan fuzzy matching
        self.anchors = {
            'nik': ['NIK', 'NIK', 'nik'],
            'nama': ['Nama', 'NAMA', 'nama'],
            'tanggal_lahir': ['Tgl Lahir', 'TGL LAHIR', 'Tgl. Lahir', 'Tanggal Lahir'],
            'alamat': ['Alamat', 'ALAMAT', 'alamat'],
        }

        # Patterns
        self.patterns = {
            'nik': re.compile(r'\b\d{16}\b'),
            'tanggal': re.compile(r'\b\d{2}[-./]\d{2}[-./]\d{4}\b'),
        }

        logger.info(f"Tesseract initialized at: {self.tesseract_path}")

    def extract_from_image(self, image_path: str) -> Dict[str, Any]:
        """
        Extract KTP data menggunakan Tesseract.

        Args:
            image_path: Path ke image file

        Returns:
            Dictionary dengan extracted data
        """
        try:
            # Load dan preprocess image
            image = cv2.imread(image_path)
            if image is None:
                raise ValueError("Gagal membaca image")

            # Preprocess dengan enhancement (CamScanner-like)
            image_processed = self._preprocess_image(image)

            # Store enhanced image untuk preview
            self.last_enhanced_image = image_processed

            # Convert ke PIL Image
            pil_image = Image.fromarray(image_processed)

            # Get text dengan Indonesian language dan bounding box data
            text_data = pytesseract.image_to_data(
                pil_image,
                lang='ind',  # Indonesian
                config='--oem 3 --psm 6',  # LSTM, Assume single uniform block
                output_type=pytesseract.Output.DICT
            )

            # Parse text lines dengan confidence
            lines = []
            for i in range(len(text_data['text'])):
                conf = int(text_data['conf'][i])
                if conf > 30:  # Filter low confidence
                    text = text_data['text'][i].strip()
                    if text:
                        lines.append(text)

            # Extract fields
            extracted = {
                'nik': self._extract_nik(lines),
                'nama': self._extract_nama(lines),
                'tanggal_lahir': self._extract_tanggal(lines),
                'alamat': self._extract_alamat(lines),
                'raw_text_count': len(lines),
                'extraction_confidence': 0.0,
                'engine': 'tesseract'
            }

            # Calculate confidence
            extracted['extraction_confidence'] = self._calculate_confidence(extracted)

            return extracted

        except Exception as e:
            logger.error(f"Tesseract extraction error: {str(e)}")
            raise

    def _preprocess_image(self, image: np.ndarray) -> np.ndarray:
        """
        Preprocess image dengan enhancement seperti CamScanner.

        Pipeline:
        1. Perspective correction (auto-skew)
        2. Brightness/Contrast enhancement (CLAHE)
        3. Sharpening
        4. Noise reduction
        5. Adaptive threshold
        6. Edge enhancement
        """
        try:
            # Step 1: Convert ke grayscale
            gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

            # Step 2: Perspective correction (auto-skew detection)
            gray = self._correct_perspective(gray)

            # Step 3: Brightness/Contrast enhancement dengan CLAHE
            clahe = cv2.createCLAHE(clipLimit=3.0, tileGridSize=(8, 8))
            enhanced = clahe.apply(gray)

            # Step 4: Sharpening kernel
            sharpen_kernel = np.array([
                [-1, -1, -1],
                [-1,  9, -1],
                [-1, -1, -1]
            ]) / 9
            sharpened = cv2.filter2D(enhanced, -1, sharpen_kernel)

            # Step 5: Denoise
            denoised = cv2.fastNlMeansDenoising(sharpened, None, 10, 7, 21)

            # Step 6: Adaptive threshold untuk better text extraction
            thresh = cv2.adaptiveThreshold(
                denoised, 255,
                cv2.ADAPTIVE_THRESH_GAUSSIAN_C,
                cv2.THRESH_BINARY,
                11, 2
            )

            # Step 7: Morphological operations untuk clean up
            kernel = np.ones((2, 2), np.uint8)
            cleaned = cv2.morphologyEx(thresh, cv2.MORPH_CLOSE, kernel)
            cleaned = cv2.morphologyEx(cleaned, cv2.MORPH_OPEN, kernel)

            return cleaned

        except Exception as e:
            logger.error(f"Preprocessing error: {str(e)}")
            # Fallback: basic grayscale
            return cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)

    def _correct_perspective(self, image: np.ndarray) -> np.ndarray:
        """
        Auto-correct perspective/skew detection.
        Deteksi dan rotate jika image miring.
        """
        try:
            # Detect edges
            edges = cv2.Canny(image, 50, 150, apertureSize=3)

            # Detect lines menggunakan Hough transform
            lines = cv2.HoughLines(edges, 1, np.pi/180, threshold=100)

            if lines is not None and len(lines) > 0:
                # Calculate average angle
                angles = []
                for line in lines[:10]:  # Ambil 10 lines pertama
                    rho, theta = line[0]
                    angle = np.degrees(theta) - 90
                    if -45 < angle < 45:  # Filter reasonable angles
                        angles.append(angle)

                if angles:
                    # Median angle untuk rotation
                    median_angle = np.median(angles)

                    # Rotate jika angle significant (> 2 derajat)
                    if abs(median_angle) > 2:
                        center = (image.shape[1] // 2, image.shape[0] // 2)
                        matrix = cv2.getRotationMatrix2D(center, median_angle, 1.0)
                        rotated = cv2.warpAffine(
                            image, matrix,
                            (image.shape[1], image.shape[0]),
                            flags=cv2.INTER_CUBIC,
                            borderMode=cv2.BORDER_REPLICATE
                        )
                        return rotated

            return image

        except Exception as e:
            logger.error(f"Perspective correction error: {str(e)}")
            return image

    def _extract_nik(self, lines: List[str]) -> Optional[str]:
        """Extract NIK"""
        # Find NIK anchor
        nik_idx = self._find_anchor_index(lines, 'nik')

        if nik_idx is not None:
            # Cari di sekitar anchor
            for i in range(nik_idx, min(nik_idx + 3, len(lines))):
                match = self.patterns['nik'].search(lines[i])
                if match:
                    nik = match.group()
                    if self._is_valid_nik(nik):
                        return nik

        # Fallback: Cari di seluruh dokumen
        for line in lines:
            match = self.patterns['nik'].search(line)
            if match:
                nik = match.group()
                if self._is_valid_nik(nik):
                    return nik

        return None

    def _extract_nama(self, lines: List[str]) -> Optional[str]:
        """Extract Nama"""
        nama_idx = self._find_anchor_index(lines, 'nama')

        if nama_idx is not None:
            nama_parts = []

            for i in range(nama_idx + 1, min(nama_idx + 5, len(lines))):
                text = lines[i]

                # Stop jika ketemu anchor lain
                if self._is_any_anchor(text, exclude='nama'):
                    break

                if self._is_valid_nama_text(text):
                    nama_parts.append(text)
                    if len(nama_parts) >= 2:
                        break

            if nama_parts:
                return ' '.join(nama_parts)

        return None

    def _extract_tanggal(self, lines: List[str]) -> Optional[str]:
        """Extract Tanggal Lahir"""
        tanggal_idx = self._find_anchor_index(lines, 'tanggal_lahir')

        if tanggal_idx is not None:
            for i in range(tanggal_idx + 1, min(tanggal_idx + 3, len(lines))):
                text = lines[i]

                match = self.patterns['tanggal'].search(text)
                if match:
                    tanggal = match.group()
                    tanggal = re.sub(r'[./]', '-', tanggal)
                    if self._is_valid_tanggal(tanggal):
                        return tanggal

        # Fallback
        for line in lines:
            match = self.patterns['tanggal'].search(line)
            if match:
                tanggal = match.group()
                tanggal = re.sub(r'[./]', '-', tanggal)
                if self._is_valid_tanggal(tanggal):
                    return tanggal

        return None

    def _extract_alamat(self, lines: List[str]) -> Optional[str]:
        """Extract Alamat"""
        alamat_idx = self._find_anchor_index(lines, 'alamat')

        if alamat_idx is not None:
            alamat_lines = []

            for i in range(alamat_idx + 1, min(len(lines), alamat_idx + 7)):
                text = lines[i]

                # Stop jika ketemu anchor lain
                if self._is_any_anchor(text, exclude='alamat'):
                    break

                if len(text) > 2:
                    alamat_lines.append(text)

            if alamat_lines:
                return ' '.join(alamat_lines)

        return None

    def _find_anchor_index(self, lines: List[str], field: str) -> Optional[int]:
        """Find anchor index"""
        anchor_variants = self.anchors.get(field, [])

        for idx, line in enumerate(lines):
            for anchor in anchor_variants:
                if anchor.lower() in line.lower():
                    return idx

        return None

    def _is_any_anchor(self, text: str, exclude: str = None) -> bool:
        """Check jika text adalah anchor"""
        for field, variants in self.anchors.items():
            if field == exclude:
                continue
            for anchor in variants:
                if anchor.lower() in text.lower():
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
        """Validate tanggal"""
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

    def _calculate_confidence(self, extracted: Dict) -> float:
        """Calculate confidence"""
        fields = ['nik', 'nama', 'tanggal_lahir', 'alamat']
        extracted_count = sum(1 for f in fields if extracted.get(f))

        base_confidence = extracted_count / len(fields)

        # Boost untuk critical fields
        critical = ['nik', 'nama']
        critical_count = sum(1 for f in critical if extracted.get(f))
        if critical_count == len(critical):
            base_confidence = min(base_confidence + 0.15, 1.0)

        return round(base_confidence, 2)

    def get_enhanced_image_base64(self) -> Optional[str]:
        """
        Convert enhanced image ke base64 string untuk preview.

        Returns:
            Base64 encoded string atau None
        """
        if self.last_enhanced_image is None:
            return None

        try:
            # Convert numpy array ke PIL Image
            pil_image = Image.fromarray(self.last_enhanced_image)

            # Convert ke base64
            import base64
            from io import BytesIO

            buffered = BytesIO()
            pil_image.save(buffered, format="PNG")
            img_str = base64.b64encode(buffered.getvalue()).decode()

            return f"data:image/png;base64,{img_str}"

        except Exception as e:
            logger.error(f"Error converting enhanced image to base64: {str(e)}")
            return None


# Global extractor
extractor = TesseractKTPExtractor()


@app.get("/")
async def root():
    """Root endpoint"""
    return {
        "service": "KTP OCR API - Tesseract",
        "version": "2.0.0",
        "status": "running",
        "engine": "tesseract",
        "tesseract_path": TESSERACT_PATH,
        "timestamp": datetime.now().isoformat()
    }


@app.get("/health")
async def health_check():
    """Health check"""
    try:
        # Test Tesseract
        version = pytesseract.get_tesseract_version()
        return {
            "status": "healthy",
            "ocr_engine": "tesseract",
            "tesseract_version": str(version),
            "tesseract_path": TESSERACT_PATH,
            "timestamp": datetime.now().isoformat()
        }
    except Exception as e:
        raise HTTPException(status_code=503, detail=f"Tesseract error: {str(e)}")


@app.post("/api/extract-ktp")
async def extract_ktp(file: UploadFile = File(...)):
    """
    Extract KTP data.

    Args:
        file: Uploaded image

    Returns:
        JSON dengan extracted data
    """
    try:
        # Validate
        if not file.content_type.startswith('image/'):
            raise HTTPException(
                status_code=400,
                detail="File harus berupa image"
            )

        # Read
        contents = await file.read()

        # Save temp
        temp_path = f"temp_{file.filename}"
        with open(temp_path, "wb") as f:
            f.write(contents)

        try:
            # Extract
            logger.info(f"Processing: {file.filename}")
            result = extractor.extract_from_image(temp_path)

            # Get enhanced image preview
            enhanced_image_base64 = extractor.get_enhanced_image_base64()

            # Format response dengan enhanced image
            return {
                "success": True,
                "data": {
                    "nik": result.get('nik'),
                    "nama": result.get('nama'),
                    "tanggal_lahir": result.get('tanggal_lahir'),
                    "alamat": result.get('alamat'),
                },
                "confidence": result.get('extraction_confidence', 0),
                "raw_text_count": result.get('raw_text_count', 0),
                "engine": "tesseract",
                "enhanced_image": enhanced_image_base64,  # Base64 encoded enhanced image
                "enhancement_applied": True,
                "timestamp": datetime.now().isoformat()
            }

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

    logger.info("Starting KTP OCR API - Tesseract")
    logger.info(f"Tesseract Path: {TESSERACT_PATH}")

    uvicorn.run(app, host="127.0.0.1", port=8000, log_level="info")
