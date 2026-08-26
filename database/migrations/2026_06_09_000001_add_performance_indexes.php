<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Index untuk query yang paling sering dipakai.
 *
 * Pengecekan memakai Schema::hasIndex() bawaan Laravel supaya tetap jalan
 * di MySQL, PostgreSQL, maupun SQLite (dipakai saat menjalankan test).
 */
return new class extends Migration
{
    /** @var array<string, array<string, string|array<int, string>>> */
    private array $indexes = [
        'products' => [
            'products_is_active_collection_index' => ['is_active', 'collection'],
            'products_is_active_created_at_index' => ['is_active', 'created_at'],
        ],
        'reviews' => [
            'reviews_product_slug_index' => 'product_slug',
        ],
        'favorites' => [
            'favorites_user_id_index' => 'user_id',
        ],
        'collection_items' => [
            'collection_items_product_slug_index' => 'product_slug',
        ],
        'discussion_replies' => [
            'discussion_replies_discussion_id_parent_id_index' => ['discussion_id', 'parent_id'],
        ],
        'collections' => [
            'collections_is_public_created_at_index' => ['is_public', 'created_at'],
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
