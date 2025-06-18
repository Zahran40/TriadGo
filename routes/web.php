<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EksportirController;
use App\Http\Controllers\ImportirController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OtherProfileController;
use App\Http\Controllers\CommentController;



// Register 
Route::get('/sign-up', [RegisterController::class, 'signup'])->name('signup');
Route::post('/sign-up/data', [RegisterController::class, 'store'])->name('signup.store');

// Login 
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// Homepage - semua bisa akses
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

// Halaman Importir - hanya role impor
Route::get('/importir', [ImportirController::class, 'homeimportir'])->name('importir')->middleware('role.protect:impor');
Route::get('/catalog', [ImportirController::class, 'catalog'])->name('catalog')->middleware('role.protect:impor');
Route::get('/formimportir', [ImportirController::class, 'formimportir'])->name('formimportir')->middleware('role.protect:impor');
// Route::get('/detail', [ImportirController::class, 'detail'])->name('detail')->middleware('role.protect:impor');
  Route::get('/product-detail-importir/{id}', [ImportirController::class, 'detail'])
        ->name('product.detail.importir')->middleware('role.protect:impor');

// // User Profile - hanya user yang login (bukan guest)
// Route::get('/user-profile', [PageController::class, 'userprofile'])->name('userprofile')->middleware('role.protect:impor,ekspor');
// Route::get('/profile/edit', [PageController::class, 'edit'])->name('profile.edit')->middleware('role.protect:impor,ekspor');

Route::get('/profile', [UserProfileController::class, 'index'])->name('user.profile')->middleware('role.protect:impor,ekspor');
Route::put('/profile/update', [UserProfileController::class, 'update'])->name('user.profile.update')->middleware('role.protect:impor,ekspor');
Route::post('/profile/upload-picture', [UserProfileController::class, 'uploadProfilePicture'])->name('user.profile.upload')->middleware('role.protect:impor,ekspor');
Route::delete('/profile/delete', [UserProfileController::class, 'destroy'])->name('user.profile.delete')->middleware('role.protect:impor,ekspor');
 Route::get('/other-profile/{userId}', [OtherProfileController::class, 'show'])
        ->name('other.profile')->middleware('role.protect:impor,ekspor');

// Invoice - hanya user yang login
Route::get('/invoice', [PageController::class, 'invoice'])->name('invoice')->middleware('role.protect:admin,impor,ekspor');
Route::post('/logout', [PageController::class, 'logout'])->name('logout')->middleware('role.protect:admin,impor,ekspor');

// Contact us - semua bisa akses
Route::post('/contactus', [ContactusController::class, 'store'])->name('contactus.store');

// Halaman Ekspor - hanya role ekspor
Route::get('/ekspor', [EksportirController::class, 'homeeksportir'])->name('ekspor')->middleware('role.protect:ekspor');
Route::get('formeksportir', [EksportirController::class, 'formeksportir'])->name('formeksportir')->middleware('role.protect:ekspor');

// ✅ RESPONSE ROUTE - MUST BE DEFINED BEFORE COMMENT ROUTES
Route::get('/response', [CommentController::class, 'response'])
    ->name('response')
    ->middleware('role.protect:ekspor');

//Comment Routes - URUTKAN YANG SPESIFIK DAHULU
Route::middleware('role.protect:impor')->group(function () {
    // Routes yang spesifik harus di atas
     Route::post('/product/{productId}/comment', [CommentController::class, 'store'])
        ->name('comment.store');
    Route::get('/product/{productId}/comments', [CommentController::class, 'getComments'])
        ->name('comment.get');
});



// Product Routes - URUTKAN YANG SPESIFIK DAHULU
Route::middleware('role.protect:ekspor')->group(function () {
    // Routes yang spesifik harus di atas
    Route::get('/myproduct', [ProductController::class, 'myProducts'])->name('myproduct');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    // Route dengan parameter harus di bawah
    Route::get('/product-detail/{id}', [ProductController::class, 'show'])->name('product.detail');
});

//Response comment
Route::get('/requestimportir', [ImportirController::class, 'requestimportir'])->name('requestimportir')->middleware('role.protect:impor');
// Route::get('/response', [EksportirController::class, 'response'])->name('response')->middleware('role.protect:ekspor');


// Route fallback - letakkan di paling bawah
Route::fallback(function () {
    $userRole = Auth::check() ? Auth::user()->role : 'guest';
    return response()->view('404', ['userRole' => $userRole], 404);
});

