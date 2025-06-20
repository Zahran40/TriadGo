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
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;

// Register 
Route::get('/sign-up', [RegisterController::class, 'signup'])->name('signup');
Route::post('/sign-up/data', [RegisterController::class, 'store'])->name('signup.store');

// Login 
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');

// Homepage - semua bisa akses
Route::get('/', [PageController::class, 'home'])->name('homepage');

// Halaman Importir - hanya role impor
Route::get('/importir', [ImportirController::class, 'homeimportir'])->name('importir')->middleware('role.protect:impor');
Route::get('/catalog', [ImportirController::class, 'catalog'])->name('catalog')->middleware('role.protect:impor');
Route::get('/formimportir', [ImportirController::class, 'formimportir'])->name('formimportir')->middleware('role.protect:impor');
Route::get('/my-orders', [ImportirController::class, 'myOrders'])->name('my.orders')->middleware('role.protect:impor');
Route::get('/detail', [ImportirController::class, 'detail'])->name('detail')->middleware('role.protect:impor');
Route::get('/requestimportir', [RequestController::class, 'importirRequestForm'])->name('requestimportir')->middleware('role.protect:impor');
Route::get('/product-detail-importir/{id}', [ImportirController::class, 'detail'])
        ->name('product.detail.importir')->middleware('role.protect:impor');
Route::get('/detailproductimportir/{id}', [ImportirController::class, 'detail'])
        ->name('detailproductimportir')->middleware('role.protect:impor');

// Transaction Routes - hanya role impor
Route::get('/transactions', [TransactionController::class, 'index'])
        ->name('transactions.index')->middleware('role.protect:impor');
Route::get('/transactions/{orderId}', [TransactionController::class, 'show'])
        ->name('transactions.show')->middleware('role.protect:impor');
Route::get('/transactions/{orderId}/tracking', [TransactionController::class, 'tracking'])
        ->name('transactions.tracking')->middleware('role.protect:impor');
Route::get('/transactions/{orderId}/invoice', [TransactionController::class, 'downloadInvoice'])
        ->name('transactions.invoice')->middleware('role.protect:impor');

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
Route::post('/contact-us', [ContactusController::class, 'storeContactUs'])->name('contactus.store');

// Halaman Ekspor - hanya role ekspor
Route::get('/ekspor', [EksportirController::class, 'homeeksportir'])->name('ekspor')->middleware('role.protect:ekspor');
Route::get('formeksportir', [EksportirController::class, 'formeksportir'])->name('formeksportir')->middleware('role.protect:ekspor');
Route::get('/requesteksportir', [RequestController::class, 'eksportirRequestList'])->name('requesteksportir')->middleware('role.protect:ekspor');

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
    Route::put('/product/{id}/update-field', [ProductController::class, 'updateField'])->name('product.updateField');
});

// Midtrans Payment API Routes
Route::prefix('api')->group(function () {
    Route::post('/midtrans/token', [CheckoutController::class, 'createSnapToken'])->name('midtrans.token');
    Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.notification');
});

// Cart Routes (for authenticated importers)
Route::middleware(['auth', 'role.protect:impor'])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart', [CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
});

// Checkout Routes
Route::middleware('role.protect:impor')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken'])->name('checkout.create-token');
    Route::get('/checkout/success/{orderId?}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pending/{orderId?}', [CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/checkout/error/{orderId?}', [CheckoutController::class, 'error'])->name('checkout.error');
    Route::get('/checkout/status/{orderId}', [CheckoutController::class, 'getOrderStatus'])->name('checkout.status');
});

// Midtrans Webhook (tidak perlu middleware karena dipanggil dari luar)
Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.webhook');
Route::post('/midtrans/callback', [CheckoutController::class, 'handleNotification'])->name('midtrans.callback');


// Request System Routes
Route::middleware('auth')->group(function () {
    // Importir Request Routes
    Route::middleware('role.protect:impor')->group(function () {
        Route::get('/importir/request', [RequestController::class, 'importirRequestForm'])->name('importir.request.form');
        Route::post('/importir/request', [RequestController::class, 'storeImportirRequest'])->name('importir.request.store');
    });
    
    // Eksportir Request Routes  
    Route::middleware('role.protect:ekspor')->group(function () {
        Route::get('/eksportir/requests', [RequestController::class, 'eksportirRequestList'])->name('eksportir.request.list');
        Route::post('/eksportir/requests/{id}/approve', [RequestController::class, 'approveRequest'])->name('eksportir.request.approve');
        Route::post('/eksportir/requests/{id}/reject', [RequestController::class, 'rejectRequest'])->name('eksportir.request.reject');
    });
    
    // Common Request Routes
    Route::delete('/requests/{id}', [RequestController::class, 'deleteRequest'])->name('request.delete');
});

// Notification Routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unread.count');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark.all.read');
});


// Route fallback - letakkan di paling bawah
Route::fallback(function () {
    $userRole = Auth::check() ? Auth::user()->role : 'guest';
    return response()->view('404', ['userRole' => $userRole], 404);
});

