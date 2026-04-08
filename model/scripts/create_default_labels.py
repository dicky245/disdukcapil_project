#!/usr/bin/env python3
"""
Simple Label Generator for KTP Dataset
Generate YOLO format labels using default coordinates
"""

import os
import sys
from pathlib import Path

def create_default_labels(dataset_path):
    dataset_path = Path(dataset_path)

    # Default coordinates for 800x500 image (normalized)
    default_boxes = {
        'nik': {'class_id': 0, 'x': 0.475, 'y': 0.11, 'w': 0.50, 'h': 0.06},
        'nama': {'class_id': 1, 'x': 0.625, 'y': 0.19, 'w': 0.56, 'h': 0.05},
        'tempat_lahir': {'class_id': 2, 'x': 0.475, 'y': 0.25, 'w': 0.25, 'h': 0.04},
        'tanggal_lahir': {'class_id': 3, 'x': 0.665, 'y': 0.25, 'w': 0.22, 'h': 0.04},
        'alamat': {'class_id': 4, 'x': 0.475, 'y': 0.31, 'w': 0.75, 'h': 0.10},
        'rt_rw': {'class_id': 5, 'x': 0.445, 'y': 0.42, 'w': 0.19, 'h': 0.04},
        'kel_desa': {'class_id': 6, 'x': 0.54, 'y': 0.48, 'w': 0.38, 'h': 0.04},
        'kecamatan': {'class_id': 7, 'x': 0.54, 'y': 0.54, 'w': 0.38, 'h': 0.04},
        'agama': {'class_id': 8, 'x': 0.445, 'y': 0.60, 'w': 0.19, 'h': 0.04},
        'status_perkawinan': {'class_id': 9, 'x': 0.475, 'y': 0.66, 'w': 0.25, 'h': 0.04},
        'pekerjaan': {'class_id': 10, 'x': 0.505, 'y': 0.72, 'w': 0.31, 'h': 0.04},
        'kewarganegaraan': {'class_id': 11, 'x': 0.445, 'y': 0.78, 'w': 0.19, 'h': 0.04},
        'berlaku_hingga': {'class_id': 12, 'x': 0.475, 'y': 0.84, 'w': 0.25, 'h': 0.04}
    }

    class_names = list(default_boxes.keys())

    for split in ['Train', 'Val', 'Test']:
        images_path = dataset_path / split / "images"
        labels_path = dataset_path / split / "labels"

        if not images_path.exists():
            continue

        labels_path.mkdir(parents=True, exist_ok=True)

        image_files = list(images_path.glob("*.png")) + list(images_path.glob("*.jpg"))

        print(f"\nGenerating labels for {split} set ({len(image_files)} images)...")

        for img_file in image_files:
            label_file = labels_path / f"{img_file.stem}.txt"

            # Skip if label already exists
            if label_file.exists():
                continue

            # Write default labels
            with open(label_file, 'w') as f:
                for field_name, box in default_boxes.items():
                    class_id = box['class_id']
                    x = box['x']
                    y = box['y']
                    w = box['w']
                    h = box['h']
                    f.write(f"{class_id} {x:.6f} {y:.6f} {w:.6f} {h:.6f}\n")

            print(f"  Created: {label_file.name}")

    # Create data.yaml
    data_yaml_content = f"""# KTP Field Detection Dataset
path: {dataset_path.absolute()}
train: Train/images
val: Val/images
test: Test/images

# Classes
nc: {len(default_boxes)}
names: {class_names}
"""

    data_yaml_path = dataset_path / "data.yaml"
    with open(data_yaml_path, 'w') as f:
        f.write(data_yaml_content)

    print(f"\nCreated data.yaml at {data_yaml_path}")
    print(f"\nLabels generated successfully!")
    print(f"Total classes: {len(default_boxes)}")
    print(f"Class names: {class_names}")

if __name__ == "__main__":
    dataset_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset"
    create_default_labels(dataset_path)
