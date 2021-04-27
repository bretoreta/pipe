<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Projects CRUD operations
    Route::resource('projects', ProjectController::class);

    // Tasks management
    Route::get('/project/{project}/tasks', [ProjectController::class, 'tasks'])->name('projects.tasks');
    Route::post('/project/task', [TaskController::class, 'create'])->name('task.create');
    Route::delete('/project/tasks/{task}', [TaskController::class, 'destroy'])->name('task.destroy');
    Route::post('/project/task/{task}/done', [TaskController::class, 'done'])->name('task.done');
    Route::post('/project/task/{task}/start', [TaskController::class, 'start'])->name('task.start');
});
