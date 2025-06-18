<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ContactusController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\EksportirController;
use App\Http\Controllers\ImportirController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OtherProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CheckoutController;

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
Route::get('/detail', [ImportirController::class, 'detail'])->name('detail')->middleware('role.protect:impor');
Route::get('/requestimportir', [ImportirController::class, 'request'])->name('requestimportir')->middleware('role.protect:impor');
Route::get('/product-detail-importir/{id}', [ImportirController::class, 'showProductDetail'])->name('product.detail.importir')->middleware('role.protect:impor');

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
Route::get('/invoice/{order_id}', [InvoiceController::class, 'show'])->name('invoice.show')->middleware('role.protect:admin,impor,ekspor');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('role.protect:admin,impor,ekspor');

// Contact us - semua bisa akses
Route::post('/contactus', [ContactusController::class, 'store'])->name('contactus.store');

// Halaman Ekspor - hanya role ekspor
Route::get('/ekspor', [EksportirController::class, 'homeeksportir'])->name('ekspor')->middleware('role.protect:ekspor');
Route::get('formeksportir', [EksportirController::class, 'formeksportir'])->name('formeksportir')->middleware('role.protect:ekspor');

// Product Routes - URUTKAN YANG SPESIFIK DAHULU
Route::middleware('role.protect:ekspor')->group(function () {
    // Routes yang spesifik harus di atas
    Route::get('/myproduct', [ProductController::class, 'myProducts'])->name('myproduct');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::delete('/product/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    
    // Route dengan parameter harus di bawah
    Route::get('/product-detail/{id}', [ProductController::class, 'show'])->name('product.detail');
});

// Checkout Routes
Route::middleware('role.protect:impor')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken'])->name('checkout.create-token');
    Route::get('/checkout/success/{orderId?}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pending/{orderId?}', [CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/checkout/error/{orderId?}', [CheckoutController::class, 'error'])->name('checkout.error');
    Route::get('/checkout/status/{orderId}', [CheckoutController::class, 'getOrderStatus'])->name('checkout.status');
});

// Midtrans Payment API Routes
Route::prefix('api')->group(function () {
    Route::post('/midtrans/token', [MidtransController::class, 'getSnapToken'])->name('midtrans.token');
});

// Midtrans Webhook (tidak perlu middleware karena dipanggil dari luar)
Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.webhook');

// Test routes untuk simulasi payment (tanpa CSRF untuk testing)
Route::prefix('test')->group(function () {
    Route::get('/payment/{orderId}', [CheckoutController::class, 'testPaymentPage'])->name('test.payment');
    Route::get('/order-status/{orderId}', [CheckoutController::class, 'getOrderStatus'])->name('test.order.status');
});

// Force simulate payment route (tanpa CSRF untuk testing)
Route::post('/force-simulate-payment/{orderId}', [CheckoutController::class, 'forceSimulatePayment'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Route fallback - letakkan di paling bawah
Route::fallback(function () {
    $userRole = Auth::check() ? Auth::user()->role : 'guest';
    return response()->view('404', ['userRole' => $userRole], 404);
});

