# TriadGo 
Kelompok 3 KOM C 24 — Pemrograman Web Lanjutan

**TriadGo** adalah aplikasi web yang berfokus pada layanan ekspor-impor, dirancang untuk memudahkan pelaku bisnis dalam menjangkau pasar global. Platform ini membantu pengguna dalam mengelola prosedur logistik dan informasi pasar, serta memperluas jaringan perdagangan untuk mempromosikan produk lokal ke kancah internasional.

---

## ANGGOTA KELOMPOK

1. **Andre Al Farizi Sebayang** (241402105) — *Backend*
2. **Vincent Jose Christian Andreas Simbolon** (241402039) — *Frontend*
3. **Reagan Brian Siahaan** (241402099) — *Frontend*
4. **Abbil Rizki Abdillah** (241402033) — *Frontend & Backend*
5. **Daniele C.H Siahaan** (241402060) — *Frontend & Backend*

---

## FITUR YANG DITAWARKAN

- **Register (Login, Signup, Hash Password, Logout)**  
  Pengguna dapat membuat akun baru, masuk, keluar, dan data password disimpan dengan aman menggunakan hash.

- **Autentikasi berdasarkan role**  
  Sistem mengenali pengguna sebagai admin, importir, atau eksportir, dan menyesuaikan akses serta tampilan sesuai peran mereka.

- **Halaman khusus untuk Admin, Importir, dan Eksportir**  
  Setiap jenis pengguna memiliki halaman dashboard masing-masing sesuai kebutuhannya.

---

### FITUR IMPORTIR

- **Search bar untuk mencari produk**  
  Memudahkan pencarian produk berdasarkan nama.

- **Invoice & Payment Gateway**  
  Menyediakan detail tagihan dan proses pembayaran langsung melalui platform.

- **Keranjang belanja**  
  Importir dapat menyimpan produk yang ingin dibeli sebelum checkout.

- **Menampilkan produk berdasarkan negara**  
  Produk dapat difilter sesuai negara asal eksportir.

- **Melihat Status Pesanan**  
  Importir bisa memantau apakah pesanan sedang diproses, dikirim, atau sudah sampai.

- **Melakukan Permintaan terhadap barang yang tidak ada di katalog**  
  Jika barang belum tersedia, importir dapat mengajukan permintaan langsung ke eksportir.

---

### FITUR EKSPORTIR

- **Mengupload / Menambahkan barang yang akan dipesan**  
  Eksportir bisa mengelola produk yang ingin dijual, termasuk stok dan detail produk.

- **Komentar dari importir pada transaksi**  
  Eksportir dapat melihat ulasan atau komentar dari importir setelah transaksi berlangsung.

- **Menerima Permintaan barang dari Importir**  
  Permintaan produk dari importir dapat diterima atau ditolak oleh eksportir.

- **Menampilkan semua komentar importir untuk produk eksportir**  
  Eksportir bisa melihat semua feedback terkait produknya untuk evaluasi dan peningkatan.

- **Update status pesanan**  
  Eksportir dapat mengubah status pesanan seperti "diproses", "dikirim", atau "selesai".


---

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








