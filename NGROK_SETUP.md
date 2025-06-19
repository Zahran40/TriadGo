# Ngrok Setup untuk Midtrans Integration

## URL Ngrok Aktif
- **Current URL**: `https://dca3-180-249-47-190.ngrok-free.app`
- **Callback Endpoint**: `https://dca3-180-249-47-190.ngrok-free.app/midtrans/callback`
- **Status**: ✅ WORKING - Endpoint dapat menerima POST request

## Cara Menggunakan

### 1. Memastikan Ngrok Berjalan
```powershell
# Start ngrok tunnel
C:\Users\ASUS\AppData\Local\ngrok\ngrok.exe http 80

# Check tunnel status
Invoke-WebRequest -Uri "http://localhost:4040/api/tunnels" -UseBasicParsing | ConvertFrom-Json
```

### 2. Testing Endpoint
```powershell
# Test callback endpoint
Invoke-WebRequest -Uri "https://dca3-180-249-47-190.ngrok-free.app/midtrans/callback" -Method POST -ContentType "application/json" -Body '{"order_id":"TEST001","status_code":"200","gross_amount":"10000"}' -UseBasicParsing
```

### 3. Konfigurasi Midtrans Dashboard
1. Login ke Midtrans Dashboard Sandbox: https://dashboard.sandbox.midtrans.com/
2. Pilih Settings → Configuration  
3. Update Notification URL ke: `https://dca3-180-249-47-190.ngrok-free.app/midtrans/callback`
4. Update Finish Redirect URL ke: `https://dca3-180-249-47-190.ngrok-free.app/checkout/success`
5. Update Error Redirect URL ke: `https://dca3-180-249-47-190.ngrok-free.app/checkout/error`

## Status CSRF Protection
✅ CSRF protection sudah di-exclude untuk endpoint `midtrans/*` dan `test/*`

## Route yang Tersedia
- `POST /midtrans/callback` - Callback handler untuk notifikasi Midtrans
- `POST /midtrans/notification` - Alternative webhook endpoint  
- `POST api/midtrans/token` - Generate Snap Token
- `POST api/midtrans/notification` - API notification handler

## Testing Status
- ✅ Local endpoint: `http://triadgo.test/midtrans/callback` - WORKING
- ✅ Ngrok endpoint: `https://dca3-180-249-47-190.ngrok-free.app/midtrans/callback` - WORKING
- ✅ CSRF bypass configured for Midtrans endpoints
- ✅ Laravel application accessible via ngrok

## Log Monitoring
Cek Laravel logs untuk monitoring notifikasi:
```powershell
Get-Content -Path "storage\logs\laravel.log" -Tail 20 -Wait
```

## Catatan Penting
- URL ngrok berubah setiap restart (free plan)
- Update URL di Midtrans dashboard setiap kali restart ngrok
- Endpoint sudah siap untuk menerima notifikasi dari Midtrans
- Response 400 dari test adalah normal karena data test tidak sesuai format Midtrans
