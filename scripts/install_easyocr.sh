#!/bin/bash

# =====================================================
# EasyOCR Installation Script for Laravel Server
# =====================================================
# 
# Usage:
#   chmod +x install_easyocr.sh
#   ./install_easyocr.sh
#
# Tested on:
#   - Ubuntu 20.04/22.04
#   - Debian 11+
#   - CentOS 8+
# =====================================================

set -e

echo "============================================"
echo "  EasyOCR Installation Script"
echo "============================================"
echo ""

# Colors
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Functions
info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

warn() {
    echo -e "${YELLOW}[WARN]${NC} $1"
}

error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Check if running as root
if [ "$EUID" -ne 0 ]; then 
    warn "Please run as root (sudo)"
    exit 1
fi

# Detect OS
if [ -f /etc/os-release ]; then
    . /etc/os-release
    OS=$ID
    VERSION=$VERSION_ID
else
    error "Cannot detect OS"
    exit 1
fi

info "Detected OS: $OS $VERSION"

# Update system
info "Updating system packages..."
if [ "$OS" == "ubuntu" ] || [ "$OS" == "debian" ]; then
    apt-get update
    apt-get upgrade -y
elif [ "$OS" == "centos" ] || [ "$OS" == "rhel" ] || [ "$OS" == "rocky" ]; then
    dnf update -y
fi

# Install Python
info "Installing Python and pip..."
if [ "$OS" == "ubuntu" ] || [ "$OS" == "debian" ]; then
    apt-get install -y python3 python3-pip python3-venv
elif [ "$OS" == "centos" ] || [ "$OS" == "rhel" ] || [ "$OS" == "rocky" ]; then
    dnf install -y python3 python3-pip
fi

# Create virtual environment (recommended)
info "Creating Python virtual environment..."
python3 -m venv venv
source venv/bin/activate

# Upgrade pip
info "Upgrading pip..."
pip install --upgrade pip

# Install OpenCV dependencies
info "Installing OpenCV dependencies..."
if [ "$OS" == "ubuntu" ] || [ "$OS" == "debian" ]; then
    apt-get install -y libgl1-mesa-glx libglib2.0-0 libsm6 libxext6 libxrender-dev
elif [ "$OS" == "centos" ] || [ "$OS" == "rhel" ] || [ "$OS" == "rocky" ]; then
    dnf install -y mesa-libGL glib2 libSM libXext libXrender
fi

# Install EasyOCR
info "Installing EasyOCR (this may take a few minutes)..."
pip install easyocr

# Verify installation
info "Verifying installation..."
python3 -c "import easyocr; print('EasyOCR version:', easyocr.__version__)"

# Test EasyOCR
info "Testing EasyOCR with sample image..."
cat > /tmp/test_easyocr.py << 'EOF'
import easyocr
import sys

try:
    reader = easyocr.Reader(['id', 'en'], gpu=False, verbose=False)
    print("✅ EasyOCR initialized successfully")
    print("✅ Model languages: Indonesian (id), English (en)")
    sys.exit(0)
except Exception as e:
    print(f"❌ Error: {e}")
    sys.exit(1)
EOF

python3 /tmp/test_easyocr.py

# Create symlink for easy access
info "Creating symlinks..."
ln -sf $(which python3) /usr/local/bin/python-ocr 2>/dev/null || true

# Update Laravel .env
info "Updating Laravel configuration..."
LARAVEL_ENV=".env"

if [ -f "$LARAVEL_ENV" ]; then
    if ! grep -q "EASYOCR_MOCK_ENABLED" "$LARAVEL_ENV"; then
        echo "" >> "$LARAVEL_ENV"
        echo "# EasyOCR Configuration" >> "$LARAVEL_ENV"
        echo "EASYOCR_MOCK_ENABLED=false" >> "$LARAVEL_ENV"
        echo "EASYOCR_PYTHON_PATH=python3" >> "$LARAVEL_ENV"
        echo "EASYOCR_USE_GPU=false" >> "$LARAVEL_ENV"
        echo "EASYOCR_TIMEOUT=120" >> "$LARAVEL_ENV"
        info "Added EasyOCR config to .env"
    else
        warn "EasyOCR config already exists in .env"
    fi
else
    warn ".env file not found"
fi

# Clear Laravel cache
info "Clearing Laravel cache..."
php artisan config:clear 2>/dev/null || true
php artisan cache:clear 2>/dev/null || true

echo ""
echo "============================================"
echo "  ✅ Installation Complete!"
echo "============================================"
echo ""
echo "Next steps:"
echo "  1. Activate virtual environment: source venv/bin/activate"
echo "  2. Test OCR: python scripts/easyocr_ktp.py /path/to/ktp.jpg"
echo "  3. Test Laravel: php artisan ocr:test-easyocr"
echo ""
echo "To use GPU acceleration (optional):"
echo "  pip install torch torchvision --index-url https://download.pytorch.org/whl/cu118"
echo ""
echo "============================================"
