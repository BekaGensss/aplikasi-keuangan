# 📈 Aplikasi Perencanaan Keuangan Pribadi

[![Laravel v9.x](https://img.shields.io/badge/Laravel-9.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP v8.1+](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.0+-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

Aplikasi web sederhana untuk membantu pengguna mencatat pemasukan dan pengeluaran, serta membuat anggaran bulanan. Aplikasi ini dilengkapi dengan visualisasi data yang menarik untuk memudahkan analisis keuangan pribadi.

---

## ✨ Fitur Utama

-   **Dashboard Interaktif**: Menampilkan ringkasan keuangan, grafik pengeluaran per kategori, dan aliran kas bulanan.
-   **Manajemen Transaksi**: Fitur lengkap **CRUD** (Create, Read, Update, Delete) untuk mencatat pemasukan dan pengeluaran.
-   **Sistem Anggaran**: Pengguna dapat menetapkan anggaran bulanan untuk setiap kategori pengeluaran dan mendapatkan notifikasi jika batas terlampaui.
-   **Manajemen Saldo Awal**: Pengguna dapat mengatur saldo awal mereka melalui antarmuka web.
-   **Ekspor Data**: Tersedia fitur untuk mengunduh semua riwayat transaksi dalam format CSV.
-   **Autentikasi Pengguna**: Aplikasi ini dilindungi dengan sistem login dan register yang aman (menggunakan Laravel Breeze).

---

## 🚀 Teknologi

-   **Framework**: Laravel 9+
-   **Bahasa**: PHP 8.1+
-   **Database**: MySQL
-   **Frontend**: Tailwind CSS, Blade Templates, JavaScript (Chart.js)
-   **Lingkungan Pengembangan**: Laragon

---

## 🛠️ Cara Instalasi

Ikuti langkah-langkah di bawah ini untuk menjalankan proyek di lingkungan lokal Anda.

### 1. Klon Repositori

```bash
git clone [https://github.com/BekaGensss/aplikasi-keuangan.git](https://github.com/BekaGensss/aplikasi-keuangan.git)
cd aplikasi-keuangan

2. Instal Dependensi
Instal paket-paket PHP dan Node.js yang dibutuhkan.
Bash
composer install
npm install

3. Konfigurasi Lingkungan
Buat salinan file .env.example dan ubah namanya menjadi .env.
Bash
cp .env.example .env
Atur detail koneksi database Anda di file .env.
Jalankan perintah untuk menghasilkan APP_KEY.
Bash
php artisan key:generate

4. Migrasi dan Seeding Database
Jalankan migrasi untuk membuat tabel-tabel database dan tambahkan data awal kategori.
Bash
php artisan migrate
php artisan db:seed --class=KategoriSeeder

5. Jalankan Aplikasi
Jalankan Vite untuk mengompilasi aset CSS dan JavaScript, dan jalankan server pengembangan Laragon.
Bash
npm run dev
Aplikasi Anda sekarang dapat diakses di URL yang disediakan oleh Laragon (misalnya http://aplikasi-keuangan.test).

👨‍💻 Penggunaan
Registrasi: Buat akun baru di halaman /register.

Login: Masuk ke aplikasi menggunakan akun yang sudah terdaftar.

Atur Saldo Awal: Setelah login, Anda akan diminta untuk mengatur saldo awal Anda.

Mulai Mencatat: Gunakan menu navigasi untuk mulai mencatat pemasukan dan pengeluaran Anda.

📄 Lisensi
Proyek ini dilisensikan di bawah Lisensi MIT (MIT License). Lihat file LICENSE untuk detailnya.

Setelah Anda membuat file `README.md` dan menempelkan isinya, jangan lupa untuk mengunggahnya ke GitHub dengan perintah berikut:
```bash
git add README.md
git commit -m "Add README file with license and icons"
git push origin main

Nama Pengembang
Bara Kusuma

