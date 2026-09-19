<?php

use App\Http\Controllers\VivaController;
use App\Http\Controllers\PracticalController;
use App\Http\Controllers\TeacherController;
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

Route::middleware('auth:sanctum')->prefix('practicals')->group(function () {
    Route::get('/', [PracticalController::class, 'index'])->name('practicals.index');
    Route::get('/history', [PracticalController::class, 'history'])->name('practicals.history');
    Route::get('/{practical}', [PracticalController::class, 'show'])->name('practicals.show');
    Route::post('/{practical}/start', [PracticalController::class, 'start'])->name('practicals.start');
    Route::post('/submissions/{submission}/acknowledge-safety', [PracticalController::class, 'acknowledgeSafety'])->name('practicals.acknowledge');
    Route::post('/submissions/{submission}/submit', [PracticalController::class, 'submit'])->name('practicals.submit');
    Route::get('/submissions/{submission}', [PracticalController::class, 'showSubmission'])->name('practicals.submission.show');
});

Route::middleware('auth:sanctum')->prefix('teacher')->group(function () {
    Route::get('/profile', [TeacherController::class, 'profile'])->name('teacher.profile');
    Route::get('/students', [TeacherController::class, 'students'])->name('teacher.students');
    Route::get('/questions', [TeacherController::class, 'questions'])->name('teacher.questions');
    Route::get('/tests', [TeacherController::class, 'tests'])->name('teacher.tests');
    Route::get('/results', [TeacherController::class, 'results'])->name('teacher.results');
    Route::get('/reports', [TeacherController::class, 'reports'])->name('teacher.reports');
    Route::post('/questions', [TeacherController::class, 'storeQuestion'])->name('teacher.questions.store');
    Route::put('/questions/{question}', [TeacherController::class, 'updateQuestion'])->name('teacher.questions.update');
    Route::post('/questions/{question}/publish', [TeacherController::class, 'publishQuestion'])->name('teacher.questions.publish');
    Route::delete('/questions/{question}', [TeacherController::class, 'deleteQuestion'])->name('teacher.questions.delete');
    Route::post('/tests', [TeacherController::class, 'storeTest'])->name('teacher.tests.store');
    Route::post('/tests/{test}/publish', [TeacherController::class, 'publishTest'])->name('teacher.tests.publish');
    Route::post('/tests/{test}/assign', [TeacherController::class, 'assignTest'])->name('teacher.tests.assign');
    Route::get('/tests/{test}/attempts', [TeacherController::class, 'testAttempts'])->name('teacher.tests.attempts');
    Route::get('/tests/{test}/results', [TeacherController::class, 'testResults'])->name('teacher.tests.results');
});