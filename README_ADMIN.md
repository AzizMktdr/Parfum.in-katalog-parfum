# PARFUM.IN — Setup Admin Dashboard (Filament)

## Langkah Install

### 1. Install Filament via Composer
```bash
composer require filament/filament:"^3.0"
```

### 2. Install Filament Assets
```bash
php artisan filament:install --panels
```
> Pilih `admin` saat ditanya panel ID

### 3. Jalankan Migration Baru
```bash
php artisan migrate
```
> Migration baru: brands, notes, accords, products, pivot tables, role di users

### 4. Buat Admin Pertama
```bash
php artisan db:seed --class=AdminSeeder
```
> Login: admin@parfumin.com / admin123

### 5. Link Storage untuk Upload Gambar
```bash
php artisan storage:link
```

### 6. Jalankan Server
```bash
php artisan serve
```

### 7. Buka Admin Dashboard
```
http://127.0.0.1:8000/admin
```

---

## File yang Ditambahkan

```
app/
  Models/
    Brand.php
    Note.php
    Accord.php
    Product.php
    User.php        ← diupdate (tambah role + FilamentUser)

  Filament/
    Pages/
      Dashboard.php
      Laporan.php
    Widgets/
      StatsOverview.php
      TopProductsWidget.php
      UserGrowthWidget.php
    Resources/
      ProductResource.php + Pages/
      BrandResource.php   + Pages/
      NoteResource.php    + Pages/
      AccordResource.php  + Pages/
      UserResource.php    + Pages/
      ReviewResource.php  + Pages/

  Providers/Filament/
    AdminPanelProvider.php

database/
  migrations/
    2024_01_02_000001_create_brands_table.php
    2024_01_02_000002_create_notes_table.php
    2024_01_02_000003_create_accords_table.php
    2024_01_02_000004_create_products_table.php
    2024_01_02_000005_create_pivot_tables.php
    2024_01_02_000006_add_role_to_users.php
  seeders/
    AdminSeeder.php

resources/views/filament/pages/
  laporan.blade.php
```

---

## Fitur Admin Dashboard

| Halaman       | Fitur                                              |
|---------------|----------------------------------------------------|
| Dashboard     | Statistik total parfum, brand, user, review + chart |
| Data Parfum   | CRUD + upload gambar + filter brand/kategori       |
| Brand         | CRUD + upload logo                                 |
| Notes         | CRUD top/middle/base notes                         |
| Accords       | CRUD dengan color picker                           |
| Manajemen User| Lihat, edit role, hapus user                       |
| Review        | Lihat & hapus review                               |
| Laporan       | Grafik user growth + review + top produk           |

---

## Troubleshooting

**Error: Class not found**
```bash
composer dump-autoload
```

**Error: Filament not found**
```bash
composer require filament/filament:"^3.0"
```

**Upload gambar tidak jalan**
```bash
php artisan storage:link
```
