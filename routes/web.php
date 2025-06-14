<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactusController;

Route::get('/', function () {
    return view('homepage');
});

// Route::get('/', [PageController::class, 'home']);
Route::get('/importir', [PageController::class, 'home'])->name('home');
Route::get('/sign-up', [PageController::class, 'signup'])->name('signup');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::get('/user-profile', [PageController::class, 'userprofile'])->name('userprofile');
Route::get('/profile/edit', [PageController::class, 'edit'])->name('profile.edit');
Route::post('/sign-up/data', [PageController::class, 'store'])->name('signup.store');
Route::post('/login', [PageController::class, 'authenticate'])->name('login.authenticate');

Route::get('/invoice', [PageController::class, 'invoice'])->name('invoice');
Route::post('/logout', [PageController::class, 'logout'])->name('logout');

//Route Contact us di homepage

Route::post('/contactus', [ContactusController::class, 'store'])->name('contactus.store');


//Route Halaman Importir
Route::get('Importir', [PageController::class, 'homeimportir'])->name('importir');


//Route Halaman Ekspor
Route::get('Ekspor', [PageController::class, 'homeeksportir'])->name('ekspor');
Route::get('formeksportir', [PageController::class, 'formeksportir'])->name('formeksportir');
