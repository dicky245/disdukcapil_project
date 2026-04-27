<?php
$oldFile = __DIR__ . '/database/migrations/2024_01_01_000001_add_ocr_fields_to_antrian_online_table.php';
$newFile = __DIR__ . '/database/migrations/_disabled_2024_01_01_000001_add_ocr_fields_to_antrian_online_table.php';

if (file_exists($oldFile)) {
    rename($oldFile, $newFile);
    echo "File renamed successfully\n";
} else {
    echo "File not found: " . $oldFile . "\n";
}
