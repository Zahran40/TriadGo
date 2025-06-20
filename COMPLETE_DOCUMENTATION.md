# TriadGO - Complete Documentation

## 🚀 PROJECT OVERVIEW

**TriadGo** adalah aplikasi web yang berfokus pada layanan ekspor-impor, dirancang untuk memudahkan pelaku bisnis dalam menjangkau pasar global. Platform ini menggunakan Laravel dengan Filament Admin Panel dan integrasi pembayaran Midtrans.

### Team Members
1. **Andre Al Farizi Sebayang** (241402105) — *Backend*
2. **Vincent Jose Christian Andreas Simbolon** (241402039) — *Frontend*
3. **Reagan Brian Siahaan** (241402099) — *Frontend*
4. **Abbil Rizki Abdillah** (241402033) — *Frontend & Backend*
5. **Daniele C.H Siahaan** (241402060) — *Frontend & Backend*

---

## 📋 NGROK SETUP & CONFIGURATION

### Current Ngrok Information
- **URL**: Updates automatically on each restart
- **Callback Endpoint**: `https://[ngrok-url]/midtrans/callback`
- **Status**: Managed automatically by AI Assistant

### Midtrans Dashboard URLs (Update when ngrok restarts)
```
1. Notification URL: https://[ngrok-url]/midtrans/callback
2. Finish Redirect URL: https://[ngrok-url]/checkout/success
3. Unfinish Redirect URL: https://[ngrok-url]/checkout/pending
4. Error Redirect URL: https://[ngrok-url]/checkout/error
```

### Quick Ngrok Commands
```powershell
# Start ngrok tunnel
C:\Users\ASUS\AppData\Local\ngrok\ngrok.exe http 80 --host-header=triadgo.test

# Check tunnel status
Invoke-WebRequest -Uri "http://localhost:4040/api/tunnels" -UseBasicParsing | ConvertFrom-Json

# Test callback endpoint
Invoke-WebRequest -Uri "https://[ngrok-url]/midtrans/callback" -Method POST -ContentType "application/json" -Body '{"order_id":"TEST001","status_code":"200","gross_amount":"10000"}' -UseBasicParsing
```

---

## 💳 MIDTRANS INTEGRATION STATUS

### ✅ Successfully Implemented Features
- **Payment Gateway**: Snap Token generation and processing
- **Callback Handler**: Robust notification processing
- **Status Updates**: Automatic order status changes (pending → settlement/paid)
- **Payment Methods**: Credit Card, GoPay, QRIS, ShopeePay, Bank Transfer
- **Email Notifications**: Automated order confirmation emails
- **Admin Dashboard**: Order management and payment tracking

### Payment Flow
1. **Order Creation** → Database record with "pending" status
2. **Snap Token Generation** → Midtrans payment page
3. **Payment Processing** → Customer completes payment
4. **Notification Callback** → Status update to "settlement"/"paid"
5. **Email Confirmation** → Automatic notification sent
6. **Admin Dashboard** → Real-time order tracking

### Available Routes
```php
// Payment Routes
POST /api/midtrans/token          // Generate Snap Token
POST /midtrans/callback           // Main callback handler
POST /midtrans/notification       // Alternative webhook endpoint
POST /api/midtrans/notification   // API notification handler

// Checkout Routes
GET  /checkout/success            // Payment success page
GET  /checkout/pending            // Payment pending page
GET  /checkout/error             // Payment error page
```

---

## 🗃️ DATABASE STRUCTURE

### Key Models & Relations
```php
// User Model
- hasMany(CheckoutOrder::class)
- hasMany(Product::class) // for exporters

// Product Model  
- belongsTo(User::class) // exporter
- hasMany(CheckoutOrder::class)

// CheckoutOrder Model
- belongsTo(User::class) // buyer/importer
- belongsTo(Product::class)
```

### Migration Files
- `create_users_table` - User management with roles
- `create_products_table` - Product catalog with status
- `create_checkout_orders_table` - Order tracking with payment status
- `create_sessions_table` - Session management
- `create_contactus_table` - Contact form submissions

---

## 🎨 FILAMENT ADMIN PANEL

### Custom Widgets
- **TotalProductsWidget** - Product statistics
- **TotalUsersWidget** - User registration stats  
- **TotalOrdersWidget** - Order and revenue tracking
- **TriadGoInfoWidget** - Custom branding and info

### Admin Features
- **User Management** - Role-based access control
- **Product Management** - CRUD operations with image uploads
- **Order Tracking** - Real-time payment status monitoring
- **Dashboard Analytics** - Charts and statistics

### Custom Branding
- Logo: `/public/tglogo.png`
- Favicon: `/public/favicon.ico`
- Colors: Custom blue theme matching TriadGO brand

---

## 🔧 DEVELOPMENT SETUP

### Prerequisites
```bash
# Required Software
- PHP 8.1+
- Composer
- Node.js & NPM
- Laravel 10
- Laragon/XAMPP for local development
- Ngrok for tunnel setup
```

### Installation
```bash
# Clone and setup
composer install
npm install
cp .env.example .env
php artisan key:generate

# Database setup
php artisan migrate
php artisan db:seed

# Development server
php artisan serve
npm run dev
```

### Environment Configuration
```env
# Database
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

# Midtrans Configuration
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false

# Mail Configuration
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your_email@gmail.com
MAIL_PASSWORD=your_app_password
```

---

## 🔍 TROUBLESHOOTING

### Common Issues & Solutions

#### 1. Ngrok URL Changes
**Problem**: Ngrok restarts and URL changes  
**Solution**: Update all Midtrans dashboard URLs immediately

#### 2. Payment Status Not Updating
**Problem**: Orders remain "pending"  
**Solution**: 
- Check ngrok tunnel is active
- Verify Midtrans dashboard URLs are correct
- Test callback endpoint manually
- Check Laravel logs for errors

#### 3. QRIS "Unparsable" Error
**Problem**: QR code scanning fails  
**Solution**: 
- Enable QRIS in Midtrans dashboard
- Set acquirer to "airpay shopee"
- Test with Midtrans payment simulator

#### 4. Email Notifications Not Sending
**Problem**: Order confirmations not received  
**Solution**:
- Verify SMTP configuration
- Check if using real email addresses (not test@example.com)
- Enable "Less secure app access" for Gmail

### Debug Commands
```powershell
# Check Laravel logs
Get-Content -Path "storage\logs\laravel.log" -Tail 20 -Wait

# Test database connection
php artisan tinker
>>> DB::connection()->getPdo();

# Check order status
php artisan tinker
>>> App\Models\CheckoutOrder::latest()->take(5)->get(['order_id', 'status', 'payment_type']);
```

---

## 🚀 PRODUCTION DEPLOYMENT

### Security Considerations
- Never expose ngrok tunnels in production
- Use proper SSL certificates
- Implement rate limiting for callbacks
- Monitor webhook endpoints for suspicious activity
- Use Midtrans production environment with proper credentials

### Recommended Production Setup
1. **Web Server**: Apache/Nginx with SSL
2. **Database**: MySQL/PostgreSQL (not SQLite)
3. **Caching**: Redis for sessions and cache
4. **Queue**: Database/Redis for email processing
5. **Monitoring**: Laravel Telescope or similar
6. **Backup**: Regular database and file backups

---

## 📊 CURRENT STATUS

### ✅ Completed Features
- User authentication with role-based access
- Product catalog with image uploads
- Shopping cart functionality
- Midtrans payment integration
- Order tracking and status updates
- Email notifications
- Admin dashboard with analytics
- Filament custom widgets and branding
- Ngrok tunnel setup for development
- Comprehensive documentation

### 🔄 Ongoing Maintenance
- Ngrok URL monitoring and updates
- Payment flow testing with various methods
- Error handling and logging improvements
- User interface enhancements
- Performance optimization

---

## 📞 SUPPORT

### Getting Help
1. Check this documentation first
2. Review Laravel logs for errors
3. Test endpoints manually with provided commands
4. Verify Midtrans dashboard configuration
5. Contact development team for complex issues

### Quick Reference Links
- **Midtrans Dashboard**: https://dashboard.sandbox.midtrans.com/
- **Ngrok Dashboard**: http://localhost:4040/
- **Laravel Documentation**: https://laravel.com/docs
- **Filament Documentation**: https://filamentphp.com/docs

---

**Last Updated**: Auto-managed by AI Assistant  
**Status**: Production Ready ✅  
**Version**: Laravel 10 + Filament 3 + Midtrans Integration
