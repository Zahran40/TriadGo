# TriadGo 
Kelompok 3 KOM C 24 — Pemrograman Web Lanjutan

**TriadGo** adalah platform web inovatif yang memfasilitasi transaksi perdagangan internasional (ekspor-impor). Aplikasi ini dirancang untuk menjembatani eksportir lokal dengan importir global secara aman, transparan, dan efisien. TriadGo membantu memangkas birokrasi, memantau pengiriman secara real-time, dan mengintegrasikan sistem pembayaran otomatis berskala internasional.

---

## ANGGOTA KELOMPOK

1. **Andre Al Farizi Sebayang** (241402105) — *Backend*
2. **Vincent Jose Christian Andreas Simbolon** (241402039) — *Frontend*
3. **Reagan Brian Siahaan** (241402099) — *Frontend*
4. **Abbil Rizki Abdillah** (241402033) — *Frontend & Backend*
5. **Daniele C.H Siahaan** (241402060) — *Frontend & Backend*

---

## FITUR-FITUR UTAMA & SISTEM INTEGRASI

### 🔑 Autentikasi & Manajemen Pengguna
* **Sistem Registrasi & Login Aman**: Dilengkapi dengan pengamanan enkripsi password satu arah menggunakan PHP native hashing di level database.
* **Role-Based Access Control (RBAC)**: Pembagian akses spesifik untuk 3 tipe aktor utama: **Admin**, **Eksportir**, dan **Importir**.
* **Integrasi Desain Dialog**: Konfirmasi logout dan pop-up aksi menggunakan SweetAlert2 interaktif dengan dukungan dark/light mode yang harmonis.

---

### 🚢 FITUR IMPORTIR
* **Pencarian Produk Cerdas**: Pencarian produk secara dinamis berdasarkan nama produk dan filter asal negara eksportir.
* **Manajemen Keranjang Belanja**: Keranjang interaktif dengan kalkulasi berat otomatis, subtotal harga, ongkos kirim, dan kalkulasi pajak terintegrasi.
* **Integrasi Payment Gateway Midtrans (Sandbox)**: Mendukung pembayaran multi-channel (E-wallet seperti GoPay, QRIS, Virtual Account Bank BCA/BNI/Permata/Mandiri, dll.).
* **On-Demand Auto-Paid Synchronization**: Sinkronisasi status pembayaran real-time saat halaman detail dibuka, menjamin status pesanan otomatis terupdate dari `pending` ke `paid` sesaat setelah transfer berhasil tanpa butuh intervensi manual.
* **Pelacakan Pengiriman (Order Tracking)**: Tampilan visual tahapan logistik (Warehouse -> Packing -> Customs -> Shipping -> Delivered) setelah pesanan sukses dibayar.
* **Permintaan Produk Khusus (Request Barang)**: Fitur untuk mengajukan pengadaan barang yang belum terdaftar di katalog kepada eksportir tertentu.

---

### 💼 FITUR EKSPORTIR
* **Manajemen Produk Ekspor**: Form input detail produk, harga, berat (kg), negara asal, deskripsi, gambar produk, dan penguncian constraint stok produk secara dinamis.
* **Manajemen Pesanan Masuk (Order Dashboard)**: Dashboard pemantauan status pesanan dari importir beserta integrasi sinkronisasi status pembayaran dengan Midtrans.
* **Pengiriman Logistik**: Fitur untuk melakukan update status tahapan pengiriman barang pesanan importir.
* **Review & Feedback**: Fitur untuk melihat ulasan, bintang, dan komentar tertulis dari importir pasca-transaksi selesai.
* **Persetujuan Request Barang**: Panel untuk melihat, menerima, atau menolak permintaan produk khusus dari importir secara instan.

---

### 👑 FITUR ADMIN PANEL
* **Dashboard Statistik Interaktif (Filament)**: Visualisasi grafik penjualan harian, sebaran produk berdasarkan kategori, asal negara eksportir, stok produk, dan distribusi peran pengguna.
* **Manajemen Data CRUD Terpusat**: Pengelolaan data Users, Products, dan Orders secara aman melalui antarmuka admin yang dioptimalkan kinerjanya.

## TEKNOLOGI YANG DIGUNAKAN
- Laravel 12
- PHP 8.2
- MySQL
- XAMPP / Laragon
- GitHub
- Visual Studio Code (VSCode)
- phpMyAdmin
- midtrans

## LIBRARY YANG DIGUNAKAN 
- Tailwind CSS v4.0.7
- SweetAlert2
- Filament
- Google Fonts 

---

### TATA CARA MENJALANKAN APLIKASI :
1. Akses halaman github : https://github.com/Zahran40/TriadGo.git ,lalu ekstrack file nya ke folder
2. jika menggunakan laragaon pindahkan file ke folder www , jika menggunakan xamppp pindahan file ke folder htdocs
3. Buka file tersebut menggunakan vs code
4. buka terminal lalu ketikan "composer install" untuk menginstal package laravel
5. ketikan di terminal "cp .env.example .env"
6. kemudian ketikan juga di terminal "php artisan migrate" agar database terbuat
7. ketikan "npm install" dan "npm run dev" untuk menjalankan tailwind dan node js
8. lalu terakhir ketikan "php artisan serve" agar website dapat di akses di browser
9. Saat web berhasil di buka anda harus memilih masuk sebagai importir atau eksportir,jika anda memilih role eksportir maka anda akan di arahkan ke halaman eksportir, jika anda memilih importir anda akan di arahkan ke halaman importir
10. terakhir jika anda ingin melihat halaman admin anda bisa membuat akun dengan role khusus admin di phpmyadnmin , contoh :
    Username : Admin
    email : Admin@gmail.com
    password : Admin1234


    TERIMAKASIH SEMOGA DENGAN ADANYA TRIAD GO BISA MEMBANTU KEGIATAN IMPORT EKSPORT MENJADI LEBIH MUDAH
    (BISMILLAH PWL A)








