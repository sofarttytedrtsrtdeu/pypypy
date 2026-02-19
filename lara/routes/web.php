<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContestController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AttachmentController;

// Публичные маршруты
Route::get('/', function () {
    return redirect()->route('login');
})->name('home');

Route::get('/test', function () {
    return 'Laravel работает!';
});

// Тестовый маршрут для проверки роли
Route::get('/test-role', function() {
    return [
        'auth_check' => Auth::check(),
        'user' => Auth::user() ? Auth::user()->email : null,
        'role' => Auth::user() ? Auth::user()->role : null,
    ];
})->middleware('auth');

// Гостевые маршруты (без авторизации)
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::middleware(['auth', 'role:participant'])->group(function () {
    Route::get('/submissions/create', [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::put('/submissions/{submission}', [SubmissionController::class, 'update'])->name('submissions.update');
    Route::post('/submissions/{submission}/submit', [SubmissionController::class, 'submit'])->name('submissions.submit');
    Route::post('/submissions/{submission}/attachments', [AttachmentController::class, 'upload'])->name('attachments.upload');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
});
// Маршруты ТОЛЬКО для авторизованных (базовые)
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Общие маршруты для всех авторизованных
    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
    Route::post('/submissions/{submission}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/attachments/{attachment}/download', [AttachmentController::class, 'download'])->name('attachments.download');
    Route::get('/attachments/{attachment}/status', [AttachmentController::class, 'checkStatus'])->name('attachments.status');
});

// Маршруты для participant (должны быть ПОСЛЕ общих маршрутов)


// Маршруты для жюри и админа
Route::middleware(['auth', 'role:jury,admin'])->group(function () {
    Route::patch('/submissions/{submission}/status', [SubmissionController::class, 'changeStatus'])->name('submissions.change-status');
});

// Маршруты для админа
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('contests', ContestController::class)->except(['show']);
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update', 'destroy']);
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->only(['index', 'edit', 'update']);
});