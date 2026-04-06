#!/usr/bin/env python3
"""
KTP Field Detection Script
Priority: Trained YOLO model -> Fallback to PaddleOCR -> Default coordinates

Usage:
    python detect_fields.py <image_path> <dataset_path>

Output:
    JSON coordinates for each field
"""

import sys
import json
import os
from pathlib import Path

try:
    import cv2
    import numpy as np
    from ultralytics import YOLO
    has_yolo = True
except ImportError:
    has_yolo = False
    print("Warning: YOLO not available, will use fallback methods", file=sys.stderr)

try:
    from paddleocr import PaddleOCR
    has_paddleocr = True
except ImportError:
    has_paddleocr = False
    print("Warning: PaddleOCR not available, will use default coordinates", file=sys.stderr)


class Ktp_Field_Detector:
    def __init__(self, dataset_path=None):
        self.dataset_path = dataset_path or str(Path(__file__).parent / "dataset")

        self.field_classes = {
            'nik': 0,
            'nama': 1,
            'tempat_lahir': 2,
            'tanggal_lahir': 3,
            'alamat': 4,
            'rt_rw': 5,
            'kel_desa': 6,
            'kecamatan': 7,
            'agama': 8,
            'status_perkawinan': 9,
            'pekerjaan': 10,
            'kewarganegaraan': 11,
            'berlaku_hingga': 12
        }

        self.class_names = list(self.field_classes.keys())

        self.default_coordinates = {
            'nik': {'x': 180, 'y': 55, 'width': 400, 'height': 30},
            'nama': {'x': 180, 'y': 95, 'width': 450, 'height': 25},
            'tempat_lahir': {'x': 180, 'y': 125, 'width': 200, 'height': 20},
            'tanggal_lahir': {'x': 450, 'y': 125, 'width': 180, 'height': 20},
            'alamat': {'x': 50, 'y': 155, 'width': 600, 'height': 50},
            'rt_rw': {'x': 180, 'y': 210, 'width': 150, 'height': 20},
            'kel_desa': {'x': 180, 'y': 240, 'width': 300, 'height': 20},
            'kecamatan': {'x': 180, 'y': 270, 'width': 300, 'height': 20},
            'agama': {'x': 180, 'y': 300, 'width': 150, 'height': 20},
            'status_perkawinan': {'x': 180, 'y': 330, 'width': 200, 'height': 20},
            'pekerjaan': {'x': 180, 'y': 360, 'width': 250, 'height': 20},
            'kewarganegaraan': {'x': 180, 'y': 390, 'width': 150, 'height': 20},
            'berlaku_hingga': {'x': 180, 'y': 420, 'width': 200, 'height': 20}
        }

        self.yolo_model = None
        self.paddleocr = None

        self._init_yolo()
        self._init_paddleocr()

    def _init_yolo(self):
        if not has_yolo:
            return

        # Try multiple paths for YOLO model
        model_paths = [
            Path(self.dataset_path) / "runs" / "quick_test" / "weights" / "best.pt",  # Custom trained model
            Path(self.dataset_path) / "runs" / "ktp_field_detector" / "weights" / "best.pt",  # Original path
            Path(self.dataset_path).parent / "runs" / "quick_test" / "weights" / "best.pt",  # Alternative path
        ]

        for model_path in model_paths:
            if model_path.exists():
                try:
                    self.yolo_model = YOLO(str(model_path))
                    print(f"Loaded YOLO model from: {model_path}", file=sys.stderr)
                    return
                except Exception as e:
                    print(f"Warning: Failed to load YOLO model from {model_path}: {e}", file=sys.stderr)

        print(f"Info: YOLO model not found at any of these paths:", file=sys.stderr)
        for path in model_paths:
            print(f"  - {path}", file=sys.stderr)

    def _init_paddleocr(self):
        if not has_paddleocr:
            return

        try:
            self.paddleocr = PaddleOCR(use_angle_cls=True, lang='id', use_gpu=False, show_log=False)
            print("Initialized PaddleOCR as fallback", file=sys.stderr)
        except Exception as e:
            print(f"Warning: Failed to initialize PaddleOCR: {e}", file=sys.stderr)

    def detect_fields(self, image_path, confidence_threshold=0.5, iou_threshold=0.45):
        if not os.path.exists(image_path):
            return {
                "success": False,
                "error": f"Image not found: {image_path}"
            }

        try:
            image = cv2.imread(image_path)
            if image is None:
                return {
                    "success": False,
                    "error": "Failed to read image"
                }

            height, width = image.shape[:2]

            if self.yolo_model is not None:
                coordinates = self._detect_with_yolo(image, confidence_threshold, iou_threshold)
                if coordinates:
                    return {
                        "success": True,
                        "method": "yolo",
                        "coordinates": coordinates,
                        "image_size": {"width": width, "height": height}
                    }

            if self.paddleocr is not None:
                coordinates = self._detect_with_paddleocr(image)
                if coordinates:
                    return {
                        "success": True,
                        "method": "paddleocr",
                        "coordinates": coordinates,
                        "image_size": {"width": width, "height": height}
                    }

            default_coords = self._get_default_coordinates(width, height)
            return {
                "success": True,
                "method": "default",
                "coordinates": default_coords,
                "image_size": {"width": width, "height": height}
            }

        except Exception as e:
            print(f"Error in detection: {str(e)}", file=sys.stderr)
            return {
                "success": False,
                "error": str(e)
            }

    def _detect_with_yolo(self, image, conf_threshold, iou_threshold):
        try:
            results = self.yolo_model(image, conf=conf_threshold, iou=iou_threshold, verbose=False)

            if not results or len(results) == 0:
                return None

            result = results[0]
            boxes = result.boxes

            if boxes is None or len(boxes) == 0:
                return None

            coordinates = {}

            for box in boxes:
                class_id = int(box.cls[0])
                confidence = float(box.conf[0])
                xyxy = box.xyxy[0].cpu().numpy()

                if class_id < len(self.class_names):
                    field_name = self.class_names[class_id]

                    x_min = int(xyxy[0])
                    y_min = int(xyxy[1])
                    x_max = int(xyxy[2])
                    y_max = int(xyxy[3])

                    coordinates[field_name] = {
                        'x': x_min,
                        'y': y_min,
                        'width': x_max - x_min,
                        'height': y_max - y_min,
                        'confidence': confidence
                    }

            if len(coordinates) > 0:
                return coordinates

            return None

        except Exception as e:
            print(f"Error in YOLO detection: {e}", file=sys.stderr)
            return None

    def _detect_with_paddleocr(self, image):
        try:
            result = self.paddleocr.ocr(image, cls=True)

            if not result or not result[0]:
                return None

            detected_boxes = []
            for line in result[0]:
                box = line[0]
                text = line[1][0]
                confidence = line[1][1]

                x_coords = [point[0] for point in box]
                y_coords = [point[1] for point in box]

                x_min = int(min(x_coords))
                y_min = int(min(y_coords))
                x_max = int(max(x_coords))
                y_max = int(max(y_coords))

                detected_boxes.append({
                    'text': text,
                    'box': [x_min, y_min, x_max, y_max],
                    'confidence': confidence
                })

            field_coordinates = self._extract_field_coordinates(detected_boxes)

            if len(field_coordinates) > 0:
                return field_coordinates

            return None

        except Exception as e:
            print(f"Error in PaddleOCR detection: {e}", file=sys.stderr)
            return None

    def _extract_field_coordinates(self, detected_boxes):
        field_keywords = {
            'nik': ['NIK', 'Nik', 'nik'],
            'nama': ['Nama', 'NAMA', 'nama'],
            'tempat_lahir': ['Tempat', 'TEMPAT', 'Tempat Lahir'],
            'tanggal_lahir': ['Tgl', 'TGL', 'Tgl.', 'Tanggal', 'TANGGAL'],
            'alamat': ['Alamat', 'ALAMAT', 'alamat'],
            'rt_rw': ['RT', 'RW', 'RT/RW'],
            'kel_desa': ['Kel', 'KEL', 'Kelurahan', 'Desa'],
            'kecamatan': ['Kec', 'KEC', 'Kecamatan', 'Kec.'],
            'agama': ['Agama', 'AGAMA'],
            'status_perkawinan': ['Status', 'STATUS'],
            'pekerjaan': ['Pekerjaan', 'PEKERJAAN'],
            'kewarganegaraan': ['Warga', 'WARGA'],
            'berlaku_hingga': ['Berlaku', 'BERLAKU']
        }

        field_coords = {}

        for field_name, keywords in field_keywords.items():
            for box in detected_boxes:
                text = box['text'].strip()

                if any(keyword in text for keyword in keywords):
                    x_min, y_min, x_max, y_max = box['box']

                    field_coords[field_name] = {
                        'x': x_min + 50,
                        'y': y_min,
                        'width': (x_max - x_min) + 100,
                        'height': (y_max - y_min) + 10
                    }
                    break

        return field_coords

    def _get_default_coordinates(self, image_width, image_height):
        scaled_coords = {}

        for field_name, coords in self.default_coordinates.items():
            scale_x = image_width / 800
            scale_y = image_height / 500

            scaled_coords[field_name] = {
                'x': int(coords['x'] * scale_x),
                'y': int(coords['y'] * scale_y),
                'width': int(coords['width'] * scale_x),
                'height': int(coords['height'] * scale_y)
            }

        return scaled_coords


def main():
    if len(sys.argv) < 2:
        print(json.dumps({
            "error": "Missing arguments",
            "usage": "python detect_fields.py <image_path> [dataset_path]"
        }))
        sys.exit(1)

    image_path = sys.argv[1]
    dataset_path = sys.argv[2] if len(sys.argv) > 2 else None

    detector = Ktp_Field_Detector(dataset_path)
    result = detector.detect_fields(image_path)

    print(json.dumps(result, indent=2))


if __name__ == "__main__":
    main()
