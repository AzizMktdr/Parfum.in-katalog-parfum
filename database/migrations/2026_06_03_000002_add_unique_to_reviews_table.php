<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Satu user hanya boleh menulis satu review per produk.
 *
 * Catatan:
 * - Data duplikat dibersihkan lebih dulu, kalau tidak penambahan unique
 *   akan gagal di database yang sudah berisi review ganda.
 * - Nama index disamakan dengan konvensi Laravel
 *   (reviews_user_id_product_slug_unique) supaya tidak dibuat dua kali
 *   oleh migrasi integritas berikutnya.
 */
return new class extends Migration
{
    private const INDEX = 'reviews_user_id_product_slug_unique';

    public function up(): void
    {
        if (Schema::hasIndex('reviews', self::INDEX)) {
            return;
        }

        // Sisakan review paling awal untuk tiap kombinasi user + produk.
        $keepIds = DB::table('reviews')
            ->selectRaw('MIN(id) as keep_id')
            ->groupBy('user_id', 'product_slug')
            ->pluck('keep_id')
            ->all();

        if (! empty($keepIds)) {
            DB::table('reviews')->whereNotIn('id', $keepIds)->delete();
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->unique(['user_id', 'product_slug'], self::INDEX);
        });
    }

    public function down(): void
    {
        if (! Schema::hasIndex('reviews', self::INDEX)) {
            return;
        }

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropUnique(self::INDEX);
        });
    }
};
