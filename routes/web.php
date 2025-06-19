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
Route::get('/requestimportir', [ImportirController::class, 'requestimportir'])->name('requestimportir')->middleware('role.protect:impor');
Route::get('/product-detail-importir/{id}', [ImportirController::class, 'detail'])
        ->name('product.detail.importir')->middleware('role.protect:impor');
Route::get('/detailproductimportir/{id}', [ImportirController::class, 'detail'])
        ->name('detailproductimportir')->middleware('role.protect:impor');

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
Route::get('/requesteksportir', [EksportirController::class, 'requesteksportir'])->name('requesteksportir')->middleware('role.protect:ekspor');

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

// Checkout Routes
Route::middleware('role.protect:impor')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken'])->name('checkout.create-token');
    Route::get('/checkout/success/{orderId?}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/checkout/pending/{orderId?}', [CheckoutController::class, 'pending'])->name('checkout.pending');
    Route::get('/checkout/error/{orderId?}', [CheckoutController::class, 'error'])->name('checkout.error');
    Route::get('/checkout/status/{orderId}', [CheckoutController::class, 'getOrderStatus'])->name('checkout.status');
});

// Midtrans Webhook (tidak perlu middleware karena dipanggil dari luar)
Route::post('/midtrans/notification', [CheckoutController::class, 'handleNotification'])->name('midtrans.webhook');
Route::post('/midtrans/callback', [CheckoutController::class, 'handleNotification'])->name('midtrans.callback');

// Test routes untuk simulasi payment (tanpa CSRF untuk testing)
Route::prefix('test')->group(function () {
    Route::get('/payment/{orderId}', [CheckoutController::class, 'testPaymentPage'])->name('test.payment');
    Route::get('/order-status/{orderId}', [CheckoutController::class, 'getOrderStatus'])->name('test.order.status');
});

// Force simulate payment route (tanpa CSRF untuk testing)
Route::post('/force-simulate-payment/{orderId}', [CheckoutController::class, 'forceSimulatePayment'])->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

// Test login route for debugging
Route::get('/test-login', function () {
    return view('test-login');
});

// Test debug route for product detail
Route::get('/test-debug-detail/{id?}', function ($id = null) {
    return view('test-debug-detail');
})->name('test.debug.detail');

// Test database connection
Route::get('/test-db-connection', function () {
    try {
        $products = \App\Models\Product::where('status', 'approved')->take(5)->get();
        $users = \App\Models\User::where('role', 'impor')->take(3)->get();
        
        return response()->json([
            'status' => 'success',
            'products_count' => $products->count(),
            'products' => $products->map(function($p) {
                return [
                    'id' => $p->product_id,
                    'name' => $p->product_name,
                    'price' => $p->price,
                    'status' => $p->status
                ];
            }),
            'users_count' => $users->count(),
            'users' => $users->map(function($u) {
                return [
                    'id' => $u->user_id,
                    'name' => $u->name,
                    'role' => $u->role
                ];
            })
        ]);
    } catch (Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
});

// Test auth status
Route::get('/test-auth', function () {
    return response()->json([
        'authenticated' => Auth::check(),
        'user' => Auth::user() ? [
            'id' => Auth::user()->user_id,
            'name' => Auth::user()->name,
            'email' => Auth::user()->email,
            'role' => Auth::user()->role
        ] : null
    ]);
});

// Test product detail without auth (for debugging)
Route::get('/test-product-direct/{id}', function ($id) {
    try {
        $product = \App\Models\Product::with('user','comments.user')
                         ->where('product_id', $id)
                         ->where('status', 'approved')
                         ->first();
        
        if (!$product) {
            return response("Product $id not found or not approved", 404);
        }
        
        return view('detailproductimportir', compact('product'));
    } catch (Exception $e) {
        return response("Error: " . $e->getMessage(), 500);
    }
});

// Route fallback - letakkan di paling bawah
Route::fallback(function () {
    $userRole = Auth::check() ? Auth::user()->role : 'guest';
    return response()->view('404', ['userRole' => $userRole], 404);
});

