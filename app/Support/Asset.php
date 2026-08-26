<?php

namespace App\Support;

/**
 * Helper aset: otomatis memakai versi .min.css / .min.js kalau file-nya ada
 * (mis. setelah `npm run minify`), dan menambahkan cache-busting ?v=filemtime
 * supaya browser tidak menyimpan versi lama.
 *
 * Pemakaian di Blade:
 *   <link rel="stylesheet" href="{{ \App\Support\Asset::css('css/app.css') }}">
 *   <script src="{{ \App\Support\Asset::js('js/app.js') }}" defer></script>
 */
class Asset
{
    public static function css(string $path): string
    {
        return self::resolve($path, '.css');
    }

    public static function js(string $path): string
    {
        return self::resolve($path, '.js');
    }

    private static function resolve(string $path, string $ext): string
    {
        $min = preg_replace('/' . preg_quote($ext, '/') . '$/', '.min' . $ext, $path);

        // Di production, pakai versi minified jika tersedia
        if ($min && file_exists(public_path($min)) && !config('app.debug')) {
            $path = $min;
        }

        $full = public_path($path);
        $version = file_exists($full) ? filemtime($full) : null;

        return asset($path) . ($version ? '?v=' . $version : '');
    }
}
