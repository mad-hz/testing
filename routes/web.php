<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseStepController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Auth\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\LearnpathController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DepartmentDocumentController;
use App\Http\Controllers\ValidationRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\RolePermissionController;
use App\Http\Controllers\QuestionController;

Route::middleware('auth')->group(function () {
    Route::get('/', DashboardController::class)->name('dashboard');

    Route::get('/courses/dashboard', CourseController::class)->name('courses.dashboard');
    Route::resource('courses', CourseController::class);
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/steps/{step}/complete', [CourseStepController::class, 'complete'])->name('courses.course-steps.complete');
    Route::get('/courses/{course}/steps', [CourseStepController::class, 'index'])->name('courses.course-steps.index');
    Route::get('/courses/{course}/steps/{step}', [CourseStepController::class, 'show'])->name('courses.course-steps.show');
    Route::get('/courses/{course}/progress', [CourseController::class, 'progress'])->name('courses.progress');
    Route::post('/courses/{course}/resources', [CourseController::class, 'storeResource'])->name('courses.resources.store');

    Route::resources([
        'users' => UserController::class,
        'learnpath' => LearnpathController::class,
        'articles' => ArticleController::class,
        'departments' => DepartmentController::class,
        'roles' => RoleController::class,
    ]);

    Route::get('/profile/information', [ProfileController::class, 'profile'])->name('profile.information');
    Route::get('/profile/security', [ProfileController::class, 'security'])->name('profile.security');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('quizzes/{quiz}/questions', [QuizController::class, 'questions'])->name('quizzes.questions');
    Route::post('/quizzes/{quiz}/result', [QuizController::class, 'result'])->name('quizzes.result');

    Route::get('/quizzes/{quiz}/questions/create', [QuestionController::class, 'create'])->name('questions.create');
    Route::post('/quizzes/{quiz}/questions', [QuestionController::class, 'store'])->name('questions.store');
    Route::get('/quizzes/{quiz}/questions/edit', [QuestionController::class, 'edit'])->name('questions.edit');
    Route::patch('/quizzes/{quiz}/questions', [QuestionController::class, 'update'])->name('questions.update');

    Route::resource('quizzes', QuizController::class);

    Route::post('/content/{type}/{content_id}/validate', [ValidationRequestController::class, 'store'])->name('validation.request');
});

require __DIR__ . '/auth.php';
