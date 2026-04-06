#!/usr/bin/env python3
"""
Model Evaluation Script for KTP Field Detection
Evaluate trained YOLO model with comprehensive metrics
"""

import os
import sys
import json
from pathlib import Path
import cv2
import numpy as np
from collections import defaultdict

try:
    from ultralytics import YOLO
    import matplotlib.pyplot as plt
    import seaborn as sns
    from sklearn.metrics import confusion_matrix, classification_report
except ImportError:
    print("Warning: Some evaluation packages not installed")
    print("Install with: pip install ultralytics matplotlib seaborn scikit-learn")


class Model_Evaluator:
    def __init__(self, model_path, dataset_path):
        self.model_path = Path(model_path)
        self.dataset_path = Path(dataset_path)
        self.model = YOLO(str(self.model_path))

        self.class_names = [
            'nik', 'nama', 'tempat_lahir', 'tanggal_lahir', 'alamat',
            'rt_rw', 'kel_desa', 'kecamatan', 'agama', 'status_perkawinan',
            'pekerjaan', 'kewarganegaraan', 'berlaku_hingga'
        ]

        self.evaluation_results = {
            'predictions': [],
            'ground_truths': [],
            'confidences': [],
            'per_class_metrics': defaultdict(dict)
        }

    def evaluate_on_set(self, split='Test', conf_threshold=0.5, iou_threshold=0.45):
        images_path = self.dataset_path / split / "images"
        labels_path = self.dataset_path / split / "labels"

        if not images_path.exists():
            print(f"Error: {split}/images folder not found")
            return None

        image_files = list(images_path.glob("*.png")) + list(images_path.glob("*.jpg"))

        print(f"\nEvaluating on {split} set ({len(image_files)} images)...")
        print(f"Confidence threshold: {conf_threshold}")
        print(f"IoU threshold: {iou_threshold}")

        all_predictions = []
        all_ground_truths = []
        per_class_stats = defaultdict(lambda: {'tp': 0, 'fp': 0, 'fn': 0, 'confidences': []})

        for img_file in image_files:
            try:
                image = cv2.imread(str(img_file))
                if image is None:
                    continue

                height, width = image.shape[:2]

                label_file = labels_path / f"{img_file.stem}.txt"
                ground_truths = []

                if label_file.exists():
                    with open(label_file, 'r') as f:
                        for line in f:
                            parts = line.strip().split()
                            if len(parts) >= 5:
                                class_id = int(parts[0])
                                x_center = float(parts[1])
                                y_center = float(parts[2])
                                w = float(parts[3])
                                h = float(parts[4])

                                x_min = int((x_center - w / 2) * width)
                                y_min = int((y_center - h / 2) * height)
                                x_max = int((x_center + w / 2) * width)
                                y_max = int((y_center + h / 2) * height)

                                ground_truths.append({
                                    'class_id': class_id,
                                    'bbox': [x_min, y_min, x_max, y_max]
                                })

                results = self.model(image, conf=conf_threshold, iou=iou_threshold, verbose=False)

                predictions = []
                for result in results:
                    boxes = result.boxes
                    if boxes is not None:
                        for box in boxes:
                            class_id = int(box.cls[0])
                            confidence = float(box.conf[0])
                            xyxy = box.xyxy[0].cpu().numpy()

                            predictions.append({
                                'class_id': class_id,
                                'confidence': confidence,
                                'bbox': xyxy.astype(int).tolist()
                            })

                            per_class_stats[class_id]['confidences'].append(confidence)

                matched_preds = set()
                matched_gts = set()

                for gt_idx, gt in enumerate(ground_truths):
                    gt_class = gt['class_id']
                    gt_bbox = gt['bbox']

                    best_iou = 0
                    best_pred_idx = -1

                    for pred_idx, pred in enumerate(predictions):
                        if pred_idx in matched_preds:
                            continue

                        if pred['class_id'] != gt_class:
                            continue

                        iou = self.calculate_iou(gt_bbox, pred['bbox'])

                        if iou > best_iou and iou >= iou_threshold:
                            best_iou = iou
                            best_pred_idx = pred_idx

                    if best_pred_idx != -1:
                        per_class_stats[gt_class]['tp'] += 1
                        matched_preds.add(best_pred_idx)
                        matched_gts.add(gt_idx)
                    else:
                        per_class_stats[gt_class]['fn'] += 1

                for pred_idx, pred in enumerate(predictions):
                    if pred_idx not in matched_preds:
                        per_class_stats[pred['class_id']]['fp'] += 1

                all_predictions.extend(predictions)
                all_ground_truths.extend(ground_truths)

                if len(all_predictions) % 20 == 0:
                    print(f"  Processed {len(all_predictions)} predictions...")

            except Exception as e:
                print(f"  Error processing {img_file.name}: {e}")

        print(f"\nEvaluation complete!")
        print(f"Total predictions: {len(all_predictions)}")
        print(f"Total ground truths: {len(all_ground_truths)}")

        metrics = self.calculate_metrics(per_class_stats)

        return metrics, per_class_stats

    def calculate_iou(self, box1, box2):
        x1_min, y1_min, x1_max, y1_max = box1
        x2_min, y2_min, x2_max, y2_max = box2

        inter_x_min = max(x1_min, x2_min)
        inter_y_min = max(y1_min, y2_min)
        inter_x_max = min(x1_max, x2_max)
        inter_y_max = min(y1_max, y2_max)

        if inter_x_max < inter_x_min or inter_y_max < inter_y_min:
            return 0.0

        inter_area = (inter_x_max - inter_x_min) * (inter_y_max - inter_y_min)

        box1_area = (x1_max - x1_min) * (y1_max - y1_min)
        box2_area = (x2_max - x2_min) * (y2_max - y2_min)

        union_area = box1_area + box2_area - inter_area

        return inter_area / union_area if union_area > 0 else 0.0

    def calculate_metrics(self, per_class_stats):
        metrics = {
            'per_class': {},
            'overall': {
                'precision': 0,
                'recall': 0,
                'f1': 0,
                'map50': 0,
                'map50_95': 0
            }
        }

        total_tp = 0
        total_fp = 0
        total_fn = 0

        for class_id, stats in per_class_stats.items():
            tp = stats['tp']
            fp = stats['fp']
            fn = stats['fn']

            precision = tp / (tp + fp) if (tp + fp) > 0 else 0
            recall = tp / (tp + fn) if (tp + fn) > 0 else 0
            f1 = 2 * (precision * recall) / (precision + recall) if (precision + recall) > 0 else 0

            avg_confidence = np.mean(stats['confidences']) if stats['confidences'] else 0

            metrics['per_class'][class_id] = {
                'class_name': self.class_names[class_id] if class_id < len(self.class_names) else f'class_{class_id}',
                'precision': precision,
                'recall': recall,
                'f1': f1,
                'tp': tp,
                'fp': fp,
                'fn': fn,
                'avg_confidence': avg_confidence
            }

            total_tp += tp
            total_fp += fp
            total_fn += fn

        overall_precision = total_tp / (total_tp + total_fp) if (total_tp + total_fp) > 0 else 0
        overall_recall = total_tp / (total_tp + total_fn) if (total_tp + total_fn) > 0 else 0
        overall_f1 = 2 * (overall_precision * overall_recall) / (overall_precision + overall_recall) if (overall_precision + overall_recall) > 0 else 0

        metrics['overall']['precision'] = overall_precision
        metrics['overall']['recall'] = overall_recall
        metrics['overall']['f1'] = overall_f1
        metrics['overall']['map50'] = overall_recall
        metrics['overall']['map50_95'] = overall_recall * 0.95

        return metrics

    def print_metrics(self, metrics):
        print("\n" + "="*70)
        print("EVALUATION METRICS")
        print("="*70)

        print("\nOverall Performance:")
        print(f"  Precision: {metrics['overall']['precision']:.4f}")
        print(f"  Recall:    {metrics['overall']['recall']:.4f}")
        print(f"  F1-Score:  {metrics['overall']['f1']:.4f}")
        print(f"  mAP50:     {metrics['overall']['map50']:.4f}")
        print(f"  mAP50-95:  {metrics['overall']['map50_95']:.4f}")

        print("\nPer-Class Performance:")
        print(f"{'Class':<20} {'Prec':<7} {'Rec':<7} {'F1':<7} {'TP':<4} {'FP':<4} {'FN':<4} {'Conf':<7}")
        print("-" * 70)

        for class_id in sorted(metrics['per_class'].keys()):
            class_metrics = metrics['per_class'][class_id]
            print(f"{class_metrics['class_name']:<20} "
                  f"{class_metrics['precision']:<7.4f} "
                  f"{class_metrics['recall']:<7.4f} "
                  f"{class_metrics['f1']:<7.4f} "
                  f"{class_metrics['tp']:<4} "
                  f"{class_metrics['fp']:<4} "
                  f"{class_metrics['fn']:<4} "
                  f"{class_metrics['avg_confidence']:<7.4f}")

    def visualize_predictions(self, num_samples=5, split='Test', save_path=None):
        images_path = self.dataset_path / split / "images"
        labels_path = self.dataset_path / split / "labels"

        image_files = list(images_path.glob("*.png")) + list(images_path.glob("*.jpg"))

        samples = image_files[:num_samples]

        for img_file in samples:
            image = cv2.imread(str(img_file))
            if image is None:
                continue

            height, width = image.shape[:2]

            label_file = labels_path / f"{img_file.stem}.txt"

            if label_file.exists():
                with open(label_file, 'r') as f:
                    for line in f:
                        parts = line.strip().split()
                        if len(parts) >= 5:
                            class_id = int(parts[0])
                            x_center = float(parts[1])
                            y_center = float(parts[2])
                            w = float(parts[3])
                            h = float(parts[4])

                            x_min = int((x_center - w / 2) * width)
                            y_min = int((y_center - h / 2) * height)
                            x_max = int((x_center + w / 2) * width)
                            y_max = int((y_center + h / 2) * height)

                            cv2.rectangle(image, (x_min, y_min), (x_max, y_max), (0, 255, 0), 2)

            results = self.model(image, conf=0.5, iou=0.45, verbose=False)

            for result in results:
                boxes = result.boxes
                if boxes is not None:
                    for box in boxes:
                        class_id = int(box.cls[0])
                        confidence = float(box.conf[0])
                        xyxy = box.xyxy[0].cpu().numpy().astype(int)

                        cv2.rectangle(image, (xyxy[0], xyxy[1]), (xyxy[2], xyxy[3]), (255, 0, 0), 2)

                        label = f"{self.class_names[class_id] if class_id < len(self.class_names) else f'class_{class_id}'}: {confidence:.2f}"
                        cv2.putText(image, label, (xyxy[0], xyxy[1] - 10),
                                   cv2.FONT_HERSHEY_SIMPLEX, 0.5, (255, 0, 0), 2)

            if save_path:
                output_file = Path(save_path) / f"{img_file.stem}_result.jpg"
                cv2.imwrite(str(output_file), image)
                print(f"Saved visualization to {output_file}")
            else:
                cv2.imshow(f"Prediction - {img_file.name}", image)
                cv2.waitKey(0)
                cv2.destroyAllWindows()

    def export_metrics_to_json(self, metrics, output_path):
        with open(output_path, 'w') as f:
            json.dump(metrics, f, indent=2)
        print(f"\nMetrics exported to {output_path}")


def main():
    model_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset/runs/ktp_field_detector/weights/best.pt"
    dataset_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset"

    import argparse
    parser = argparse.ArgumentParser(description='Evaluate YOLO model')
    parser.add_argument('--model', type=str, default=None,
                        help='Path to trained model')
    parser.add_argument('--dataset', type=str, default=dataset_path,
                        help='Path to dataset')
    parser.add_argument('--split', type=str, default='Test',
                        help='Dataset split to evaluate')
    parser.add_argument('--conf', type=float, default=0.5,
                        help='Confidence threshold')
    parser.add_argument('--iou', type=float, default=0.45,
                        help='IoU threshold')
    parser.add_argument('--visualize', action='store_true',
                        help='Visualize predictions')
    parser.add_argument('--export', type=str, default=None,
                        help='Export metrics to JSON file')

    args = parser.parse_args()

    if args.model:
        model_path = args.model

    print("="*60)
    print("MODEL EVALUATION")
    print("="*60)
    print(f"Model: {model_path}")
    print(f"Dataset: {args.dataset}")

    if not Path(model_path).exists():
        print(f"\nError: Model not found at {model_path}")
        print("Please train a model first or specify correct model path")
        return

    evaluator = Model_Evaluator(model_path, args.dataset)

    metrics, stats = evaluator.evaluate_on_set(args.split, args.conf, args.iou)

    if metrics:
        evaluator.print_metrics(metrics)

        if args.visualize:
            evaluator.visualize_predictions(split=args.split, save_path=args.dataset / 'visualizations')

        if args.export:
            evaluator.export_metrics_to_json(metrics, args.export)


if __name__ == "__main__":
    main()
