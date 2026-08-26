<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Tambahan index yang belum tercakup migrasi sebelumnya.
 *
 * Tidak lagi menambahkan:
 * - reviews (user_id, product_slug) → sudah ada unique dengan kolom yang sama
 * - users.username                 → sudah ada index dari constraint unique
 */
return new class extends Migration
{
    /** @var array<string, array<string, string|array<int, string>>> */
    private array $indexes = [
        'products' => [
            'products_brand_id_index' => 'brand_id',
            'products_gender_index'   => 'gender',
        ],
        'reviews' => [
            'reviews_created_at_index' => 'created_at',
        ],
        'users' => [
            'users_role_created_at_index' => ['role', 'created_at'],
        ],
        'collections' => [
            'collections_user_id_index' => 'user_id',
        ],
        'discussions' => [
            'discussions_created_at_index' => 'created_at',
        ],
        'favorites' => [
            'favorites_user_id_product_slug_index' => ['user_id', 'product_slug'],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $tableName => $definitions) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $definitions) {
                foreach ($definitions as $indexName => $columns) {
                    if (! Schema::hasIndex($tableName, $indexName)) {
                        $table->index($columns, $indexName);
                    }
                }
            });
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $tableName => $definitions) {
            if (! Schema::hasTable($tableName)) {
                continue;
            }

            Schema::table($tableName, function (Blueprint $table) use ($tableName, $definitions) {
                foreach (array_keys($definitions) as $indexName) {
                    if (Schema::hasIndex($tableName, $indexName)) {
                        $table->dropIndex($indexName);
                    }
                }
            });
        }
    }
};
