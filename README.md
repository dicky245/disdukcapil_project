# Sistem Antrian Online
## Disdukcapil Kabupaten Toba

Sistem antrian online berbasis web untuk Disdukcapil Kabupaten Toba dengan fitur lengkap untuk pengambilan nomor antrian, pelacakan berkas, dan manajemen antrian.

---

## Fitur Utama

### Untuk Pengguna (Public)
- Ambil nomor antrian online
- Generate nomor antrian unik (format: ABC-123-456)
- Pencarian antrian berdasarkan nama dan layanan
- Tiket antrian dengan detail lengkap
- Estimasi waktu tunggu
- Statistik antrian real-time

### Untuk Admin
- Dashboard statistik antrian
- Kelola antrian (Mulai, Selesai, Hapus)
- Filter berdasarkan status dan layanan
- Update status lacak berkas
- Riwayat lengkap setiap antrian
- Real-time update (setiap 30 detik)

---

## Quick Start

### 1. Install Dependencies
```bash
composer install
npm install
```

### 2. Setup Database
```bash
# Copy .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Setup database di .env file
```

### 3. Run Migrations
```bash
php artisan migrate
```

### 4. Run Seeders
```bash
php artisan db:seed --class=Layanan_Seeder
```

### 5. Link Storage (jika perlu)
```bash
php artisan storage:link
```

### 6. Start Development Server
```bash
php artisan serve
```

### 7. Akses Aplikasi
- **Public**: `http://localhost:8000`
- **Antrian Online**: `http://localhost:8000/antrian-online`
- **Admin Login**: `http://localhost:8000/login`

---

## Struktur Project

```
app/
├── Models/                           # Eloquent Models
│   ├── Layanan_Model.php            # Model Layanan
│   ├── Jenis_Keagamaan_Model.php    # Model Jenis Keagamaan
│   ├── Keagamaan_Model.php          # Model Keagamaan
│   ├── Antrian_Online_Model.php     # Model Antrian Online
│   └── Lacak_Berkas_Model.php       # Model Lacak Berkas
│
├── Http/Controllers/                # Controllers
│   ├── Pengguna_Controller.php      # Controller untuk pengguna (public)
│   ├── Admin_Controller.php         # Controller untuk admin (folder Admin/)
│   └── Keagamaan/
│       └── Keagamaan_Controller.php # Controller untuk keagamaan
│
└── Http/Controllers/Auth/
    └── Login_Controller.php         # Controller untuk autentikasi

database/
├── migrations/                      # Database Migrations
│   ├── 2026_03_06_000001_create_layanan_table.php
│   ├── 2026_03_06_000002_create_jenis_keagamaan_table.php
│   ├── 2026_03_06_000003_create_keagamaan_table.php
│   ├── 2026_03_06_000004_create_antrian_online_table.php
│   └── 2026_03_06_000005_create_lacak_berkas_table.php
│
└── seeders/                         # Database Seeders
    ├── Layanan_Seeder.php
    └── Status_Lacak_Berkas_Seeder.php

resources/views/                     # Blade Templates
├── antrian_online.blade.php        # Halaman antrian (public)
└── admin/
    └── antrian_online.blade.php    # Halaman kelola antrian (admin)

routes/
└── web.php                          # Route definitions
```

---

## Aturan Penamaan

Sistem ini menggunakan **Snake_Pascal_Case** untuk konsistensi:

### Nama File
```php
Layanan_Model.php
Antrian_Online_Model.php
Pengguna_Controller.php
```

### Nama Class
```php
class Layanan_Model extends Model
class Antrian_Online_Model extends Model
class Pengguna_Controller extends Controller
```

### Nama Function
```php
public function tambah_antrian_online()
public function cari_antrian()
public function get_detail_antrian()
```

### Variabel dalam Function
```php
$nama_lengkap = 'John Doe';
$no_hp = '08123456789';
$nomor_antrian = 'ABC-123-456';
```

---

## Database Schema

### Tabel `layanan`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| layanan_id | BIGINT | Primary Key |
| nama_layanan | VARCHAR(100) | Unique |
| keterangan | TEXT | Nullable |
| estimasi_waktu | INT | Dalam menit |

### Tabel `antrian_online`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| antrian_online_id | BIGINT | Primary Key |
| nomor_antrian | VARCHAR(20) | Unique, format: ABC-123-456 |
| nama_lengkap | VARCHAR(100) | - |
| no_hp | VARCHAR(20) | - |
| tanggal | DATE | - |
| jam | VARCHAR(20) | - |
| layanan_id | BIGINT | Foreign Key |
| status_antrian | ENUM | Menunggu, Sedang Diproses, Selesai, Dibatalkan |

### Tabel `lacak_berkas`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| lacak_berkas_id | BIGINT | Primary Key |
| antrian_online_id | BIGINT | Foreign Key |
| status | VARCHAR(100) | - |
| tanggal | DATE | - |
| keterangan | TEXT | Nullable |

---

## Routes Utama

### Public Routes
| Route | Method | Controller | Method |
|-------|--------|------------|--------|
| / | GET | Pengguna_Controller | index |
| antrian-online | GET | Pengguna_Controller | antrian_online |
| antrian-online/tambah | POST | Pengguna_Controller | tambah_antrian_online |
| antrian-online/cari | GET | Pengguna_Controller | cari_antrian |

### Admin Routes (Auth Required)
| Route | Method | Controller | Method |
|-------|--------|------------|--------|
| admin/dashboard | GET | Admin_Controller | dashboard |
| admin/antrian-online | GET | Admin_Controller | antrian_online |
| admin/antrian-online/data | GET | Admin_Controller | get_data_antrian |
| admin/antrian-online/mulai/{id} | POST | Admin_Controller | mulai_antrian |
| admin/antrian-online/selesai/{id} | POST | Admin_Controller | selesaikan_antrian |

---

## Cara Penggunaan

### Pengguna - Ambil Antrian
1. Buka halaman `/antrian-online`
2. Pilih layanan yang diinginkan
3. Pilih tanggal dan jam kedatangan
4. Masukkan nama lengkap dan nomor WhatsApp
5. Klik tombol "Ambil Nomor Antrian"
6. Tiket akan muncul dengan nomor unik

### Pengguna - Cari Antrian
1. Scroll ke bagian "Lupa Nomor Antrian?"
2. Masukkan nama lengkap
3. (Opsional) Pilih jenis layanan
4. Klik "Cari Antrian"
5. Hasil pencarian akan ditampilkan

### Admin - Kelola Antrian
1. Login sebagai admin
2. Akses `/admin/antrian-online`
3. Lihat statistik antrian hari ini
4. Gunakan filter untuk mencari antrian spesifik
5. Lakukan aksi:
   - **Mulai**: Mulai proses antrian
   - **Selesai**: Selesaikan antrian
   - **Detail**: Lihat detail dan riwayat
   - **Berkas**: Update status berkas
   - **Hapus**: Hapus antrian (hanya Menunggu)

---

## Akun Default

Setelah menjalankan seeder, berikut adalah akun default:

| Role | Username | Password |
|------|----------|----------|
| Admin | admin | admin123 |
| Keagamaan | keagamaan | keagamaan123 |

**PENTING**: Ganti password default di production!

---

## Troubleshooting

### Migration Error
```bash
# Reset database dan jalankan ulang
php artisan migrate:fresh --seed
```

### Route Not Found
```bash
# Clear route cache
php artisan route:clear
php artisan config:clear
```

### Permission Issues
```bash
# Linux/Mac
chmod -R 775 storage bootstrap/cache

# Windows (XAMPP/WAMP)
# Pastikan folder storage dan bootstrap/cache writable
```

### Composer Issues
```bash
# Clear composer cache
composer clear-cache

# Reinstall dependencies
composer install --no-dev
```

---

## Catatan Pengembangan

### Fitur yang Sudah Implementasi
- [x] Generate nomor antrian unik (ABC-123-456)
- [x] Booking antrian online
- [x] Pencarian antrian
- [x] Statistik real-time
- [x] Lacak berkas
- [x] Manajemen antrian admin
- [x] Format penamaan Snake_Pascal_Case
- [x] Responsive design

### Fitur yang Bisa Dikembangkan
- [ ] Notifikasi WhatsApp/SMS
- [ ] Export tiket ke PDF
- [ ] Integrasi dengan payment gateway
- [ ] Sistem rating
- [ ] Mobile app
- [ ] Analitik dan reporting

---

## Kontak & Support

Untuk pertanyaan atau masalah:
- **Email**: support@dukcapiltoba.go.id
- **Telepon**: (0632) 123456
- **Alamat**: Balige, Kabupaten Toba

---

## Lisensi

Copyright © 2025 Disdukcapil Kabupaten Toba. All rights reserved.

---

## Tim Pengembang

- **Developer**: Disdukcapil Kabupaten Toba
- **Version**: 1.0.0
- **Framework**: Laravel 11
- **PHP Version**: 8.2+

---

**Terakhir Diupdate**: 6 Maret 2026
