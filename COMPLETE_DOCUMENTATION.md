# 🎉 TriadGo - Complete System Documentation
## Laravel Export-Import Platform dengan Midtrans Integration & Dynamic Invoice System

---

## 📖 PROJECT OVERVIEW

**TriadGo** adalah aplikasi web yang berfokus pada layanan ekspor-impor, dirancang untuk memudahkan pelaku bisnis dalam menjangkau pasar global. Platform ini membantu pengguna dalam mengelola prosedur logistik dan informasi pasar, serta memperluas jaringan perdagangan untuk mempromosikan produk lokal ke kancah internasional.

### 🏆 ANGGOTA KELOMPOK
**Kelompok 3 KOM C 24 — Pemrograman Web Lanjutan**

1. **Andre Al Farizi Sebayang** (241402105) — *Backend*
2. **Vincent Jose Christian Andreas Simbolon** (241402039) — *Frontend*
3. **Reagan Brian Siahaan** (241402099) — *Frontend*
4. **Abbil Rizki Abdillah** (241402033) — *Frontend & Backend*
5. **Daniele C.H Siahaan** (241402060) — *Frontend & Backend*

---

## 🌟 SYSTEM OVERVIEW

Sistem checkout Laravel terintegrasi dengan Midtrans yang lengkap dengan:
- **Product Approval System** - Admin dapat meng-approve produk sebelum muncul di katalog
- **Order Monitoring Dashboard** - Admin dapat melihat semua transaksi checkout  
- **Payment Simulation** - Testing payment tanpa biaya real
- **Complete Midtrans Integration** - Full integration dengan Sandbox Midtrans
- **🆕 Invoice Dinamis** - Importir dapat print invoice sesuai data order mereka
- **Role-based Authentication** - Admin, Importir, dan Eksportir dengan hak akses berbeda

---

## 🚀 FITUR YANG DITAWARKAN

### 🔐 **FITUR UMUM**
- **Register (Login, Signup, Hash Password, Logout)**  
  Pengguna dapat membuat akun baru, masuk, keluar, dan data password disimpan dengan aman menggunakan hash.

- **Autentikasi berdasarkan role**  
  Sistem mengenali pengguna sebagai admin, importir, atau eksportir, dan menyesuaikan akses serta tampilan sesuai peran mereka.

- **Halaman khusus untuk Admin, Importir, dan Eksportir**  
  Setiap jenis pengguna memiliki halaman dashboard masing-masing sesuai kebutuhannya.

### 📦 **FITUR IMPORTIR**
- **Search bar untuk mencari produk** - Memudahkan pencarian produk berdasarkan nama atau kategori
- **🆕 Invoice & Payment Gateway** - Menyediakan detail tagihan dan proses pembayaran langsung melalui Midtrans
- **Keranjang belanja** - Importir dapat menyimpan produk yang ingin dibeli sebelum checkout
- **Menampilkan produk berdasarkan negara** - Produk dapat difilter sesuai negara asal eksportir
- **Menampilkan stok/sisa barang** - Informasi ketersediaan barang ditampilkan
- **🆕 Melihat Status Pesanan** - Importir bisa memantau pesanan real-time
- **🆕 Print Invoice Dinamis** - Cetak invoice sesuai data order yang dibeli
- **🆕 My Orders & Invoice Access** - Tombol akses cepat ke orders dan invoice di halaman checkout
- **Melakukan Permintaan terhadap barang yang tidak ada di katalog** - Request produk yang belum tersedia

### 🏭 **FITUR EKSPORTIR**
- **Mengupload / Menambahkan barang yang akan dipesan** - Kelola produk yang ingin dijual
- **Komentar dari importir pada transaksi** - Lihat ulasan atau komentar dari importir
- **Menerima Permintaan barang dari Importir** - Proses permintaan produk dari importir
- **Menampilkan semua komentar importir untuk produk eksportir** - Lihat semua feedback produk
- **Update status pesanan** - Ubah status pesanan ("diproses", "dikirim", "selesai")

### 👨‍💼 **FITUR ADMIN**
- **🆕 Product Approval System** - Approve/reject produk sebelum muncul di katalog
- **🆕 Order Monitoring Dashboard** - Monitor semua transaksi dan pembayaran
- **🆕 Real-time Order Tracking** - Lihat status order dan payment real-time
- **🆕 Invoice Management** - Akses dan print invoice untuk semua order
- **User Management** - Kelola pengguna dan role mereka

---

## 🎯 ADVANCED FEATURES IMPLEMENTED

### 1. **Product Management System**
- ✅ Hanya produk dengan status "approved" yang muncul di katalog importir
- ✅ Halaman Filament "Product Approval" untuk admin meng-approve produk
- ✅ Product seeder untuk sample data

### 2. **Complete Checkout System**
- ✅ Complete checkout flow dengan Midtrans Snap
- ✅ Order creation dan Snap Token generation
- ✅ Webhook handler untuk update status otomatis
- ✅ Success/pending/error pages dengan redirect yang tepat

### 3. **Advanced Admin Dashboard**
- ✅ Order Monitoring page di Filament untuk admin
- ✅ Real-time order status tracking dengan auto-refresh
- ✅ Complete order details dan payment info
- ✅ Direct access ke invoice untuk setiap order

### 4. **🆕 Dynamic Invoice System**
- ✅ Dynamic invoice generation berdasarkan data checkout_orders
- ✅ Print-optimized design dengan Tailwind CSS
- ✅ Automatic currency formatting (IDR/USD)
- ✅ Integration dengan admin panel dan user checkout flow
- ✅ Professional invoice layout dengan company branding

### 5. **Payment Testing & Simulation**
- ✅ Test payment pages tanpa login requirement
- ✅ Force payment simulation untuk testing
- ✅ Automatic sync ke Midtrans Dashboard

### 6. **🆕 User Experience Enhancement**
- ✅ Quick access buttons untuk My Orders & Invoices di halaman checkout
- ✅ Order statistics display untuk user
- ✅ Smart conditional display (invoice button hanya muncul jika ada paid orders)

---

## 🛠️ TECHNICAL IMPLEMENTATION

### **Database Schema**

#### **Users Table**
```sql
- user_id (Primary Key)
- name, email, password
- role (admin/eksportir/impor)
- country, profile_picture
- timestamps
```

#### **Products Table**
```sql
- product_id (Primary Key)
- user_id (Foreign Key)
- product_name, product_description
- category, price, stock
- status (pending/approved/rejected)
- product_image, country_of_origin
- timestamps
```

#### **🆕 CheckoutOrders Table**
```sql
- order_id (Primary Key)
- user_id (Foreign Key)
- snap_token, total_amount
- status (pending/paid/cancelled/failed)
- billing info (first_name, last_name, email, phone, address, city, state, zip_code, country)
- timestamps
```

#### **🆕 CartItems Table**
```sql
- id (Primary Key)  
- order_id (Foreign Key)
- product_id (Foreign Key)
- quantity, price_per_item, total_price
- timestamps
```

### **Controllers Implementation**

#### **🆕 CheckoutController**
```php
- index() - Halaman checkout dengan cart items
- createSnapToken() - Generate Midtrans Snap Token
- handleCallback() - Webhook handler untuk Midtrans
- success(), pending(), error() - Status pages
```

#### **🆕 InvoiceController** 
```php
- show($orderId) - Display invoice untuk specific order
- Validasi user authorization
- Dynamic data loading dari database
```

#### **🆕 ImportirController**
```php
- homeimportir() - Homepage dengan top products
- catalog() - Product catalog dengan search & filter
- myOrders() - User order history
```

### **🆕 MidtransService Integration**
```php
- createSnapToken($orderData) - Generate Snap token
- handleWebhook($notification) - Process payment notifications
- Error handling dan logging
```

### **Middleware & Security**
- **role.protect** - Role-based access control
- **CSRF Protection** - Form security
- **Input Validation** - Data sanitization
- **Authentication** - Login requirement for protected routes

---

## 🔧 ROUTE STRUCTURE & OPTIMIZATION

### **Route Groups & Protection**

#### **Admin Routes (Filament)**
```php
Route::prefix('admin')->group(function () {
    // Product Approval
    // Order Monitoring  
    // User Management
});
```

#### **Importir Protected Routes**
```php
Route::middleware('role.protect:impor')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index']);
    Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken']);
    Route::get('/checkout/success/{orderId?}', [CheckoutController::class, 'success']);
    Route::get('/checkout/pending/{orderId?}', [CheckoutController::class, 'pending']);
    Route::get('/checkout/error/{orderId?}', [CheckoutController::class, 'error']);
    Route::get('/my-orders', [ImportirController::class, 'myOrders']);
    Route::get('/invoice/{orderId}', [InvoiceController::class, 'show']);
});
```

#### **Public & Testing Routes**
```php
// Midtrans webhook (no auth required)
Route::post('/midtrans/callback', [CheckoutController::class, 'handleCallback']);

// Test pages for development
Route::get('/test-payment/{orderId}', [CheckoutController::class, 'testPayment']);
Route::post('/force-simulate-payment', [CheckoutController::class, 'forceSimulatePayment']);
```

### **🧹 Route Cleanup & Optimization**

#### **Before Cleanup:**
```php
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'index'])
Route::post('/checkout/create-snap-token', [App\Http\Controllers\CheckoutController::class, 'createSnapToken'])
```

#### **After Cleanup:**
```php
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\InvoiceController;

Route::get('/checkout', [CheckoutController::class, 'index']);
Route::post('/checkout/create-snap-token', [CheckoutController::class, 'createSnapToken']);
```

**Benefits:**
- ✅ **Cleaner Code** - Shorter, more readable route definitions
- ✅ **Better Maintainability** - DRY principle, import once use everywhere
- ✅ **Consistent Style** - All controllers follow same pattern

---

## 🎨 FRONTEND IMPLEMENTATION

### **🆕 Dynamic Invoice Design**
- **Professional Layout** - Clean, print-optimized design
- **Company Branding** - TriadGo logo dan informasi perusahaan
- **Responsive Design** - Works on desktop dan mobile
- **Print Optimization** - CSS khusus untuk printing

### **Checkout User Experience**
- **Multi-step Process** - Order summary → Billing → Payment
- **Real-time Validation** - Form validation dengan feedback
- **Payment Gateway Integration** - Seamless Midtrans Snap popup
- **Status Feedback** - Clear success/error messages

### **🆕 Quick Access Interface**
- **Smart Buttons** - Contextual buttons berdasarkan user state
- **Order Statistics** - Display total orders, paid orders, pending orders
- **Conditional Display** - Invoice button hanya muncul jika ada paid orders
- **User-friendly Navigation** - Easy access dari halaman checkout

---

## 🗄️ DATABASE SEEDING & SAMPLE DATA

### **Product Seeder**
```php
// Creates sample products with different statuses
- 3 approved products (muncul di katalog)
- 2 pending products (menunggu approval)
- 1 rejected product (tidak muncul)
```

### **🆕 CheckoutOrder Seeder**
```php
// Creates sample orders dengan berbagai status
- Paid orders (untuk testing invoice)
- Pending orders (untuk testing payment flow)
- Cancelled orders (untuk testing edge cases)
```

### **User Seeder**
```php
// Sample users untuk testing
- Admin user (full access)
- Eksportir users (product management)
- Importir users (checkout & orders)
```

---

## 🚀 DEPLOYMENT & CONFIGURATION

### **Environment Configuration**
```env
# Midtrans Configuration
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Application
APP_URL=https://your-domain.com
APP_ENV=production
```

### **🌐 Public URL Setup untuk Midtrans**

#### **Development dengan ngrok/serveo:**
```bash
# Menggunakan ngrok
ngrok http 8000

# Atau menggunakan serveo.net
ssh -R 80:localhost:8000 serveo.net
```

#### **Konfigurasi Midtrans URLs:**
```
Payment Notification URL: https://your-public-url.com/midtrans/callback
Finish Redirect URL: https://your-public-url.com/checkout/success
Unfinish Redirect URL: https://your-public-url.com/checkout/pending
Error Redirect URL: https://your-public-url.com/checkout/error
```

### **Server Requirements**
- **PHP 8.1+** dengan extensions yang diperlukan
- **MySQL/MariaDB** untuk database
- **Composer** untuk dependency management
- **Node.js & NPM** untuk asset compilation

---

## 🧪 TESTING & QUALITY ASSURANCE

### **Payment Testing**
- ✅ **Test Cards** - Menggunakan Midtrans test cards
- ✅ **Simulation Pages** - Manual payment simulation
- ✅ **Webhook Testing** - Automated status updates
- ✅ **Error Handling** - Payment failures dan timeouts

### **User Flow Testing**
- ✅ **Registration & Login** - All user roles
- ✅ **Product Management** - Admin approval workflow
- ✅ **Shopping Cart** - Add to cart, checkout process
- ✅ **Order Management** - Order creation, status tracking
- ✅ **Invoice Generation** - Dynamic invoice creation

### **Security Testing**
- ✅ **Authentication** - Login protection
- ✅ **Authorization** - Role-based access control
- ✅ **Input Validation** - XSS dan SQL injection prevention
- ✅ **CSRF Protection** - Form security

---

## 📊 SYSTEM ARCHITECTURE

### **MVC Pattern Implementation**
```
Models (Data Layer):
├── User.php (Authentication & roles)
├── Product.php (Product management)
├── CheckoutOrder.php (Order management)
└── CartItem.php (Order items)

Controllers (Logic Layer):
├── CheckoutController.php (Checkout flow)
├── InvoiceController.php (Invoice generation)
├── ImportirController.php (Importir features)
└── Filament/ (Admin panel)

Views (Presentation Layer):
├── checkout/ (Checkout pages)
├── invoice.blade.php (Invoice template)
├── my-orders.blade.php (Order history)
└── importir.blade.php (Homepage)
```

### **Service Layer**
```
Services/
├── MidtransService.php (Payment processing)
└── Future services (Email, Notification, etc.)
```

### **Database Relationships**
```
Users (1) → (n) Products
Users (1) → (n) CheckoutOrders
CheckoutOrders (1) → (n) CartItems
Products (1) → (n) CartItems
```

---

## 🔮 FUTURE ENHANCEMENTS

### **Planned Features**
- **Email Notifications** - Order confirmations, payment receipts
- **Advanced Analytics** - Sales reports, performance metrics
- **Multi-language Support** - English/Indonesian interface
- **Mobile App** - React Native atau Flutter implementation
- **API Development** - RESTful API untuk third-party integrations

### **Technical Improvements**
- **Caching Implementation** - Redis untuk performance
- **Queue System** - Background job processing
- **File Storage** - Cloud storage untuk product images
- **Monitoring** - Application performance monitoring

---

## 📚 DOCUMENTATION & RESOURCES

### **Code Documentation**
- **PHPDoc Comments** - Comprehensive method documentation
- **README.md** - Quick start guide
- **API Documentation** - Endpoints dan usage examples

### **Development Resources**
- **Laravel Documentation** - Framework guidelines
- **Midtrans Documentation** - Payment gateway integration
- **Filament Documentation** - Admin panel usage

---

## 🎉 CONCLUSION

**TriadGo** telah berhasil diimplementasikan sebagai platform ekspor-impor yang komprehensif dengan fitur-fitur modern seperti:

✅ **Complete E-commerce Flow** - Dari product listing hingga payment processing  
✅ **Advanced Admin Panel** - Comprehensive management tools dengan Filament  
✅ **Professional Invoice System** - Dynamic invoice generation dengan clean design  
✅ **Modern User Experience** - Responsive design dengan smart navigation  
✅ **Robust Security** - Role-based access control dan input validation  
✅ **Payment Gateway Integration** - Full Midtrans integration dengan testing tools  

Sistem ini siap untuk production deployment dan dapat dengan mudah di-extend untuk kebutuhan bisnis yang lebih kompleks.

---

## 👥 DEVELOPMENT TEAM CREDITS

**Frontend Development:**
- Vincent Jose Christian Andreas Simbolon
- Reagan Brian Siahaan  
- Abbil Rizki Abdillah (Frontend & Backend)
- Daniele C.H Siahaan (Frontend & Backend)

**Backend Development:**
- Andre Al Farizi Sebayang
- Abbil Rizki Abdillah (Frontend & Backend)
- Daniele C.H Siahaan (Frontend & Backend)

**Project Leadership:**
- Kelompok 3 KOM C 24 — Pemrograman Web Lanjutan

---

*Documentation last updated: June 2025*  
*TriadGo Platform - Version 1.0*
