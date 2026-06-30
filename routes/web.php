<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('login'));

// ── Public auth routes ────────────────────────────────────────
Route::get('/login',     [AuthController::class, 'showLogin'])->name('login');
Route::post('/login',    [AuthController::class, 'login']);
Route::get('/register',  [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout',   [AuthController::class, 'logout'])->name('logout');

// ── CSS / JS served from resources/ ──────────────────────────
Route::get('css/layout.css', fn() =>
    response(file_get_contents(resource_path('css/layout.css')), 200)
        ->header('Content-Type', 'text/css')
);
Route::get('js/layout.js', fn() =>
    response(file_get_contents(resource_path('js/layout.js')), 200)
        ->header('Content-Type', 'application/javascript')
);

// ── Protected routes (require login) ─────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::resource('departments', DepartmentController::class)->except('show');
    Route::resource('students',    StudentController::class)->except('show');
    Route::resource('courses',     CourseController::class)->except('show');
    Route::resource('professors',  ProfessorController::class)->except('show');
    Route::resource('enrollments', EnrollmentController::class)->except('show');
});
