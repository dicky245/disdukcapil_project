#!/usr/bin/env python3
"""
Auto-Labeling Tool for KTP Dataset
Generate YOLO format labels using pre-trained PaddleOCR
"""

import os
import sys
import json
from pathlib import Path
import cv2
import numpy as np

try:
    from paddleocr import PaddleOCR
except ImportError:
    print("Error: PaddleOCR not installed. Run: pip install paddleocr")
    sys.exit(1)


class Ktp_Auto_Labeler:
    def __init__(self, dataset_path):
        self.dataset_path = Path(dataset_path)
        self.ocr = PaddleOCR(use_angle_cls=True, lang='id', use_gpu=False, show_log=False)

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

        self.field_keywords = {
            'nik': ['NIK', 'Nik', 'nik', 'No', 'NO'],
            'nama': ['Nama', 'NAMA', 'nama'],
            'tempat_lahir': ['Tempat', 'TEMPAT', 'Tempat Lahir'],
            'tanggal_lahir': ['Tgl', 'TGL', 'Tgl.', 'Tanggal', 'TANGGAL', 'Lahir'],
            'alamat': ['Alamat', 'ALAMAT', 'alamat'],
            'rt_rw': ['RT', 'RW', 'RT/RW', 'Rt', 'Rw'],
            'kel_desa': ['Kel', 'KEL', 'Kelurahan', 'Desa', 'DES', 'Desa'],
            'kecamatan': ['Kec', 'KEC', 'Kecamatan', 'Kec.', 'Kecamatan.'],
            'agama': ['Agama', 'AGAMA', 'agama'],
            'status_perkawinan': ['Status', 'STATUS', 'Kawin', 'Perkawinan'],
            'pekerjaan': ['Pekerjaan', 'PEKERJAAN', 'Pekerjaan:'],
            'kewarganegaraan': ['Warga', 'WARGA', 'Kewarganegaraan', 'Negara'],
            'berlaku_hingga': ['Berlaku', 'BERLAKU', 'Hingga', 'Sejak']
        }

        self.default_boxes = {
            'nik': {'x': 0.35, 'y': 0.11, 'w': 0.50, 'h': 0.06},
            'nama': {'x': 0.35, 'y': 0.19, 'w': 0.56, 'h': 0.05},
            'tempat_lahir': {'x': 0.35, 'y': 0.25, 'w': 0.25, 'h': 0.04},
            'tanggal_lahir': {'x': 0.56, 'y': 0.25, 'w': 0.22, 'h': 0.04},
            'alamat': {'x': 0.10, 'y': 0.31, 'w': 0.75, 'h': 0.10},
            'rt_rw': {'x': 0.35, 'y': 0.42, 'w': 0.19, 'h': 0.04},
            'kel_desa': {'x': 0.35, 'y': 0.48, 'w': 0.38, 'h': 0.04},
            'kecamatan': {'x': 0.35, 'y': 0.54, 'w': 0.38, 'h': 0.04},
            'agama': {'x': 0.35, 'y': 0.60, 'w': 0.19, 'h': 0.04},
            'status_perkawinan': {'x': 0.35, 'y': 0.66, 'w': 0.25, 'h': 0.04},
            'pekerjaan': {'x': 0.35, 'y': 0.72, 'w': 0.31, 'h': 0.04},
            'kewarganegaraan': {'x': 0.35, 'y': 0.78, 'w': 0.19, 'h': 0.04},
            'berlaku_hingga': {'x': 0.35, 'y': 0.84, 'w': 0.25, 'h': 0.04}
        }

    def label_image(self, image_path):
        image = cv2.imread(str(image_path))
        if image is None:
            return None

        height, width = image.shape[:2]

        result = self.ocr.ocr(str(image_path), cls=True)

        labels = []

        if result and result[0]:
            detected_keywords = {}

            for line in result[0]:
                box = line[0]
                text = line[1][0]
                confidence = line[1][1]

                x_coords = [point[0] for point in box]
                y_coords = [point[1] for point in box]

                x_min = min(x_coords)
                y_min = min(y_coords)
                x_max = max(x_coords)
                y_max = max(y_coords)

                for field_name, keywords in self.field_keywords.items():
                    if any(keyword in text for keyword in keywords):
                        if field_name not in detected_keywords:
                            detected_keywords[field_name] = {
                                'text': text,
                                'box': [x_min, y_min, x_max, y_max],
                                'confidence': confidence
                            }
                        break

            for field_name, detection in detected_keywords.items():
                x_min, y_min, x_max, y_max = detection['box']

                x_center = ((x_min + x_max) / 2) / width
                y_center = ((y_min + y_max) / 2) / height
                box_width = (x_max - x_min) / width
                box_height = (y_max - y_min) / height

                class_id = self.field_classes[field_name]

                label_value = f"{class_id} {x_center:.6f} {y_center:.6f} {box_width:.6f} {box_height:.6f}"
                labels.append({
                    'field': field_name,
                    'label': label_value,
                    'detected': True,
                    'confidence': detection['confidence']
                })

        for field_name, default_box in self.default_boxes.items():
            if field_name not in [l['field'] for l in labels]:
                class_id = self.field_classes[field_name]
                label_value = f"{class_id} {default_box['x']:.6f} {default_box['y']:.6f} {default_box['w']:.6f} {default_box['h']:.6f}"
                labels.append({
                    'field': field_name,
                    'label': label_value,
                    'detected': False,
                    'confidence': 0.0
                })

        labels.sort(key=lambda x: x['field'])

        return labels

    def label_dataset(self, split='Train'):
        images_path = self.dataset_path / split / "images"
        labels_path = self.dataset_path / split / "labels"

        labels_path.mkdir(parents=True, exist_ok=True)

        image_files = list(images_path.glob("*.png")) + list(images_path.glob("*.jpg"))

        print(f"\nProcessing {split} set ({len(image_files)} images)...")

        stats = {
            'total': len(image_files),
            'processed': 0,
            'failed': 0,
            'detected_fields': {field: 0 for field in self.field_classes.keys()}
        }

        for img_file in image_files:
            try:
                labels = self.label_image(img_file)

                if labels:
                    label_file = labels_path / f"{img_file.stem}.txt"

                    with open(label_file, 'w') as f:
                        for label_data in labels:
                            f.write(label_data['label'] + '\n')
                            if label_data['detected']:
                                stats['detected_fields'][label_data['field']] += 1

                    stats['processed'] += 1

                    if stats['processed'] % 5 == 0:
                        print(f"  Processed {stats['processed']}/{stats['total']} images")

                else:
                    stats['failed'] += 1
                    print(f"  Warning: Failed to process {img_file.name}")

            except Exception as e:
                stats['failed'] += 1
                print(f"  Error processing {img_file.name}: {e}")

        return stats

    def create_data_yaml(self):
        yaml_content = f"""# KTP Field Detection Dataset
path: {self.dataset_path.absolute()}
train: Train/images
val: Val/images
test: Test/images

# Classes
nc: {len(self.field_classes)}
names: {list(self.field_classes.keys())}
"""

        yaml_path = self.dataset_path / "data.yaml"
        with open(yaml_path, 'w') as f:
            f.write(yaml_content)

        print(f"\nCreated data.yaml at {yaml_path}")

    def print_stats(self, all_stats):
        print("\n" + "="*60)
        print("AUTO-LABELING STATISTICS")
        print("="*60)

        for split, stats in all_stats.items():
            print(f"\n{split} Set:")
            print(f"  Total images:    {stats['total']}")
            print(f"  Processed:       {stats['processed']}")
            print(f"  Failed:          {stats['failed']}")

            print(f"\n  Detected Fields:")
            for field, count in stats['detected_fields'].items():
                percentage = (count / stats['processed'] * 100) if stats['processed'] > 0 else 0
                print(f"    {field:20s}: {count:2d} ({percentage:5.1f}%)")


def main():
    dataset_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset"

    print("="*60)
    print("KTP AUTO-LABELING TOOL")
    print("="*60)
    print(f"Dataset path: {dataset_path}")

    labeler = Ktp_Auto_Labeler(dataset_path)

    all_stats = {}

    for split in ['Train', 'Val', 'Test']:
        images_path = Path(dataset_path) / split / "images"
        if images_path.exists():
            stats = labeler.label_dataset(split)
            all_stats[split] = stats

    labeler.create_data_yaml()
    labeler.print_stats(all_stats)

    print("\n" + "="*60)
    print("Auto-labeling complete!")
    print("="*60)
    print("\nNext steps:")
    print("1. Review generated labels in: dataset/*/labels/")
    print("2. Use manual annotation tool to correct if needed")
    print("3. Run training script: python scripts/train_yolo.py")


if __name__ == "__main__":
    main()
