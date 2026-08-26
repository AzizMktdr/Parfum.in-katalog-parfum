# Parfum.in

Katalog & komunitas parfum berbasis **Laravel 12 + Filament 3**.

---

## 1. Kebutuhan Sistem

| Kebutuhan | Versi |
|-----------|-------|
| PHP | 8.2 atau lebih baru |
| Composer | 2.x |
| Node.js | 20 atau lebih baru |
| Database | MySQL 8 / MariaDB 10.6 / PostgreSQL 14 (SQLite dipakai untuk test) |
| Ekstensi PHP | `pdo`, `mbstring`, `openssl`, `fileinfo`, **`gd`** (wajib untuk resize gambar) |

---

## 2. Instalasi

```bash
composer install
npm install

cp .env.example .env
php artisan key:generate

# isi kredensial database di .env lebih dulu
php artisan migrate
php artisan db:seed

# akses file upload (avatar, gambar produk)
php artisan storage:link

npm run build      # atau: npm run dev
php artisan serve
```

### Akun admin

Akun admin **tidak lagi ditulis di dalam kode**. Isi di `.env`:

```env
ADMIN_NAME="Admin Parfumin"
ADMIN_EMAIL=admin@parfumin.test
ADMIN_PASSWORD=            # kosongkan agar seeder membuat password acak
```

Lalu jalankan:

```bash
php artisan db:seed --class=AdminSeeder
```

Kalau `ADMIN_PASSWORD` dikosongkan, password acak akan **ditampilkan sekali** di terminal. Simpan segera.
Seeder bersifat idempotent: menjalankannya ulang tidak menimpa password admin yang sudah ada.

Panel admin: `/admin`

---

## 3. Menjalankan Test

```bash
php artisan test
```

Test memakai SQLite in-memory (lihat `phpunit.xml`), jadi tidak menyentuh database asli.
Test upload avatar membutuhkan ekstensi **GD**.

Cakupan saat ini:

| Berkas | Isi |
|--------|-----|
| `tests/Feature/Auth/*` | login, register, lupa & reset password |
| `tests/Feature/ProfileTest.php` | ubah profil, avatar, ganti password |
| `tests/Feature/PublicProfileTest.php` | profil publik, username, bio |
| `tests/Feature/FollowTest.php` | follow / unfollow, followers, following |
| `tests/Feature/CollectionTest.php` | koleksi publik & privat, item, like |
| `tests/Feature/DiscussionTest.php` | diskusi, balasan bertingkat, like, hak hapus |
| `tests/Feature/ReviewTest.php`, `FavoriteTest.php`, `ProductPageTest.php` | review, favorit, halaman produk |
| `tests/Feature/AdminPanelAccessTest.php`, `tests/Unit/UserRoleTest.php` | hak akses admin |

---

## 4. Struktur Fitur

- **Katalog**: produk, brand, notes, accords, pencarian.
- **Akun**: register, login, lupa password (butuh konfigurasi `MAIL_*`), profil, avatar.
- **Profil publik**: `/u/{username}` — memakai username, atau ID kalau username belum diisi.
- **Sosial**: follow/unfollow, daftar followers & following.
- **Komunitas**: diskusi + balasan bertingkat + like, koleksi parfum publik/privat + like.
- **Admin (Filament)**: produk, brand, notes, accords, hero slide, diskusi, laporan.

---

## 5. Gambar & Resize Otomatis

Gambar di-resize di server memakai **Intervention Image v3** setiap produk/brand/hero disimpan
(lihat `app/Services/ImageResizeService.php` dan observer terkait).

| Tipe | Ukuran target |
|------|---------------|
| Produk | 600 × 600 px |
| Logo brand | 400 × 400 px |
| Hero slide | 600 × 800 px |

Struktur folder gambar:

```
public/
├── css/app.css
└── images/
    ├── products/
    │   ├── california-signature.png   (Slide 1 + Rekomendasi)
    │   ├── slide-2.png, slide-3.png
    │   ├── night-1.png … night-5.png (Koleksi Night)
    │   └── day-2.png … day-5.png     (Koleksi Day)
    └── brands/
        └── mykonos.png               (logo brand, PNG transparan)
```

Format ideal: PNG transparan — produk 600×800 px, logo brand 300×300 px.
Nama file hero/rekomendasi diatur di `app/Http/Controllers/HomeController.php`.

---

## 6. Catatan Deployment

1. **Document root harus diarahkan ke folder `public/`.** Jangan taruh `.htaccess` tambahan di root proyek.
2. Set `APP_DEBUG=false` dan `APP_ENV=production` di server.
3. Jangan pakai user database `root`; buat user khusus aplikasi.
4. Aktifkan HTTPS lalu set `SESSION_SECURE_COOKIE=true`.
5. Optimasi cache setelah deploy:

   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

6. Butuh replika baca? Lihat `.env.read-write-example` (`DB_READ_HOST`).

---

## 7. Rate Limit Bawaan

| Aksi | Batas |
|------|-------|
| Login / register | 5 per menit |
| Kirim & reset link password | 5 per menit |
| Ubah profil | 20 per menit |
| Ganti password | 6 per menit |
| Tulis review | 10 per menit |
| Buat diskusi / koleksi | 10 per menit |
| Balas diskusi | 20 per menit |
| Favorit, like, follow | 30–60 per menit |
