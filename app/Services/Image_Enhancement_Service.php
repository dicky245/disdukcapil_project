<?php

namespace App\Services;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Image_Enhancement_Service
{
    protected ImageManager $manager;
    protected string $tempDisk;

    public function __construct()
    {
        $this->manager = new ImageManager(new Driver());
        $this->tempDisk = 'temporary';
    }

    /**
     * Process image untuk OCR dengan 5 tahap preprocessing
     *
     * @param string $imagePath - Path ke gambar asli
     * @param array $options - Preprocessing options
     * @return array - ['success' => bool, 'path' => string, 'metadata' => array]
     */
    public function Process_Image_For_Ocr(string $imagePath, array $options = []): array
    {
        try {
            // Load image
            $image = $this->manager->read($imagePath);

            // Metadata original
            $metadata = [
                'original_width' => $image->width(),
                'original_height' => $image->height(),
                'original_size' => filesize($imagePath),
                'processing_steps' => [],
            ];

            // Step 1: Grayscale Conversion
            if ($options['grayscale'] ?? true) {
                $image = $this->Convert_To_Grayscale($image);
                $metadata['processing_steps'][] = 'grayscale';
            }

            // Step 2: Denoising
            if ($options['denoising'] ?? true) {
                $blurRadius = $options['blur_radius'] ?? 1;
                $image = $this->Apply_Denoising($image, $blurRadius);
                $metadata['processing_steps'][] = 'denoising';
            }

            // Step 3: Contrast Enhancement
            if ($options['contrast'] ?? true) {
                $contrastLevel = $options['contrast_level'] ?? 15;
                $image = $this->Enhance_Contrast($image, $contrastLevel);
                $metadata['processing_steps'][] = 'contrast_enhancement';
            }

            // Step 4: Sharpness Enhancement
            if ($options['sharpen'] ?? true) {
                $image = $this->Enhance_Sharpness($image);
                $metadata['processing_steps'][] = 'sharpening';
            }

            // Step 5: Adaptive Thresholding (Binarization)
            if ($options['threshold'] ?? true) {
                $threshold = $options['threshold_level'] ?? 128;
                $image = $this->Apply_Thresholding($image, $threshold);
                $metadata['processing_steps'][] = 'thresholding';
            }

            // Save ke temporary storage
            $filename = $this->Generate_Temporary_Filename($imagePath);
            $savedPath = $this->Save_Temporary_Image($image, $filename);

            // Get enhanced image metadata
            $metadata['enhanced_size'] = Storage::disk($this->tempDisk)->size($savedPath);
            $metadata['saved_path'] = $savedPath;
            $metadata['processed_at'] = Carbon::now()->toIso8601String();

            return [
                'success' => true,
                'path' => $savedPath,
                'full_path' => Storage::disk($this->tempDisk)->path($savedPath),
                'url' => Storage::disk($this->tempDisk)->url($savedPath),
                'metadata' => $metadata,
            ];

        } catch (\Exception $e) {
            return [
                'success' => false,
                'error' => 'Gagal memproses gambar: ' . $e->getMessage(),
                'metadata' => $metadata ?? [],
            ];
        }
    }

    /**
     * Convert image ke grayscale
     *
     * @param mixed $image - Intervention Image instance
     * @return mixed - Processed image
     */
    protected function Convert_To_Grayscale($image)
    {
        return $image->greyscale();
    }

    /**
     * Apply Gaussian blur untuk denoising
     *
     * @param mixed $image - Intervention Image instance
     * @param int $radius - Blur radius (1-5)
     * @return mixed - Processed image
     */
    protected function Apply_Denoising($image, int $radius = 1)
    {
        return $image->blur($radius);
    }

    /**
     * Enhance contrast dengan contrast stretch
     *
     * @param mixed $image - Intervention Image instance
     * @param int $level - Brightness level (0-50)
     * @return mixed - Processed image
     */
    protected function Enhance_Contrast($image, int $level = 15)
    {
        // Intervention Image v3 tidak punya direct contrast method
        // Gunakan brightness adjustment sebagai workaround
        return $image->brightness($level);
    }

    /**
     * Enhance sharpness dengan convolution kernel
     *
     * @param mixed $image - Intervention Image instance
     * @return mixed - Processed image
     */
    protected function Enhance_Sharpness($image)
    {
        // Sharpening kernel dengan intensity 15
        return $image->sharpen(15);
    }

    /**
     * Apply adaptive thresholding (binarization)
     *
     * @param mixed $image - Intervention Image instance
     * @param int $threshold - Threshold level (0-255)
     * @return mixed - Processed image
     */
    protected function Apply_Thresholding($image, int $threshold = 128)
    {
        // Karena Intervention Image tidak punya direct threshold method,
        // kita gunakan kombinasi brightness dan contrast untuk efek binarization

        // Kurangi brightness untuk membuat gelap
        // Tambah contrast untuk memisahkan foreground/background
        return $image->brightness(-10)->contrast(30);
    }

    /**
     * Generate temporary filename dengan UUID
     *
     * @param string $originalPath - Original image path
     * @return string - Generated filename
     */
    protected function Generate_Temporary_Filename(string $originalPath): string
    {
        $extension = pathinfo($originalPath, PATHINFO_EXTENSION);
        $uuid = (string) Str::uuid();
        $date = date('Y-m-d');

        return "ocr_preprocessed/{$date}/{$uuid}.{$extension}";
    }

    /**
     * Save image ke temporary storage
     *
     * @param mixed $image - Intervention Image instance
     * @param string $filename - Target filename
     * @return string - Saved path
     */
    protected function Save_Temporary_Image($image, string $filename): string
    {
        // Ensure directory exists
        $directory = dirname($filename);
        if (!Storage::disk($this->tempDisk)->exists($directory)) {
            Storage::disk($this->tempDisk)->makeDirectory($directory);
        }

        // Save image
        $tempPath = Storage::disk($this->tempDisk)->path($filename);
        $image->save($tempPath);

        return $filename;
    }

    /**
     * Cleanup temporary files yang lebih lama dari X menit
     *
     * @param int $olderThanMinutes - Cleanup files older than this
     * @return int - Number of deleted files
     */
    public function Cleanup_Temporary_Files(int $olderThanMinutes = 30): int
    {
        $path = storage_path('app/temporary/ocr_preprocessed');
        $cutoff = Carbon::now()->subMinutes($olderThanMinutes);
        $deletedCount = 0;

        if (!file_exists($path)) {
            return 0;
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $file) {
            if ($file->isFile()) {
                $fileTime = Carbon::createFromTimestamp($file->getMTime());
                if ($fileTime->lt($cutoff)) {
                    unlink($file->getPathname());
                    $deletedCount++;
                }
            }
        }

        // Cleanup empty directories
        $directories = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
            \RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($directories as $directory) {
            if ($directory->isDir() && count(scandir($directory->getPathname())) <= 2) {
                rmdir($directory->getPathname());
            }
        }

        return $deletedCount;
    }
}
