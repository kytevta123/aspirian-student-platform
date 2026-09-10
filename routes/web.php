<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\RevisionQueueController;
use App\Http\Controllers\TestAttemptAnswerController;
use App\Http\Controllers\TestAttemptController;
use App\Http\Controllers\TestQuestionController;
use App\Http\Controllers\TestResultController;
use App\Http\Controllers\TestSubmissionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register.form');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::view('/login', 'auth.login')
    ->middleware('guest')
    ->name('login.form');

Route::post('/login', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.store');

/*
|--------------------------------------------------------------------------
| Email Verification Routes
|--------------------------------------------------------------------------
*/

Route::get('/verify-email', [EmailVerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [EmailVerificationController::class, 'verify'])
    ->middleware([
        'auth',
        'signed',
        'throttle:6,1',
    ])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationController::class, 'resend'])
    ->middleware([
        'auth',
        'throttle:6,1',
    ])
    ->name('verification.send');

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware([
        'auth',
        'verified',
        'permission:view_dashboard',
    ])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::get('/profile', [ProfileController::class, 'edit'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('profile.edit');

Route::put('/profile', [ProfileController::class, 'update'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('profile.update');

Route::get('/profile/password', [PasswordController::class, 'edit'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('password.edit');

Route::put('/profile/password', [PasswordController::class, 'update'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('password.update');

/*
|--------------------------------------------------------------------------
| Logout
|--------------------------------------------------------------------------
*/

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Question Bank Routes
|--------------------------------------------------------------------------
*/

Route::get('/questions/create', [QuestionController::class, 'create'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('questions.create');

Route::get('/questions', [QuestionController::class, 'index'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('questions.index');

Route::post('/questions', [QuestionController::class, 'store'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('questions.store');

Route::put('/questions/{question}', [QuestionController::class, 'update'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('questions.update');

Route::delete('/questions/{question}', [QuestionController::class, 'destroy'])
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('questions.destroy');

/*
|--------------------------------------------------------------------------
| Revision Queue
|--------------------------------------------------------------------------
|
| Shows the authenticated student's weak topics in revision priority order.
|
*/

Route::get(
    '/revision-queue',
    [RevisionQueueController::class, 'index']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('revision.index');

/*
|--------------------------------------------------------------------------
| Test Attempt Routes
|--------------------------------------------------------------------------
|
| Start a new attempt for a published test.
|
*/

Route::get(
    '/tests/{test}/start',
    [TestAttemptController::class, 'start']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.start');

/*
|--------------------------------------------------------------------------
| Existing Test Attempt View
|--------------------------------------------------------------------------
*/

Route::get(
    '/test-attempts/{attempt}',
    [TestAttemptController::class, 'show']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.attempts.show');

/*
|--------------------------------------------------------------------------
| Test Timer / Auto Expiration
|--------------------------------------------------------------------------
*/

Route::post(
    '/test-attempts/{attempt}/expire',
    [TestAttemptController::class, 'expire']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.attempts.expire');

/*
|--------------------------------------------------------------------------
| Test Answer Submission
|--------------------------------------------------------------------------
*/

Route::post(
    '/test-attempts/{attempt}/questions/{question}/answer',
    [TestAttemptAnswerController::class, 'store']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.attempts.answers.store');

/*
|--------------------------------------------------------------------------
| Test Submission
|--------------------------------------------------------------------------
*/

Route::post(
    '/test-attempts/{attempt}/submit',
    [TestSubmissionController::class, 'submit']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.attempts.submit');

/*
|--------------------------------------------------------------------------
| Test Auto Submission
|--------------------------------------------------------------------------
|
| Automatically submits an attempt when the server confirms that
| the test time has expired.
|
*/

Route::post(
    '/test-attempts/{attempt}/auto-submit',
    [TestSubmissionController::class, 'autoSubmit']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.attempts.auto-submit');

/*
|--------------------------------------------------------------------------
| Test Result History
|--------------------------------------------------------------------------
|
| Shows the authenticated student's previous test results.
|
*/

Route::get(
    '/test-results',
    [TestResultController::class, 'index']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.results.index');

/*
|--------------------------------------------------------------------------
| Test Result
|--------------------------------------------------------------------------
*/

Route::get(
    '/test-results/{result}',
    [TestResultController::class, 'show']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.results.show');

/*
|--------------------------------------------------------------------------
| Test Question Selection Routes
|--------------------------------------------------------------------------
*/

Route::get(
    '/tests/{test}/questions',
    [TestQuestionController::class, 'index']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.index');

Route::post(
    '/tests/{test}/questions',
    [TestQuestionController::class, 'store']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.store');

Route::patch(
    '/tests/{test}/questions/order',
    [TestQuestionController::class, 'updateOrder']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.order');

Route::post(
    '/tests/{test}/questions/topic',
    [TestQuestionController::class, 'storeTopic']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.topic');

Route::post(
    '/tests/{test}/questions/difficulty',
    [TestQuestionController::class, 'storeDifficulty']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.difficulty');

Route::delete(
    '/tests/{test}/questions/{question}',
    [TestQuestionController::class, 'destroy']
)
    ->middleware([
        'auth',
        'verified',
    ])
    ->name('tests.questions.destroy');