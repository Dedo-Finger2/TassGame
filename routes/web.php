<?php

use App\Http\Controllers\ItemController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SubTaskController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UrgenceController;
use App\Http\Controllers\DifficultyController;
use App\Http\Controllers\ImportanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Auth
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'auth'])->name('auth');
Route::get('/register', [LoginController::class, 'create'])->name('register');
Route::post('/register', [LoginController::class, 'store'])->name('register.store');
Route::post('/register', [LoginController::class, 'store'])->name('register.store');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');


// User
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');
Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/my-dashboard', [UserController::class, 'dashboard'])->name('dashboard')->middleware('auth');


// Urgences
Route::get('/urgences', [UrgenceController::class, 'index'])->name('urgences.index')->middleware('auth');
Route::get('/urgences-creation', [UrgenceController::class, 'create'])->name('urgences.create')->middleware('auth');
Route::post('/urgences-creation', [UrgenceController::class, 'store'])->name('urgences.store')->middleware('auth');
Route::get('/urgences/{urgence}', [UrgenceController::class, 'edit'])->name('urgences.edit')->middleware('auth');
Route::put('/urgences/{urgence}', [UrgenceController::class, 'update'])->name('urgences.update')->middleware('auth');
Route::get('/urgences/{urgence}/view', [UrgenceController::class, 'show'])->name('urgences.show')->middleware('auth');
Route::delete('/urgences/{urgence}', [UrgenceController::class, 'destroy'])->name('urgences.destroy')->middleware('auth');


// Importances
Route::get('/importances', [ImportanceController::class, 'index'])->name('importances.index')->middleware('auth');
Route::get('/importances-creation', [ImportanceController::class, 'create'])->name('importances.create')->middleware('auth');
Route::post('/importances-creation', [ImportanceController::class, 'store'])->name('importances.store')->middleware('auth');
Route::get('/importances/{importance}', [ImportanceController::class, 'edit'])->name('importances.edit')->middleware('auth');
Route::put('/importances/{importance}', [ImportanceController::class, 'update'])->name('importances.update')->middleware('auth');
Route::get('/importances/{importance}/view', [ImportanceController::class, 'show'])->name('importances.show')->middleware('auth');
Route::delete('/importances/{importance}', [ImportanceController::class, 'destroy'])->name('importances.destroy')->middleware('auth');


// Difficulties
Route::get('/difficulties', [DifficultyController::class, 'index'])->name('difficulties.index')->middleware('auth');
Route::get('/difficulties-creation', [DifficultyController::class, 'create'])->name('difficulties.create')->middleware('auth');
Route::post('/difficulties-creation', [DifficultyController::class, 'store'])->name('difficulties.store')->middleware('auth');
Route::get('/difficulties/{difficulty}', [DifficultyController::class, 'edit'])->name('difficulties.edit')->middleware('auth');
Route::put('/difficulties/{difficulty}', [DifficultyController::class, 'update'])->name('difficulties.update')->middleware('auth');
Route::get('/difficulties/{difficulty}/view', [DifficultyController::class, 'show'])->name('difficulties.show')->middleware('auth');
Route::delete('/difficulties/{difficulty}', [DifficultyController::class, 'destroy'])->name('difficulties.destroy')->middleware('auth');


// Tasks
Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');
Route::get('/tasks-creation', [TaskController::class, 'create'])->name('tasks.create')->middleware('auth');
Route::post('/tasks-creation', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
Route::get('/tasks/{task}', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('auth');
Route::put('/tasks/{task}', [TaskController::class, 'update'])->name('tasks.update')->middleware('auth');
Route::get('/tasks/{task}/view', [TaskController::class, 'show'])->name('tasks.show')->middleware('auth');
Route::delete('/tasks/{task}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('auth');
// Tasks User
Route::get('/my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my-tasks')->middleware('auth');
Route::get('/my-completed-tasks', [TaskController::class, 'myCompletedTasks'])->name('tasks.my-completed-tasks')->middleware('auth');
Route::post('/complete-my-tasks', [TaskController::class, 'completeTasks'])->name('tasks.complete-tasks')->middleware('auth');
Route::post('/uncomplete-my-tasks', [TaskController::class, 'uncompleteTasks'])->name('tasks.uncomplete-tasks')->middleware('auth');
Route::post('/refresh-recurrings', [TaskController::class, 'refreshRecurringTasks'])->name('tasks.refresh-recurring-tasks')->middleware('auth');

// SubTasks
Route::get('/sub-tasks', [SubTaskController::class, 'index'])->name('sub-tasks.index')->middleware('auth');
Route::get('/sub-tasks-creation/{selectedTask}', [SubTaskController::class, 'create'])->name('sub-tasks.create')->middleware('auth');
Route::post('/sub-tasks-creation', [SubTaskController::class, 'store'])->name('sub-tasks.store')->middleware('auth');
Route::get('/sub-tasks/{sub_task}', [SubTaskController::class, 'edit'])->name('sub-tasks.edit')->middleware('auth');
Route::put('/sub-tasks/{sub_task}', [SubTaskController::class, 'update'])->name('sub-tasks.update')->middleware('auth');
Route::get('/sub-tasks/{sub_task}/view', [SubTaskController::class, 'show'])->name('sub-tasks.show')->middleware('auth');
Route::delete('/sub-tasks/{sub_task}', [SubTaskController::class, 'destroy'])->name('sub-tasks.destroy')->middleware('auth');

Route::post('/uncomplete-sub-tasks', [SubTaskController::class, 'uncompleteSubTasks'])->name('sub-tasks.uncomplete')->middleware('auth');
Route::post('/complete-sub-tasks', [SubTaskController::class, 'completeSubTasks'])->name('sub-tasks.complete')->middleware('auth');

// Items
Route::get('/items', [ItemController::class, 'index'])->name('items.index')->middleware('auth');
Route::get('/items-creation', [ItemController::class, 'create'])->name('items.create')->middleware('auth');
Route::post('/items-creation', [ItemController::class, 'store'])->name('items.store')->middleware('auth');
Route::get('/items/{item}', [ItemController::class, 'edit'])->name('items.edit')->middleware('auth');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update')->middleware('auth');
Route::get('/items/{item}/view', [ItemController::class, 'show'])->name('items.show')->middleware('auth');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy')->middleware('auth');
// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop.index')->middleware('auth');
Route::get('/buy/{item}', [ShopController::class, 'buy'])->name('shop.buy')->middleware('auth');
