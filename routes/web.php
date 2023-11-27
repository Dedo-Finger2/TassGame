<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\UrgenceController;
use Illuminate\Support\Facades\Route;

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
    return view('welcome');
})->name('home')->middleware('auth');

// Urgences
Route::get('/urgences', [UrgenceController::class, 'index'])->name('urgences.index')->middleware('auth');
Route::get('/urgences-creation', [UrgenceController::class, 'create'])->name('urgences.create')->middleware('auth');
Route::post('/urgences-creation', [UrgenceController::class, 'store'])->name('urgences.store')->middleware('auth');
Route::get('/urgences/{urgence}', [UrgenceController::class, 'edit'])->name('urgences.edit')->middleware('auth');
Route::put('/urgences/{urgence}', [UrgenceController::class, 'update'])->name('urgences.update')->middleware('auth');
Route::get('/urgences/{urgence}/view', [UrgenceController::class, 'show'])->name('urgences.show')->middleware('auth');
Route::post('/urgences/{urgence}', [UrgenceController::class, 'destroy'])->name('urgences.destroy')->middleware('auth');
