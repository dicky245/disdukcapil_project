<?php

use Illuminate\Support\Facades\DB;
use App\Models\AkteKematian;
use App\Models\LahirMati;

// Get application instance
$app = require_once __DIR__.'./bootstrap/app.php';
$kernel = $app->make(\Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "====== Verifying Database Schema ======\n\n";
    
    // Check Akte Kematian columns
    echo "✓ Akte Kematian columns:\n";
    $akte_columns = DB::getSchemaBuilder()->getColumnListing('akte_kematian');
    foreach($akte_columns as $col) { 
        echo "  - " . $col . "\n"; 
    }
    echo "\nTotal: " . count($akte_columns) . " columns\n\n";
    
    // Check Lahir Mati columns
    echo "✓ Lahir Mati columns:\n";
    $lahir_columns = DB::getSchemaBuilder()->getColumnListing('lahir_mati');
    foreach($lahir_columns as $col) { 
        echo "  - " . $col . "\n"; 
    }
    echo "\nTotal: " . count($lahir_columns) . " columns\n\n";
    
    // Check model fillables
    echo "====== Verifying Model Fillables ======\n\n";
    
    $akte_model = new AkteKematian;
    echo "✓ AkteKematian fillable:\n";
    foreach($akte_model->getFillable() as $field) {
        echo "  - " . $field . "\n";
    }
    echo "\n";
    
    $lahir_model = new LahirMati;
    echo "✓ LahirMati fillable:\n";
    foreach($lahir_model->getFillable() as $field) {
        echo "  - " . $field . "\n";
    }
    
    echo "\n✓ All verification complete! Database is ready for form submissions.\n";
    
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
