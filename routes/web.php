<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TranslationController;

Route::get('/', function () {
    return view('welcome');
});

// Public routes
Route::get('translations', [TranslationController::class, 'index']);
Route::get('translations-export', [TranslationController::class, 'export']);

// Secure routes with middleware
Route::middleware('auth:sanctum')->group(function () {
    Route::post('translations', [TranslationController::class, 'store']);
    Route::put('translations/{id}', [TranslationController::class, 'update']); // Update route
    // Other secure routes...
});
