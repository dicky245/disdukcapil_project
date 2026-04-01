<?php

use App\Http\Controllers\Api\Ocr_Preprocessing_Controller;
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

// OCR Preprocessing Routes
Route::prefix('ocr-preprocessing')->group(function () {
    Route::post('/upload', [Ocr_Preprocessing_Controller::class, 'Handle_Document_Upload'])
        ->name('api.ocr-preprocessing.upload');

    Route::post('/process-from-storage', [Ocr_Preprocessing_Controller::class, 'Process_From_Storage'])
        ->name('api.ocr-preprocessing.process-storage');

    Route::get('/get-image', [Ocr_Preprocessing_Controller::class, 'Get_Preprocessed_Image'])
        ->name('api.ocr-preprocessing.get-image');

    Route::post('/cleanup', [Ocr_Preprocessing_Controller::class, 'Cleanup_Old_Files'])
        ->name('api.ocr-preprocessing.cleanup');
});
