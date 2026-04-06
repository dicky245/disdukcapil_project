#!/usr/bin/env python3
"""
Main Training Pipeline for KTP Field Detection
Orchestrate complete training workflow: prepare data -> label -> augment -> train -> evaluate
"""

import os
import sys
import yaml
import argparse
from pathlib import Path
import subprocess


class Training_Pipeline:
    def __init__(self, base_path):
        self.base_path = Path(base_path)
        self.dataset_path = self.base_path / "dataset"
        self.scripts_path = self.base_path / "scripts"

        self.config_path = self.base_path / "training_config.yaml"
        self.config = self.load_config()

    def load_config(self):
        if self.config_path.exists():
            with open(self.config_path, 'r') as f:
                return yaml.safe_load(f)
        return None

    def print_header(self, title):
        print("\n" + "="*70)
        print(f"  {title}")
        print("="*70)

    def step_1_prepare_dataset(self):
        self.print_header("STEP 1: PREPARE DATASET")

        script_path = self.scripts_path / "prepare_dataset.py"

        if not script_path.exists():
            print(f"Error: Script not found: {script_path}")
            return False

        print("Organizing dataset structure...")

        try:
            result = subprocess.run(
                [sys.executable, str(script_path)],
                capture_output=True,
                text=True,
                timeout=60
            )

            print(result.stdout)
            if result.returncode != 0:
                print(f"Error: {result.stderr}")
                return False

            print("Dataset structure prepared successfully!")
            return True

        except Exception as e:
            print(f"Error preparing dataset: {e}")
            return False

    def step_2_auto_label(self):
        self.print_header("STEP 2: AUTO-LABELING")

        script_path = self.scripts_path / "auto_label.py"

        if not script_path.exists():
            print(f"Warning: Script not found: {script_path}")
            print("Skipping auto-labeling...")
            return True

        print("Generating YOLO format labels...")

        try:
            result = subprocess.run(
                [sys.executable, str(script_path)],
                capture_output=True,
                text=True,
                timeout=300
            )

            print(result.stdout)
            if result.returncode != 0:
                print(f"Warning: Auto-labeling had issues")
                print(result.stderr)
                return True

            print("Auto-labeling complete!")
            return True

        except Exception as e:
            print(f"Warning: Auto-labeling failed: {e}")
            print("You can manually label the dataset or use default coordinates")
            return True

    def step_3_augment_dataset(self, factor=5):
        self.print_header("STEP 3: DATA AUGMENTATION")

        script_path = self.scripts_path / "augment_dataset.py"

        if not script_path.exists():
            print(f"Error: Script not found: {script_path}")
            return False

        print(f"Augmenting dataset (factor: {factor})...")

        try:
            result = subprocess.run(
                [sys.executable, str(script_path), '--factor', str(factor)],
                capture_output=True,
                text=True,
                timeout=600
            )

            print(result.stdout)
            if result.returncode != 0:
                print(f"Error: {result.stderr}")
                return False

            print("Data augmentation complete!")
            return True

        except Exception as e:
            print(f"Error augmenting dataset: {e}")
            return False

    def step_4_train_model(self, model_size='n', epochs=100, batch=16, device='auto'):
        self.print_header("STEP 4: TRAIN YOLOV8 MODEL")

        script_path = self.scripts_path / "train_yolo.py"

        if not script_path.exists():
            print(f"Error: Script not found: {script_path}")
            return False

        print(f"Training YOLOv8{model_size} model...")
        print(f"Epochs: {epochs}, Batch: {batch}, Device: {device}")

        try:
            cmd = [
                sys.executable, str(script_path),
                '--model', model_size,
                '--epochs', str(epochs),
                '--batch', str(batch),
                '--device', device,
                '--name', 'ktp_field_detector'
            ]

            print(f"\nRunning: {' '.join(cmd)}\n")

            result = subprocess.run(
                cmd,
                capture_output=False,
                text=True,
                timeout=7200
            )

            if result.returncode != 0:
                print(f"Error during training")
                return False

            print("\nTraining complete!")
            return True

        except subprocess.TimeoutExpired:
            print("Error: Training timeout (2 hours)")
            return False
        except Exception as e:
            print(f"Error during training: {e}")
            return False

    def step_5_evaluate_model(self, model_path=None):
        self.print_header("STEP 5: EVALUATE MODEL")

        script_path = self.scripts_path / "evaluate_model.py"

        if not script_path.exists():
            print(f"Warning: Script not found: {script_path}")
            return True

        if model_path is None:
            model_path = self.dataset_path / "runs" / "ktp_field_detector" / "weights" / "best.pt"

        if not model_path.exists():
            print(f"Warning: Model not found at {model_path}")
            print("Skipping evaluation...")
            return True

        print(f"Evaluating model: {model_path}")

        try:
            result = subprocess.run(
                [sys.executable, str(script_path), '--model', str(model_path)],
                capture_output=True,
                text=True,
                timeout=600
            )

            print(result.stdout)
            if result.returncode != 0:
                print(f"Warning: Evaluation had issues")
                print(result.stderr)
                return True

            print("Evaluation complete!")
            return True

        except Exception as e:
            print(f"Warning: Evaluation failed: {e}")
            return True

    def step_6_export_model(self, model_path=None, export_format='onnx'):
        self.print_header("STEP 6: EXPORT MODEL")

        if model_path is None:
            model_path = self.dataset_path / "runs" / "ktp_field_detector" / "weights" / "best.pt"

        if not model_path.exists():
            print(f"Warning: Model not found at {model_path}")
            print("Skipping export...")
            return True

        print(f"Exporting model to {export_format.upper()} format...")

        try:
            from ultralytics import YOLO
            model = YOLO(str(model_path))

            output_path = model.export(
                format=export_format,
                simplify=True,
                dynamic=False,
                opset=12
            )

            print(f"Model exported successfully to: {output_path}")
            return True

        except Exception as e:
            print(f"Warning: Export failed: {e}")
            return True

    def run_full_pipeline(self, skip_prepare=False, skip_label=False,
                          augment_factor=5, model_size='n',
                          epochs=100, batch=16, device='auto',
                          export_format='onnx'):
        self.print_header("KTP FIELD DETECTION - TRAINING PIPELINE")

        print(f"\nConfiguration:")
        print(f"  Base path:        {self.base_path}")
        print(f"  Dataset path:     {self.dataset_path}")
        print(f"  Model size:       YOLOv8{model_size}")
        print(f"  Epochs:           {epochs}")
        print(f"  Batch size:       {batch}")
        print(f"  Device:           {device}")
        print(f"  Augmentation:     {augment_factor}x")
        print(f"  Export format:    {export_format}")

        steps_completed = []

        if not skip_prepare:
            if self.step_1_prepare_dataset():
                steps_completed.append("Dataset preparation")
            else:
                print("\nError: Dataset preparation failed. Aborting pipeline.")
                return False

        if not skip_label:
            if self.step_2_auto_label():
                steps_completed.append("Auto-labeling")
            else:
                print("\nWarning: Auto-labeling failed. Continuing anyway...")

        if augment_factor > 0:
            if self.step_3_augment_dataset(augment_factor):
                steps_completed.append("Data augmentation")
            else:
                print("\nWarning: Data augmentation failed. Continuing with original dataset...")

        if self.step_4_train_model(model_size, epochs, batch, device):
            steps_completed.append("Model training")
        else:
            print("\nError: Model training failed. Aborting pipeline.")
            return False

        if self.step_5_evaluate_model():
            steps_completed.append("Model evaluation")

        if self.step_6_export_model(export_format=export_format):
            steps_completed.append(f"Model export ({export_format})")

        self.print_header("PIPELINE COMPLETE")

        print("\nSteps completed:")
        for i, step in enumerate(steps_completed, 1):
            print(f"  {i}. {step}")

        print("\n" + "="*70)
        print("TRAINING PIPELINE FINISHED SUCCESSFULLY!")
        print("="*70)

        print("\nNext steps:")
        print("1. Check model performance in: dataset/runs/ktp_field_detector/")
        print("2. Use trained model in Laravel OCR system")
        print("3. Fine-tune hyperparameters if needed")

        model_path = self.dataset_path / "runs" / "ktp_field_detector" / "weights" / "best.pt"
        print(f"\nTrained model saved at: {model_path}")

        export_path = self.dataset_path / "runs" / "ktp_field_detector" / "weights" / f"best.{export_format}"
        print(f"Exported model saved at: {export_path}")

        return True


def check_dependencies():
    print("Checking dependencies...")

    missing = []

    try:
        import ultralytics
        print("  [OK] ultralytics")
    except ImportError:
        missing.append("ultralytics")
        print("  [MISSING] ultralytics")

    try:
        import torch
        print("  [OK] torch")
        if torch.cuda.is_available():
            print(f"  [OK] CUDA available (GPU detected)")
    except ImportError:
        missing.append("torch")
        print("  [MISSING] torch")

    try:
        import cv2
        print("  [OK] opencv-python")
    except ImportError:
        missing.append("opencv-python")
        print("  [MISSING] opencv-python")

    try:
        import yaml
        print("  [OK] pyyaml")
    except ImportError:
        missing.append("pyyaml")
        print("  [MISSING] pyyaml")

    if missing:
        print(f"\nMissing dependencies: {', '.join(missing)}")
        print("Install with: pip install " + " ".join(missing))
        return False

    print("\nAll dependencies installed!")
    return True


def main():
    base_path = "D:/Semester 6/PA 3/Project/PA3/model"

    parser = argparse.ArgumentParser(description='Complete training pipeline for KTP field detection')
    parser.add_argument('--base-path', type=str, default=base_path,
                        help='Base path for the project')
    parser.add_argument('--skip-prepare', action='store_true',
                        help='Skip dataset preparation')
    parser.add_argument('--skip-label', action='store_true',
                        help='Skip auto-labeling')
    parser.add_argument('--augment', type=int, default=5,
                        help='Augmentation factor (default: 5, use 0 to disable)')
    parser.add_argument('--model', type=str, default='n', choices=['n', 's', 'm', 'l', 'x'],
                        help='Model size (default: n - nano)')
    parser.add_argument('--epochs', type=int, default=100,
                        help='Number of training epochs (default: 100)')
    parser.add_argument('--batch', type=int, default=16,
                        help='Batch size (default: 16)')
    parser.add_argument('--device', type=str, default='auto',
                        help='Device: auto, cpu, cuda (default: auto)')
    parser.add_argument('--export', type=str, default='onnx',
                        help='Export format: onnx, torchscript (default: onnx)')
    parser.add_argument('--check-only', action='store_true',
                        help='Only check dependencies, do not run pipeline')

    args = parser.parse_args()

    print("="*70)
    print("  KTP FIELD DETECTION - TRAINING PIPELINE")
    print("="*70)

    if not check_dependencies():
        print("\nPlease install missing dependencies before running the pipeline")
        return 1

    if args.check_only:
        print("\nDependency check complete. All systems ready!")
        return 0

    pipeline = Training_Pipeline(args.base_path)

    success = pipeline.run_full_pipeline(
        skip_prepare=args.skip_prepare,
        skip_label=args.skip_label,
        augment_factor=args.augment,
        model_size=args.model,
        epochs=args.epochs,
        batch=args.batch,
        device=args.device,
        export_format=args.export
    )

    return 0 if success else 1


if __name__ == "__main__":
    sys.exit(main())
