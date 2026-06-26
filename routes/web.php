<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| YOUR TASK — register the routes
|--------------------------------------------------------------------------
| The five controllers imported above are already written for you. Your job
| is to wire each one up with a full set of CRUD routes.
|
| Every controller has these methods: index, create, store, edit, update,
| destroy  (there is NO `show` method). The quickest way to register all of
| them at once is Route::resource().
|
| IMPORTANT: the controllers redirect to route names such as
| 'students.index', so the resource name MUST match this list exactly:
|
|     departments  ->  DepartmentController
|     students     ->  StudentController
|     courses      ->  CourseController
|     professors   ->  ProfessorController
|     enrollments  ->  EnrollmentController
|
| TODO:
|   1. Add a route for '/' (e.g. redirect to one of the modules).
|   2. Register a resource route for each of the five controllers.
|      Remember to exclude 'show'.
|
| One worked example — write the other four yourself:
|
|     // Route::resource('departments', DepartmentController::class)->except('show');
*/

// TODO: write your routes below this line.


Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::view('/dashboard', 'dashboard')->middleware('auth')->name('dashboard');
Route::get('css/layout.css', function () {
    $path = resource_path('css/layout.css');
    return response(file_get_contents($path), 200)
        ->header('Content-Type', 'text/css');
});

Route::get('js/layout.js', function () {
    $path = resource_path('js/layout.js');
    return response(file_get_contents($path), 200)
        ->header('Content-Type', 'application/javascript');
});

Route::resource('departments', DepartmentController::class)->except('show');
Route::resource('students', StudentController::class)->except('show');
Route::resource('courses', CourseController::class)->except('show');
Route::resource('professors', ProfessorController::class)->except('show');
Route::resource('enrollments', EnrollmentController::class)->except('show');

