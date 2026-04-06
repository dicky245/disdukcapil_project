#!/usr/bin/env python3
"""
Data Augmentation Script for KTP Dataset
Increase dataset size with various augmentation techniques
"""

import os
import sys
import random
from pathlib import Path
import cv2
import numpy as np
import json
from shutil import copy2


class Dataset_Augmenter:
    def __init__(self, dataset_path, augmentation_factor=5):
        self.dataset_path = Path(dataset_path)
        self.augmentation_factor = augmentation_factor

        self.augmentation_params = {
            'rotation': {'range': (-5, 5), 'probability': 0.7},
            'brightness': {'range': (0.7, 1.3), 'probability': 0.8},
            'contrast': {'range': (0.8, 1.2), 'probability': 0.7},
            'gaussian_noise': {'range': (0, 15), 'probability': 0.5},
            'gaussian_blur': {'range': (0, 1.0), 'probability': 0.4},
            'motion_blur': {'range': (0, 3), 'probability': 0.3},
            'perspective': {'probability': 0.3},
            'scale': {'range': (0.9, 1.1), 'probability': 0.5},
            'flip': {'horizontal': 0.0, 'vertical': 0.0}
        }

    def rotate_image(self, image, angle):
        height, width = image.shape[:2]
        center = (width // 2, height // 2)
        matrix = cv2.getRotationMatrix2D(center, angle, 1.0)
        rotated = cv2.warpAffine(image, matrix, (width, height),
                                  borderMode=cv2.BORDER_REFLECT)
        return rotated

    def adjust_brightness(self, image, factor):
        hsv = cv2.cvtColor(image, cv2.COLOR_BGR2HSV)
        h, s, v = cv2.split(hsv)
        v = cv2.multiply(v, factor)
        v = np.clip(v, 0, 255).astype('uint8')
        hsv_adjusted = cv2.merge([h, s, v])
        return cv2.cvtColor(hsv_adjusted, cv2.COLOR_HSV2BGR)

    def adjust_contrast(self, image, factor):
        lab = cv2.cvtColor(image, cv2.COLOR_BGR2LAB)
        l, a, b = cv2.split(lab)
        l = cv2.multiply(l, factor)
        l = np.clip(l, 0, 255).astype('uint8')
        lab_adjusted = cv2.merge([l, a, b])
        return cv2.cvtColor(lab_adjusted, cv2.COLOR_LAB2BGR)

    def add_gaussian_noise(self, image, mean=0, sigma=10):
        gauss = np.random.normal(mean, sigma, image.shape)
        gauss = gauss.reshape(image.shape).astype('uint8')
        noisy = cv2.add(image, gauss)
        return np.clip(noisy, 0, 255).astype('uint8')

    def add_gaussian_blur(self, image, kernel_size):
        if kernel_size == 0:
            return image
        kernel_size = int(kernel_size * 2) + 1
        return cv2.GaussianBlur(image, (kernel_size, kernel_size), 0)

    def add_motion_blur(self, image, kernel_size):
        if kernel_size == 0:
            return image
        kernel_size = int(kernel_size * 2) + 1
        kernel = np.zeros((kernel_size, kernel_size))
        kernel[int((kernel_size - 1) / 2), :] = np.ones(kernel_size)
        kernel /= kernel_size
        return cv2.filter2D(image, -1, kernel)

    def apply_perspective_transform(self, image):
        height, width = image.shape[:2]

        offset = random.randint(10, 30)
        src_points = np.float32([
            [0, 0],
            [width - 1, 0],
            [width - 1, height - 1],
            [0, height - 1]
        ])

        dst_points = np.float32([
            [random.randint(0, offset), random.randint(0, offset)],
            [random.randint(width - offset - 1, width - 1), random.randint(0, offset)],
            [random.randint(width - offset - 1, width - 1), random.randint(height - offset - 1, height - 1)],
            [random.randint(0, offset), random.randint(height - offset - 1, height - 1)]
        ])

        matrix = cv2.getPerspectiveTransform(src_points, dst_points)
        return cv2.warpPerspective(image, matrix, (width, height))

    def scale_image(self, image, factor):
        height, width = image.shape[:2]
        new_width = int(width * factor)
        new_height = int(height * factor)

        scaled = cv2.resize(image, (new_width, new_height))

        if factor > 1:
            start_x = (new_width - width) // 2
            start_y = (new_height - height) // 2
            return scaled[start_y:start_y + height, start_x:start_x + width]
        else:
            pad_x = (width - new_width) // 2
            pad_y = (height - new_height) // 2
            padded = cv2.copyMakeBorder(scaled, pad_y, height - new_height - pad_y,
                                       pad_x, width - new_width - pad_x,
                                       cv2.BORDER_REFLECT)
            return padded

    def augment_image(self, image, label_content):
        augmented_images = []
        augmented_labels = []

        for i in range(self.augmentation_factor):
            aug_image = image.copy()

            if random.random() < self.augmentation_params['rotation']['probability']:
                angle = random.uniform(*self.augmentation_params['rotation']['range'])
                aug_image = self.rotate_image(aug_image, angle)

            if random.random() < self.augmentation_params['brightness']['probability']:
                factor = random.uniform(*self.augmentation_params['brightness']['range'])
                aug_image = self.adjust_brightness(aug_image, factor)

            if random.random() < self.augmentation_params['contrast']['probability']:
                factor = random.uniform(*self.augmentation_params['contrast']['range'])
                aug_image = self.adjust_contrast(aug_image, factor)

            if random.random() < self.augmentation_params['gaussian_noise']['probability']:
                sigma = random.uniform(*self.augmentation_params['gaussian_noise']['range'])
                aug_image = self.add_gaussian_noise(aug_image, sigma=sigma)

            if random.random() < self.augmentation_params['gaussian_blur']['probability']:
                kernel = random.uniform(*self.augmentation_params['gaussian_blur']['range'])
                aug_image = self.add_gaussian_blur(aug_image, kernel)

            if random.random() < self.augmentation_params['motion_blur']['probability']:
                kernel = random.uniform(*self.augmentation_params['motion_blur']['range'])
                aug_image = self.add_motion_blur(aug_image, kernel)

            if random.random() < self.augmentation_params['perspective']['probability']:
                aug_image = self.apply_perspective_transform(aug_image)

            if random.random() < self.augmentation_params['scale']['probability']:
                factor = random.uniform(*self.augmentation_params['scale']['range'])
                aug_image = self.scale_image(aug_image, factor)

            augmented_images.append(aug_image)
            augmented_labels.append(label_content)

        return augmented_images, augmented_labels

    def augment_split(self, split='Train'):
        images_path = self.dataset_path / split / "images"
        labels_path = self.dataset_path / split / "labels"

        if not images_path.exists():
            print(f"Error: {split}/images folder not found")
            return

        image_files = list(images_path.glob("*.png")) + list(images_path.glob("*.jpg"))

        print(f"\nAugmenting {split} set...")
        print(f"Original images: {len(image_files)}")
        print(f"Augmentation factor: {self.augmentation_factor}")
        print(f"Expected total: {len(image_files) * (self.augmentation_factor + 1)}")

        stats = {
            'original': len(image_files),
            'augmented': 0,
            'total': 0
        }

        for img_file in image_files:
            try:
                image = cv2.imread(str(img_file))
                if image is None:
                    continue

                label_file = labels_path / f"{img_file.stem}.txt"
                if not label_file.exists():
                    continue

                with open(label_file, 'r') as f:
                    label_content = f.read()

                augmented_images, augmented_labels = self.augment_image(image, label_content)

                for idx, (aug_img, aug_label) in enumerate(zip(augmented_images, augmented_labels)):
                    aug_filename = f"{img_file.stem}_aug{idx}{img_file.suffix}"

                    aug_img_path = images_path / aug_filename
                    aug_label_path = labels_path / f"{img_file.stem}_aug{idx}.txt"

                    cv2.imwrite(str(aug_img_path), aug_img)

                    with open(aug_label_path, 'w') as f:
                        f.write(aug_label)

                    stats['augmented'] += 1

                if (stats['augmented'] + stats['original']) % 50 == 0:
                    current_total = stats['original'] + stats['augmented']
                    print(f"  Progress: {current_total} images generated")

            except Exception as e:
                print(f"  Error processing {img_file.name}: {e}")

        stats['total'] = stats['original'] + stats['augmented']

        print(f"\nAugmentation complete for {split} set:")
        print(f"  Original:  {stats['original']}")
        print(f"  Augmented: {stats['augmented']}")
        print(f"  Total:     {stats['total']}")

        return stats

    def augment_all_splits(self):
        print("\n" + "="*60)
        print("DATA AUGMENTATION PIPELINE")
        print("="*60)

        all_stats = {}

        for split in ['Train', 'Val']:
            split_path = self.dataset_path / split / "images"
            if split_path.exists():
                stats = self.augment_split(split)
                all_stats[split] = stats

        return all_stats


def main():
    dataset_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset"

    import argparse
    parser = argparse.ArgumentParser(description='Augment KTP dataset')
    parser.add_argument('--factor', type=int, default=5,
                        help='Augmentation factor (default: 5)')
    parser.add_argument('--split', type=str, default='all',
                        help='Dataset split to augment: Train, Val, or all (default: all)')

    args = parser.parse_args()

    augmenter = Dataset_Augmenter(dataset_path, augmentation_factor=args.factor)

    if args.split == 'all':
        all_stats = augmenter.augment_all_splits()

        print("\n" + "="*60)
        print("AUGMENTATION SUMMARY")
        print("="*60)
        for split, stats in all_stats.items():
            print(f"\n{split}:")
            print(f"  Original:  {stats['original']}")
            print(f"  Augmented: {stats['augmented']}")
            print(f"  Total:     {stats['total']}")
    else:
        augmenter.augment_split(args.split)


if __name__ == "__main__":
    main()
