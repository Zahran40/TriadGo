<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;

Route::get('/', function () {
    return view('homepage');
});


Route::get('/sign-up', [PageController::class, 'signup'])->name('signup');