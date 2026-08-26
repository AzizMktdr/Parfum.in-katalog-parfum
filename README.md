# 🌸 Parfum.in

> **Katalog & komunitas parfum berbasis Laravel** untuk menjelajahi parfum, menemukan produk, menyimpan favorit, memberikan review, dan berinteraksi dengan komunitas.

Parfum.in dibangun dengan **Laravel 12**, **Filament 3**, dan **Tailwind CSS**. Aplikasi menyediakan katalog parfum sekaligus fitur sosial seperti profil publik, follow, diskusi, koleksi, like, favorit, dan review.

---

## ✨ Fitur Utama

### 🧴 Katalog Parfum
- Daftar dan detail produk parfum
- Informasi brand, notes, dan accords
- Pencarian produk
- Rekomendasi parfum
- Hero/featured slides

### 👤 Akun & Profil
- Register dan login
- Lupa & reset password
- Profil pengguna
- Upload dan resize avatar
- Profil publik melalui `/u/{username}`
- Follow / unfollow
- Daftar followers & following

### 💬 Komunitas
- Membuat diskusi
- Balasan diskusi bertingkat
- Like pada diskusi dan balasan
- Koleksi parfum publik atau privat
- Like pada koleksi

### ❤️ Interaksi Produk
- Favorite parfum
- Review dan rating
- Halaman detail produk

### 🛠️ Admin Panel
Admin panel menggunakan **Filament 3** untuk mengelola:
- Produk
- Brand
- Notes
- Accords
- Hero slides
- Diskusi
- Laporan

---

## 🧰 Tech Stack

| Teknologi | Penggunaan |
|---|---|
| **PHP 8.2+** | Backend |
| **Laravel 12** | Web framework |
| **Filament 3.3** | Admin panel |
| **Laravel Sanctum** | Authentication/API support |
| **MySQL / MariaDB / PostgreSQL** | Database |
| **Tailwind CSS 4** | Styling |
| **Vite 7** | Frontend build tool |
| **Intervention Image 3** | Image processing & resizing |
| **PHPUnit 11** | Automated testing |

---

## 📋 Persyaratan Sistem

Pastikan environment lokal sudah memiliki:

- **PHP 8.2 atau lebih baru**
- **Composer 2.x**
- **Node.js 20 atau lebih baru**
- **npm**
- Salah satu database:
  - MySQL 8+
  - MariaDB 10.6+
  - PostgreSQL 14+
- Ekstensi PHP:
  - `pdo`
  - `mbstring`
  - `openssl`
  - `fileinfo`
  - `gd` — diperlukan untuk proses resize gambar

---

## 🚀 Instalasi

### 1. Clone repository

```bash
git clone <URL-REPOSITORY>
cd Parfum.in-katalog-parfum
```

### 2. Install dependency

```bash
composer install
npm install
```

### 3. Konfigurasi environment

Salin `.env.example` menjadi `.env`.

**macOS / Linux / Git Bash:**

```bash
cp .env.example .env
```

**Windows PowerShell:**

```powershell
Copy-Item .env.example .env
```

Kemudian sesuaikan konfigurasi database pada `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=parfumin
DB_USERNAME=parfumin_app
DB_PASSWORD=
```

> Untuk development lokal, gunakan kredensial database yang sesuai dengan environment Anda. Untuk production, jangan menggunakan user database `root`.

### 4. Generate application key

```bash
php artisan key:generate
```

### 5. Jalankan migration & seeder

```bash
php artisan migrate
php artisan db:seed
```

### 6. Buat symbolic link storage

Digunakan untuk file upload seperti avatar dan gambar:

```bash
php artisan storage:link
```

### 7. Jalankan aplikasi

Untuk development frontend:

```bash
npm run dev
```

Pada terminal lain:

```bash
php artisan serve
```

Kemudian buka:

```text
http://localhost:8000
```

### ⚡ Alternatif: gunakan Composer script

Project juga menyediakan script development yang menjalankan server Laravel, queue worker, log viewer, dan Vite secara bersamaan:

```bash
composer run dev
```

---

## 🔐 Konfigurasi Admin

Akun admin **tidak disimpan langsung di source code**. Konfigurasikan melalui `.env`:

```env
ADMIN_NAME="Admin Parfumin"
ADMIN_EMAIL=admin@parfumin.test
ADMIN_PASSWORD=
```

Kemudian jalankan:

```bash
php artisan db:seed --class=AdminSeeder
```

Jika `ADMIN_PASSWORD` dikosongkan, seeder akan membuat password acak dan menampilkannya **satu kali** di terminal.

> **Penting:** simpan password tersebut segera. Jangan commit password atau credential ke repository.

Panel admin dapat diakses melalui:

```text
http://localhost:8000/admin
```

---

## 🧪 Testing

Jalankan seluruh automated test dengan:

```bash
php artisan test
```

Atau:

```bash
composer test
```

Test menggunakan **SQLite in-memory** sesuai konfigurasi `phpunit.xml`, sehingga database development tidak akan digunakan.

> Beberapa test upload gambar membutuhkan ekstensi PHP **GD**.

### Test Coverage

| Test | Cakupan |
|---|---|
| `tests/Feature/Auth/*` | Login, register, forgot & reset password |
| `tests/Feature/ProfileTest.php` | Profil, avatar, dan password |
| `tests/Feature/PublicProfileTest.php` | Profil publik, username, dan bio |
| `tests/Feature/FollowTest.php` | Follow, unfollow, followers, following |
| `tests/Feature/CollectionTest.php` | Koleksi publik/privat, item, like |
| `tests/Feature/DiscussionTest.php` | Diskusi, nested replies, like, delete permission |
| `tests/Feature/ReviewTest.php` | Review parfum |
| `tests/Feature/FavoriteTest.php` | Favorite parfum |
| `tests/Feature/ProductPageTest.php` | Halaman produk |
| `tests/Feature/AdminPanelAccessTest.php` | Akses admin panel |
| `tests/Unit/UserRoleTest.php` | Role dan permission user |

---

## 🖼️ Image Processing

Parfum.in menggunakan **Intervention Image v3** untuk melakukan resize gambar di server.

### Ukuran Target

| Jenis Gambar | Ukuran |
|---|---:|
| Produk | `600 × 600 px` |
| Logo brand | `400 × 400 px` |
| Hero slide | `600 × 800 px` |

Proses resize ditangani oleh:

```text
app/Services/ImageResizeService.php
```

serta observer terkait.

### Struktur Asset

```text
public/
├── css/
│   └── app.css
└── images/
    ├── products/
    │   ├── california-signature.png
    │   ├── slide-2.png
    │   ├── slide-3.png
    │   ├── night-1.png ... night-5.png
    │   └── day-2.png ... day-5.png
    └── brands/
        └── mykonos.png
```

Untuk asset produk, **PNG transparan** direkomendasikan. Nama file hero dan rekomendasi dikelola melalui:

```text
app/Http/Controllers/HomeController.php
```

---

## 📁 Struktur Project

```text
Parfum.in-katalog-parfum/
├── app/
│   ├── Filament/          # Admin panel
│   ├── Http/              # Controllers, middleware, requests
│   ├── Models/            # Eloquent models
│   ├── Services/          # Business logic & image processing
│   └── ...
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── css/
│   └── images/
├── resources/
│   └── views/
├── routes/
│   └── web.php
├── tests/
│   ├── Feature/
│   └── Unit/
├── tools/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

---

## 🛡️ Rate Limiting

Beberapa aksi pengguna memiliki rate limit untuk membantu mencegah abuse:

| Aksi | Batas |
|---|---:|
| Login / register | 5 / menit |
| Kirim & reset password | 5 / menit |
| Ubah profil | 20 / menit |
| Ganti password | 6 / menit |
| Tulis review | 10 / menit |
| Buat diskusi / koleksi | 10 / menit |
| Balas diskusi | 20 / menit |
| Favorite, like, follow | 30–60 / menit |

---

## 📧 Email & Password Reset

Fitur lupa password membutuhkan konfigurasi `MAIL_*` pada `.env`.

Untuk development, konfigurasi default menggunakan:

```env
MAIL_MAILER=log
```

Email tidak benar-benar dikirim, tetapi ditulis ke:

```text
storage/logs/laravel.log
```

Untuk production, gunakan mail provider yang sesuai dan jangan commit credential email ke repository.

---

## 🚢 Deployment

Untuk production, perhatikan hal berikut:

1. **Document root** harus diarahkan ke folder `public/`.
2. Jangan menambahkan `.htaccess` tambahan di root project jika tidak diperlukan.
3. Gunakan:

   ```env
   APP_ENV=production
   APP_DEBUG=false
   ```

4. Gunakan database user khusus aplikasi, bukan `root`.
5. Aktifkan HTTPS.
6. Jika menggunakan HTTPS, set:

   ```env
   SESSION_SECURE_COOKIE=true
   ```

7. Setelah deployment, optimalkan cache:

   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

8. Untuk konfigurasi read replica, lihat:

   ```text
   .env.read-write-example
   ```

---

## 🔒 Environment & Security

File berikut **tidak boleh berisi credential production** dan sebaiknya tidak pernah di-commit:

```text
.env
```

Gunakan file contoh yang tersedia:

```text
.env.example
.env.read-write-example
```

Sebelum melakukan push ke GitHub, pastikan API key, password, database credential, dan secret lainnya tidak masuk ke repository.

---

## 🗂️ Dokumentasi Tambahan

Dokumentasi tambahan yang tersedia di repository:

- [`README1.md`](README1.md) — catatan asset dan struktur gambar
- [`README_SETUP.md`](README_SETUP.md) — catatan setup tambahan
- [`README_ADMIN.md`](README_ADMIN.md) — dokumentasi admin
- [`CARA-PAKAI.txt`](CARA-PAKAI.txt) — panduan penggunaan

---

## 👨‍💻 Development Workflow

Alur sederhana untuk menjalankan project:

```text
Clone Repository
       │
       ▼
Install Dependencies
       │
       ▼
Configure .env
       │
       ▼
Generate APP_KEY
       │
       ▼
Run Migration & Seeder
       │
       ▼
Create Storage Link
       │
       ▼
Start Laravel + Vite
       │
       ▼
     Parfum.in
```

---

## 📌 Catatan

Project ini dikembangkan sebagai aplikasi katalog dan komunitas parfum dengan fokus pada:

- pengelolaan katalog produk,
- pengalaman pengguna,
- interaksi sosial,
- review & favorite,
- serta administrasi data melalui Filament.

---

## 📄 License

This project is licensed under the **MIT License**.
