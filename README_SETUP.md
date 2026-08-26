# 🚀 SETUP PARFUM.IN

## Langkah-langkah Setup

### 1. Copy ke project Laravel
Copy semua file ke folder project Laravel Anda yang sudah ada.

### 2. Setup Database
Copy `.env.example` menjadi `.env` dan sesuaikan:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=parfumin
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru:
```sql
CREATE DATABASE parfumin CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Generate App Key
```bash
php artisan key:generate
```

### 4. Jalankan Migration
```bash
php artisan migrate
```

Ini akan membuat tabel:
- `users` — data pengguna
- `reviews` — review parfum
- `favorites` — daftar favorit user

### 5. Jalankan Server
```bash
php artisan serve
```

Buka: http://localhost:8000

---

## 📁 Struktur Gambar yang Diperlukan

```
public/
├── images/
│   ├── products/
│   │   ├── california-signature.png  ← Mykonos
│   │   ├── invade.png                ← Mykonos
│   │   ├── dreamscape.png            ← Mykonos
│   │   ├── penthouse.png             ← Mykonos & HMNS
│   │   ├── icarus.png                ← Velixir
│   │   ├── elixir-noir.png           ← Velixir
│   │   ├── aurora.png                ← Velixir
│   │   ├── orgsm.png                 ← HMNS
│   │   └── ... (25 produk total)
│   ├── brands/
│   │   ├── mykonos.png
│   │   └── ...
│   ├── notes/
│   │   ├── bergamot.png
│   │   └── ...
│   └── auth/
│       ├── login-bg.jpg
│       └── signup-bg.jpg
```

---

## ✅ Fitur yang Sudah Berfungsi

- ✅ Login & Register dengan validasi database
- ✅ Logout
- ✅ Simpan/hapus favorit (hanya saat login)
- ✅ Write review (hanya saat login)
- ✅ Load review dari database
- ✅ Badge jumlah favorit di navbar
- ✅ Avatar user di navbar
- ✅ Dropdown menu user (favorit, logout)
- ✅ Modal peringatan jika belum login
- ✅ Toast notification
- ✅ Navbar hide/show on scroll
- ✅ Dark mode
