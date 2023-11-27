<?php

use Illuminate\Support\Facades\Route;
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


// Home
Route::get('/', function () {
    return view('home');
})->name('home')->middleware('auth');
Route::get('/profile', [UserController::class, 'profile'])->name('profile')->middleware('auth');


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
