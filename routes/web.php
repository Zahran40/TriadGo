<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EksportirController;
use App\Http\Controllers\ImportirController;

// HAPUS route proteksi admin1 manual - ini yang menyebabkan loop

// Register
Route::get('/sign-up', [RegisterController::class, 'signup'])->name('signup');
Route::post('/sign-up/data', [RegisterController::class, 'store'])->name('signup.store');

// Login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/importir', [PageController::class, 'home'])->name('home');

Route::get('/user-profile', [PageController::class, 'userprofile'])->name('userprofile');
Route::get('/profile/edit', [PageController::class, 'edit'])->name('profile.edit');

Route::get('/invoice', [PageController::class, 'invoice'])->name('invoice');
Route::post('/logout', [PageController::class, 'logout'])->name('logout');

//Route Contact us di homepage
Route::post('/contactus', [ContactusController::class, 'store'])->name('contactus.store');

//Route Halaman Importir
Route::get('Importir', [ImportirController::class, 'homeimportir'])->name('importir');
Route::get('formImportir', [ImportirController::class, 'formImportir'])->name('formImportir');

//Route Halaman Ekspor
Route::get('/ekspor', [EksportirController::class, 'homeeksportir'])->name('ekspor');
Route::get('formeksportir', [EksportirController::class, 'formeksportir'])->name('formeksportir');

// Route fallback - letakkan di paling bawah
Route::fallback(function () {
    return view('404');
});