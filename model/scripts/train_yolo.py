#!/usr/bin/env python3
"""
YOLOv8 Training Script for KTP Field Detection
Train custom YOLO model from scratch using KTP dataset
"""

import os
import sys
import yaml
from pathlib import Path
import random
import numpy as np
import shutil

try:
    from ultralytics import YOLO
    import torch
except ImportError:
    print("Error: Required packages not installed.")
    print("Please install: pip install ultralytics torch")
    sys.exit(1)


class Yolo_Trainer:
    def __init__(self, dataset_path, model_size='n'):
        self.dataset_path = Path(dataset_path)
        self.model_size = model_size

        self.model_variants = {
            'n': 'yolov8n.pt',  # Nano - fastest
            's': 'yolov8s.pt',  # Small
            'm': 'yolov8m.pt',  # Medium
            'l': 'yolov8l.pt',  # Large
            'x': 'yolov8x.pt'   # Extra Large - most accurate
        }

        self.hyperparameters = {
            'epochs': 100,
            'batch_size': 16,
            'image_size': 640,
            'learning_rate': 0.01,
            'patience': 20,
            'optimizer': 'AdamW',
            'weight_decay': 0.0005,
            'warmup_epochs': 3,
            'warmup_momentum': 0.8,
            'box_loss': 7.5,
            'cls_loss': 0.5,
            'dfl_loss': 1.5,
            'mosaic': 0.9,
            'mixup': 0.1,
            'hsv_h': 0.015,
            'hsv_s': 0.7,
            'hsv_v': 0.4,
            'degrees': 5.0,
            'translate': 0.1,
            'scale': 0.5,
            'shear': 2.0,
            'perspective': 0.0,
            'flipud': 0.0,
            'fliplr': 0.5,
            'bgr': 0.0,
            'mosaic': 1.0,
        }

    def prepare_data_yaml(self):
        data_yaml_path = self.dataset_path / "data.yaml"

        if not data_yaml_path.exists():
            print(f"Error: data.yaml not found at {data_yaml_path}")
            print("Please run auto_label.py first to generate labels and data.yaml")
            return None

        with open(data_yaml_path, 'r') as f:
            data_config = yaml.safe_load(f)

        return data_yaml_path

    def set_hyperparameters(self, custom_params=None):
        if custom_params:
            self.hyperparameters.update(custom_params)

        print("\nTraining Hyperparameters:")
        print("="*50)
        for key, value in self.hyperparameters.items():
            print(f"  {key:20s}: {value}")

    def train(self, name='ktp_field_detector', device='cpu'):
        data_yaml = self.prepare_data_yaml()
        if data_yaml is None:
            return

        print("\n" + "="*60)
        print("YOLOV8 TRAINING - KTP FIELD DETECTION")
        print("="*60)
        print(f"Model size: YOLOv8{self.model_size}")
        print(f"Device: {device.upper()}")
        print(f"Dataset: {self.dataset_path}")
        print(f"Epochs: {self.hyperparameters['epochs']}")
        print(f"Batch size: {self.hyperparameters['batch_size']}")

        pretrained_model = self.model_variants[self.model_size]
        print(f"\nLoading pretrained model: {pretrained_model}")

        try:
            model = YOLO(pretrained_model)

            results = model.train(
                data=str(data_yaml),
                epochs=self.hyperparameters['epochs'],
                batch=self.hyperparameters['batch_size'],
                imgsz=self.hyperparameters['image_size'],
                lr0=self.hyperparameters['learning_rate'],
                patience=self.hyperparameters['patience'],
                optimizer=self.hyperparameters['optimizer'],
                weight_decay=self.hyperparameters['weight_decay'],
                warmup_epochs=self.hyperparameters['warmup_epochs'],
                warmup_momentum=self.hyperparameters['warmup_momentum'],
                box=self.hyperparameters['box_loss'],
                cls=self.hyperparameters['cls_loss'],
                dfl=self.hyperparameters['dfl_loss'],
                mosaic=self.hyperparameters['mosaic'],
                mixup=self.hyperparameters['mixup'],
                hsv_h=self.hyperparameters['hsv_h'],
                hsv_s=self.hyperparameters['hsv_s'],
                hsv_v=self.hyperparameters['hsv_v'],
                degrees=self.hyperparameters['degrees'],
                translate=self.hyperparameters['translate'],
                scale=self.hyperparameters['scale'],
                shear=self.hyperparameters['shear'],
                perspective=self.hyperparameters['perspective'],
                flipud=self.hyperparameters['flipud'],
                fliplr=self.hyperparameters['fliplr'],
                bgr=self.hyperparameters['bgr'],
                name=name,
                project=str(self.dataset_path / 'runs'),
                device=device,
                verbose=True,
                plots=True,
                save=True,
                exist_ok=False
            )

            print("\n" + "="*60)
            print("TRAINING COMPLETE!")
            print("="*60)
            print(f"\nBest model saved at: {self.dataset_path / 'runs' / name / 'weights' / 'best.pt'}")

            return results

        except Exception as e:
            print(f"\nError during training: {e}")
            print("\nTroubleshooting:")
            print("1. Check if dataset has labels in YOLO format")
            print("2. Verify data.yaml configuration")
            print("3. Ensure sufficient disk space")
            print("4. Try smaller model size: model_size='n'")
            return None

    def resume_training(self, checkpoint_path, name='ktp_field_detector', device='cpu'):
        print(f"\nResuming training from: {checkpoint_path}")

        try:
            model = YOLO(checkpoint_path)
            data_yaml = self.prepare_data_yaml()

            if data_yaml is None:
                return

            results = model.train(
                data=str(data_yaml),
                epochs=self.hyperparameters['epochs'],
                batch=self.hyperparameters['batch_size'],
                imgsz=self.hyperparameters['image_size'],
                name=name,
                project=str(self.dataset_path / 'runs'),
                device=device,
                resume=True
            )

            return results

        except Exception as e:
            print(f"Error resuming training: {e}")
            return None

    def evaluate(self, model_path, split='val'):
        print(f"\nEvaluating model on {split} set...")

        try:
            model = YOLO(model_path)
            data_yaml = self.prepare_data_yaml()

            if data_yaml is None:
                return

            metrics = model.val(
                data=str(data_yaml),
                split=split,
                verbose=True
            )

            print("\n" + "="*60)
            print("EVALUATION RESULTS")
            print("="*60)
            print(f"mAP50:   {metrics.box.map50:.4f}")
            print(f"mAP50-95: {metrics.box.map:.4f}")
            print(f"Precision: {metrics.box.mp:.4f}")
            print(f"Recall:    {metrics.box.mr:.4f}")

            return metrics

        except Exception as e:
            print(f"Error during evaluation: {e}")
            return None

    def export_model(self, model_path, export_format='onnx'):
        print(f"\nExporting model to {export_format.upper()} format...")

        try:
            model = YOLO(model_path)

            output_path = model.export(
                format=export_format,
                simplify=True,
                dynamic=False,
                opset=12
            )

            print(f"Model exported successfully to: {output_path}")
            return output_path

        except Exception as e:
            print(f"Error exporting model: {e}")
            return None

    def optimize_hyperparameters(self, data_yaml, iterations=10):
        print("\nStarting hyperparameter optimization...")

        try:
            model = YOLO(self.model_variants[self.model_size])

            results = model.tune(
                data=str(data_yaml),
                space={
                    'lr0': (0.001, 0.1),
                    'batch': (8, 32),
                    'epochs': (50, 150)
                },
                iterations=iterations,
                optimizer='AdamW',
                device='cpu',
                plots=True,
                val=True
            )

            print("\nHyperparameter optimization complete!")
            print(f"Best configuration saved at: {self.dataset_path / 'runs' / 'tune'}")

            return results

        except Exception as e:
            print(f"Error during hyperparameter optimization: {e}")
            return None


def check_gpu():
    if torch.cuda.is_available():
        device = 'cuda'
        gpu_count = torch.cuda.device_count()
        gpu_name = torch.cuda.get_device_name(0)
        print(f"\nGPU detected: {gpu_name} ({gpu_count} device(s))")
        return device
    else:
        print("\nNo GPU detected, using CPU")
        return 'cpu'


def main():
    dataset_path = "D:/Semester 6/PA 3/Project/PA3/model/dataset"

    print("="*60)
    print("YOLOV8 TRAINING PIPELINE")
    print("="*60)
    print(f"Dataset: {dataset_path}")

    import argparse
    parser = argparse.ArgumentParser(description='Train YOLOv8 for KTP field detection')
    parser.add_argument('--model', type=str, default='n', choices=['n', 's', 'm', 'l', 'x'],
                        help='Model size (default: n - nano)')
    parser.add_argument('--epochs', type=int, default=100,
                        help='Number of epochs (default: 100)')
    parser.add_argument('--batch', type=int, default=16,
                        help='Batch size (default: 16)')
    parser.add_argument('--device', type=str, default='auto',
                        help='Device: auto, cpu, cuda (default: auto)')
    parser.add_argument('--name', type=str, default='ktp_field_detector',
                        help='Experiment name (default: ktp_field_detector)')
    parser.add_argument('--resume', type=str, default=None,
                        help='Path to checkpoint to resume training')
    parser.add_argument('--eval', type=str, default=None,
                        help='Path to model for evaluation')
    parser.add_argument('--export', type=str, default=None,
                        help='Path to model for export')

    args = parser.parse_args()

    device = args.device
    if device == 'auto':
        device = check_gpu()

    trainer = Yolo_Trainer(dataset_path, model_size=args.model)

    if args.eval:
        trainer.evaluate(args.eval)
    elif args.export:
        trainer.export_model(args.export)
    else:
        custom_params = {
            'epochs': args.epochs,
            'batch_size': args.batch,
        }
        trainer.set_hyperparameters(custom_params)

        if args.resume:
            trainer.resume_training(args.resume, name=args.name, device=device)
        else:
            trainer.train(name=args.name, device=device)


if __name__ == "__main__":
    main()
