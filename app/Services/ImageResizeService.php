<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ImageResizeService 
{
    /**
     * Resize gambar ke ukuran target.
     * - PNG/WebP/GIF : scale (contain) + simpan sebagai PNG agar transparansi terjaga.
     * - JPG/JPEG lain : cover (crop center) + simpan sebagai JPEG seperti semula.
     * 
     * @param string|null $path Path relatif di disk 'public' (contoh: "products/abc.png")
     * @param int $width Target lebar dalam px
     * @param int $height Target tinggi dalam px
     */
    public static function resizeAndCrop(?string $path, int $width, int $height): void
    {
        if (!$path) return;

        $disk = Storage::disk('public');
        if (!$disk->exists($path)) return;

        try {
            // Setup Intervention Image v3
            $manager = new ImageManager(new Driver());
            $image = $manager->read($disk->get($path));

            $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

            if (in_array($extension, ['png', 'webp', 'gif'])) {
                // Scale agar gambar muat dalam kotak target (aspect ratio terjaga)
                // Menggunakan width dan height untuk menjaga batasan constraint
                $image->scale(width: $width, height: $height);
                
                // Simpan sebagai PNG agar kanal alpha tidak hilang
                $disk->put($path, $image->toPng());
            } else {
                // Format opaque (jpg/jpeg): crop ke tengah
                $image->cover($width, $height);
                
                // Pada v3, kualitas JPEG dimasukkan sebagai parameter (default 80)
                $disk->put($path, $image->toJpeg(quality: 85));
            }

        } catch (\Throwable $e) {
            // Gagal resize log error saja
            logger()->warning("ImageResizeService gagal resize [{$path}]: " . $e->getMessage());
        }
    }
}
