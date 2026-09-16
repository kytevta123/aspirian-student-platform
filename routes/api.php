<?php

use App\Http\Controllers\VivaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->prefix('viva')->group(function () {
    Route::get('/', [VivaController::class, 'index'])->name('viva.index');
    Route::post('/start', [VivaController::class, 'start'])->name('viva.start');
    Route::get('/{vivaSession}', [VivaController::class, 'show'])->name('viva.show');
    Route::post('/{vivaSession}/answer', [VivaController::class, 'submitAnswer'])->name('viva.answer');
    Route::post('/{vivaSession}/complete', [VivaController::class, 'complete'])->name('viva.complete');
    Route::get('/{vivaSession}/result', [VivaController::class, 'result'])->name('viva.result');
    Route::get('/history', [VivaController::class, 'history'])->name('viva.history');
});