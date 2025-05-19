# HotelTech - Sistem Reservasi Hotel

**HotelTech** adalah aplikasi berbasis web untuk manajemen reservasi hotel, dibangun menggunakan **Laravel 12**. Aplikasi ini mendukung autentikasi multi-user (Admin dan Guest), menggunakan TailwindCSS untuk styling, dan dirancang untuk pasar Indonesia dengan format bahasa dan mata uang lokal (Rupiah).

## Fitur Utama
- **Manajemen Reservasi:** Tamu dapat mencari kamar, membuat reservasi, dan melakukan pembayaran.
- **Manajemen Kamar:** Admin dapat mengelola tipe kamar, kamar, dan status ketersediaan.
- **Autentikasi Multi-User:** Role Admin untuk manajemen dan Guest untuk tamu.
- **Invoice dan Pembayaran:** Sistem pembayaran dan unduh invoice untuk tamu.
- **Ulasan:** Tamu dapat memberikan ulasan setelah menginap.
- **Desain Responsif:** Menggunakan TailwindCSS untuk antarmuka yang modern dan responsif.

## Prasyarat
Sebelum memulai, pastikan Anda memiliki:
- **PHP** >= 8.2
- **Composer** (untuk mengelola dependensi PHP)
- **Node.js** dan **NPM** (untuk TailwindCSS dan aset frontend)
- **MySQL** atau database lain yang didukung Laravel
- **Git** (untuk cloning repository)

## Langkah Instalasi

### 1. Clone Repository
Clone proyek ini ke komputer Anda:
```bash
git clone https://github.com/RafiIkhwan/hoteltech.git
cd hoteltech
```

### 2. Instal Dependensi PHP
Gunakan Composer untuk menginstal dependensi Laravel:
```bash
composer install
```

### 3. Instal Dependensi Frontend
Instal dependensi frontend (TailwindCSS dan lainnya) menggunakan NPM:
```bash
npm install
```

### 4. Konfigurasi Environment
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```

Kemudian, edit file `.env` untuk mengatur koneksi database dan konfigurasi lainnya:
```env
APP_NAME=HotelTech
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hoteltech
DB_USERNAME=root
DB_PASSWORD=
```

Generate kunci aplikasi:
```bash
php artisan key:generate
```

### 5. Migrasi Database
Jalankan migrasi untuk membuat tabel di database:
```bash
php artisan migrate
```

Jika Anda ingin mengisi database dengan data dummy, jalankan seeder (opsional):
```bash
php artisan db:seed
```

### 6. Kompilasi Aset Frontend
Kompilasi aset TailwindCSS dan JavaScript menggunakan Vite (default di Laravel 12):
```bash
npm run dev
```
Untuk production, gunakan:
```bash
npm run build
```

### 7. Jalankan Server
Jalankan server development Laravel:
```bash
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`.

## Struktur Database
Berikut adalah tabel utama yang digunakan dalam proyek ini:

1. **users**
   - `id`, `name`, `email`, `password`, `role` (admin/guest), `created_at`, `updated_at`
2. **room_types**
   - `id`, `name` (Standard/Deluxe/Suite), `description`, `price`, `capacity`, `amenities`, `created_at`, `updated_at`
3. **rooms**
   - `id`, `room_number`, `room_type_id`, `floor`, `status` (available/occupied/maintenance), `created_at`, `updated_at`
4. **guests**
   - `id`, `name`, `email`, `phone`, `address`, `id_card_type`, `id_card_number`, `created_at`, `updated_at`
5. **reservations**
   - `id`, `reservation_number`, `guest_id`, `check_in_date`, `check_out_date`, `adults`, `children`, `status` (confirmed/checked_in/checked_out/cancelled), `total_amount`, `payment_status`, `created_at`, `updated_at`
6. **reservation_rooms**
   - `id`, `reservation_id`, `room_id`, `price_per_night`, `created_at`, `updated_at`
7. **invoices**
   - `id`, `invoice_number`, `reservation_id`, `total_amount`, `tax_amount`, `grand_total`, `payment_method`, `payment_status`, `notes`, `created_at`, `updated_at`

## Autentikasi Multi-User
Proyek ini menggunakan autentikasi multi-user dengan dua role utama:
- **Admin:** Mengelola kamar, reservasi, dan invoice.
- **Guest:** Melakukan reservasi, pembayaran, dan memberikan ulasan.

## Penggunaan
- **Admin:** Login sebagai admin untuk mengelola kamar, reservasi, dan invoice. Akses dashboard di `/admin/dashboard`.
- **Guest:** Login sebagai tamu untuk membuat reservasi dan melihat riwayat.
- **Pencarian Kamar:** Gunakan `/rooms/search` untuk mencari kamar yang tersedia.
- **Detail Kamar:** Klik "Lihat Detail" pada tipe kamar untuk melihat informasi lebih lanjut di `/rooms/{roomType}`.

## Struktur Direktori
- `app/Http/Controllers/`: Berisi controller untuk Admin, Guest, dan fungsi umum.
- `resources/views/`: Berisi file Blade untuk tampilan (admin, guest, dan umum).
- `database/migrations/`: Berisi file migrasi untuk membuat tabel.
- `public/`: Berisi aset statis seperti gambar dan file CSS/JS yang telah dikompilasi.

## Lisensi
Proyek ini dilisensikan di bawah [MIT License](LICENSE).

## Kontak
Jika ada pertanyaan atau masalah, hubungi:
- Email: [rafiikhwan2006@gmail.com]
- GitHub: [RafiIkhwan](https://github.com/RafiIkhwan)

---

### Catatan Tambahan
- **Penyesuaian:** Anda bisa menyesuaikan bagian "Kontak" dan "Lisensi" sesuai kebutuhan.
- **Seeder:** Jika Anda memiliki seeder untuk data dummy (misalnya, tipe kamar atau pengguna awal), sebutkan di README.
- **Dependensi Tambahan:** Jika proyek Anda menggunakan package tambahan (misalnya, untuk pembayaran atau PDF), tambahkan ke bagian "Prasyarat" atau "Instalasi".