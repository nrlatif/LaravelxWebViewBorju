<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');

// Dashboard Features Routes
Route::get('/kasir', function () {
    return view('kasir');
})->name('kasir');

Route::get('/riwayat', function () {
    return view('riwayat');
})->name('riwayat');

Route::get('/pencatatan', function () {
    return view('pencatatan');
})->name('pencatatan');

Route::get('/menu-crud', function () {
    return view('menu-crud');
})->name('menu-crud');

Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::get('/settings', function () {
    return view('settings');
})->name('settings');
