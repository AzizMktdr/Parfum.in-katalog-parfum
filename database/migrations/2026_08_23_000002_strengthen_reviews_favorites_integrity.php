<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Memperkuat integritas data reviews & favorites yang sebelumnya hanya
 * terhubung ke produk lewat string `product_slug` tanpa index/constraint:
 *  1. hapus review duplikat (user yang sama, produk yang sama)
 *  2. index pada product_slug + unique (user_id, product_slug) di reviews
 *  3. foreign key ke products.slug (cascade on update/delete) bila didukung
 *     driver DB dan tidak ada data orphan
 */
return new class extends Migration {
    private const FK_DRIVERS = ['mysql', 'mariadb', 'pgsql'];

    public function up(): void
    {
        // 1. Sisakan review paling awal untuk tiap kombinasi user + produk.
        $keepIds = DB::table('reviews')
            ->selectRaw('MIN(id) as keep_id')
            ->groupBy('user_id', 'product_slug')
            ->pluck('keep_id')
            ->all();

        if (! empty($keepIds)) {
            DB::table('reviews')->whereNotIn('id', $keepIds)->delete();
        }

        // 2. Index & unique constraint.
        Schema::table('reviews', function (Blueprint $table) {
            if (! Schema::hasIndex('reviews', 'reviews_product_slug_index')) {
                $table->index('product_slug', 'reviews_product_slug_index');
            }
            if (! Schema::hasIndex('reviews', 'reviews_user_id_product_slug_unique')) {
                $table->unique(['user_id', 'product_slug'], 'reviews_user_id_product_slug_unique');
            }
        });

        Schema::table('favorites', function (Blueprint $table) {
            if (! Schema::hasIndex('favorites', 'favorites_product_slug_index')) {
                $table->index('product_slug', 'favorites_product_slug_index');
            }
        });

        // 3. Foreign key ke products.slug.
        //    SQLite tidak mendukung ALTER TABLE ADD CONSTRAINT, jadi dilewati.
        if (! in_array(DB::connection()->getDriverName(), self::FK_DRIVERS, true)) {
            return;
        }

        foreach (['reviews', 'favorites'] as $tableName) {
            // Kalau masih ada baris yang menunjuk slug produk tidak dikenal,
            // FK akan gagal. Bersihkan/samakan data dulu, lalu jalankan:
            // php artisan migrate:refresh --path=database/migrations/2026_08_23_000002_strengthen_reviews_favorites_integrity.php
            if ($this->orphanCount($tableName) > 0) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                $table->foreign('product_slug', $tableName . '_product_slug_foreign')
                    ->references('slug')
                    ->on('products')
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (in_array(DB::connection()->getDriverName(), self::FK_DRIVERS, true)) {
            foreach (['reviews', 'favorites'] as $tableName) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    $table->dropForeign($tableName . '_product_slug_foreign');
                });
            }
        }

        Schema::table('reviews', function (Blueprint $table) {
            if (Schema::hasIndex('reviews', 'reviews_user_id_product_slug_unique')) {
                $table->dropUnique('reviews_user_id_product_slug_unique');
            }
            if (Schema::hasIndex('reviews', 'reviews_product_slug_index')) {
                $table->dropIndex('reviews_product_slug_index');
            }
        });

        Schema::table('favorites', function (Blueprint $table) {
            if (Schema::hasIndex('favorites', 'favorites_product_slug_index')) {
                $table->dropIndex('favorites_product_slug_index');
            }
        });
    }

    private function orphanCount(string $tableName): int
    {
        return DB::table($tableName)
            ->whereNotIn('product_slug', function (QueryBuilder $query) {
                $query->select('slug')->from('products');
            })
            ->count();
    }
};
