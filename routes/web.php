<?php

use App\Http\Controllers\ListsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TasksController;
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

/** Index **/
Route::get('/', function () {
    return Inertia::render('Index', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth', 'verified')->group(function () {
    /** Dashboard **/
    Route::get('/dashboard', [ListsController::class, 'all'])->name('dashboard');

    /** Lists Routes **/
    Route::post('/lists', [ListsController::class, 'create'])->name('lists.create');
    Route::get('/lists/{id}', [ListsController::class, 'view'])->name('lists.view');
    Route::patch('/lists/{id}', [ListsController::class, 'update'])->name('lists.update');
    Route::delete('/lists/{id}', [ListsController::class, 'delete'])->name('lists.delete');


    /** Tasks Routes **/
    Route::post('/lists/{list_id}/tasks', [TasksController::class, 'create'])->name('tasks.create');
    Route::patch('/lists/{list_id}/tasks/{task_id}', [TasksController::class, 'update'])->name('tasks.update');
    Route::delete('/lists/{list_id}/tasks/{task_id}', [TasksController::class, 'delete'])->name('tasks.delete');

    /** User Routes **/
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
