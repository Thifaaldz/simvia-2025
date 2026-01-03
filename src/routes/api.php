<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OCR\CallbackController;
use App\Http\Controllers\Api\DocumentApiController;


Route::get('/documents/{id}', [DocumentApiController::class, 'show']);
Route::post('/ocr/callback', [CallbackController::class, 'handle']);