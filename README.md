# HotelTech - Sistem Reservasi Hotel

**Anggota Kelompok**
- **Arialdi Manday 241402006 :** Frontend 
- **Cindy Samosir  241402009 :** Backend
- **Dolly Efredi Bukit 241402021 :** Backend
- **Chaterine Eklesia Maryati 241402123 :** Frontend 
- **Fahrizal Ginting 221402 :** Backend

**HotelTech** adalah aplikasi berbasis web untuk manajemen reservasi hotel, dibangun menggunakan **Laravel 12**. Aplikasi ini mendukung autentikasi multi-user (Admin dan Guest), menggunakan TailwindCSS untuk styling, dan dirancang untuk pasar Indonesia dengan format bahasa dan mata uang lokal (Rupiah).

## Fitur Utama
- **Manajemen Reservasi:** Tamu dapat mencari kamar, membuat reservasi, dan melakukan pembayaran.
- **Manajemen Kamar:** Admin dapat mengelola tipe kamar, kamar, dan status ketersediaan.
- **Autentikasi Multi-User:** Role Admin untuk manajemen dan Guest untuk tamu.
- **Invoice dan Pembayaran:** Sistem pembayaran dan unduh invoice untuk tamu.
- **Ulasan:** Tamu dapat memberikan ulasan setelah menginap.
- **Desain Responsif:** Menggunakan TailwindCSS untuk antarmuka yang modern dan responsif.

**Teknologi yang dipakai :**
- **Laravel 12** 
- **TailwindCSS** 
- **MySQL 8.0**
- **PHP Framework**
- **XAMPP**
- **php MyAdmin**
- **Github**

## Alur Penggunaan Aplikasi

## Alur Reservasi untuk Guest
1 **Pencarian dan Pemilihan Kamar :**
- Guest login ke sistem
- Mencari kamar yang tersedia dengan memasukkan tanggal check-in/out
- Memilih tipe kamar yang diinginkan

2 **Pembuatan Reservasi :**
- Mengisi form reservasi dengan detail lengkap
- Menyimpan reservasi ke database

3 **Konfirmasi dan Pembayaran :**
- Melihat ringkasan reservasi
- Melakukan pembayaran
- Menerima konfirmasi reservasi
 
4 **Manajemen Reservasi :**
- Melihat daftar reservasi
- Melihat invoice
- Membatalkan reservasi jika diperlukan
- Memberikan ulasan setelah menginap

## Alur Manajemen untuk Admin
1 **Dashboard :**
- Admin login ke sistem
- Mengakses dashboard untuk melihat statistik

2 **Manajemen Kamar :**
- Mengelola tipe kamar dan kamar
- Memantau status kamar

3 **Manajemen Reservasi :** 
- Melihat dan mengelola semua reservasi
- Konfirmasi reservasi baru
- Proses check-in dan check-out
- Mengelola pembayaran dan invoice
