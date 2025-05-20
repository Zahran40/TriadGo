<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('homepage');
});

// Route::get('/', [PageController::class, 'home']);
Route::get('/importir', [PageController::class, 'home'])->name('home');
Route::get('/sign-up', [PageController::class, 'signup'])->name('signup');
Route::get('/login', [PageController::class, 'login'])->name('login');
Route::post('/sign-up/data', [PageController::class, 'store'])->name('signup.store');
Route::post('/login', [PageController::class, 'authenticate'])->name('login.authenticate');
