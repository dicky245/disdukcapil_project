<?php

use App\Http\Controllers\Api\EasyOcrController;
use App\Http\Controllers\Antrian_Online_Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// EasyOCR KTP API Routes
Route::prefix('ocr')->group(function () {
    // Upload dan proses gambar KTP (EasyOcrController)
    Route::post('/upload', [EasyOcrController::class, 'upload']);
    
    // Proses multiple images
    Route::post('/batch', [EasyOcrController::class, 'batchUpload']);
    
    // Cek status hasil OCR
    Route::get('/status/{antrianId}', [EasyOcrController::class, 'status']);
    
    // Ambil hasil OCR
    Route::get('/result/{antrianId}', [EasyOcrController::class, 'result']);
    
    // Proses OCR (integrated dengan Antrian_Online)
    Route::post('/process', [Antrian_Online_Controller::class, 'Proses_Ocr_Easy']);
    
    // Proses OCR dengan Google Vision (fallback)
    Route::post('/process-vision', [Antrian_Online_Controller::class, 'Proses_Ocr_Vision']);
    
    // Diagnostic endpoint
    Route::get('/diagnose', [Antrian_Online_Controller::class, 'Diagnose_Ocr']);
});
