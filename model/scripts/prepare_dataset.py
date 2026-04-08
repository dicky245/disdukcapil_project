#!/usr/bin/env python3
"""
Prepare YOLO Dataset Structure
Move images from Train folder to Train/images and create labels directory
"""

import os
import sys
import shutil
from pathlib import Path
import random

def prepare_yolo_dataset(base_path):
    dataset_path = Path(base_path) / "dataset"
    train_path = dataset_path / "Train"
    val_path = dataset_path / "Val"
    test_path = dataset_path / "Test"

    for folder in [train_path, val_path, test_path]:
        (folder / "images").mkdir(parents=True, exist_ok=True)
        (folder / "labels").mkdir(parents=True, exist_ok=True)

    png_files = list(train_path.glob("*.png")) + list(train_path.glob("*.jpg")) + list(train_path.glob("*.jpeg"))

    print(f"Found {len(png_files)} images in Train folder")

    for img_file in png_files:
        if (train_path / "images" / img_file.name).exists():
            continue

        try:
            shutil.move(str(img_file), str(train_path / "images" / img_file.name))
            print(f"Moved: {img_file.name}")
        except Exception as e:
            print(f"Error moving {img_file.name}: {e}")

    random.seed(42)
    all_images = list((train_path / "images").glob("*.png")) + list((train_path / "images").glob("*.jpg"))
    random.shuffle(all_images)

    split_ratio = {
        'val': 0.2,
        'test': 0.1
    }

    total_images = len(all_images)
    val_count = int(total_images * split_ratio['val'])
    test_count = int(total_images * split_ratio['test'])

    val_images = all_images[:val_count]
    test_images = all_images[val_count:val_count + test_count]

    for img in val_images:
        label_file = img.parent.parent / "labels" / f"{img.stem}.txt"
        shutil.move(str(img), str(val_path / "images" / img.name))
        if label_file.exists():
            shutil.move(str(label_file), str(val_path / "labels" / f"{img.stem}.txt"))

    for img in test_images:
        label_file = img.parent.parent / "labels" / f"{img.stem}.txt"
        shutil.move(str(img), str(test_path / "images" / img.name))
        if label_file.exists():
            shutil.move(str(label_file), str(test_path / "labels" / f"{img.stem}.txt"))

    print(f"\nDataset split complete:")
    print(f"  Train: {len(list((train_path / 'images').glob('*')))} images")
    print(f"  Val:   {len(list((val_path / 'images').glob('*')))} images")
    print(f"  Test:  {len(list((test_path / 'images').glob('*')))} images")

if __name__ == "__main__":
    base_path = "D:/Semester 6/PA 3/Project/PA3/model"
    prepare_yolo_dataset(base_path)
