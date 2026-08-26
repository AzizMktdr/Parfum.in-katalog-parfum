<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Index untuk kolom yang sering dipakai untuk PENCARIAN dan RELASI (foreign key).
 *
 * Aman dijalankan berkali-kali:
 * - tabel yang tidak ada  -> dilewati
 * - kolom yang tidak ada  -> dilewati
 * - index yang sudah ada  -> dilewati (tidak error duplicate key name)
 */
return new class extends Migration
{
    /**
     * daftar: tabel => [ [nama_index, [kolom...]], ... ]
     */
    private array $indexes = [
        'products' => [
            ['products_brand_id_is_active_index',  ['brand_id', 'is_active']],
            ['products_slug_unique_index',         ['slug']],
            ['products_name_index',                ['name']],
            ['products_collection_is_active_index', ['collection', 'is_active']],
            ['products_gender_is_active_index',    ['gender', 'is_active']],
        ],
        'brands' => [
            ['brands_slug_index', ['slug']],
            ['brands_name_index', ['name']],
        ],
        'notes' => [
            ['notes_slug_index',          ['slug']],
            ['notes_name_index',          ['name']],
            ['notes_accord_group_index',  ['accord_group']],
        ],
        'accords' => [
            ['accords_slug_index', ['slug']],
            ['accords_name_index', ['name']],
        ],
        'product_note' => [
            ['product_note_note_id_type_index', ['note_id', 'note_type']],
            ['product_note_product_id_index',   ['product_id']],
        ],
        'product_accord' => [
            ['product_accord_accord_id_index',  ['accord_id']],
            ['product_accord_product_id_index', ['product_id']],
        ],
        'reviews' => [
            ['reviews_product_slug_created_index', ['product_slug', 'created_at']],
            ['reviews_user_id_index',              ['user_id']],
        ],
        'favorites' => [
            ['favorites_user_slug_index', ['user_id', 'product_slug']],
        ],
        'collections' => [
            ['collections_user_public_created_index', ['user_id', 'is_public', 'created_at']],
        ],
        'collection_items' => [
            ['collection_items_collection_slug_index', ['collection_id', 'product_slug']],
            ['collection_items_product_slug_index',    ['product_slug']],
        ],
        'collection_likes' => [
            ['collection_likes_collection_user_index', ['collection_id', 'user_id']],
        ],
        'follows' => [
            ['follows_follower_index',  ['follower_id']],
            ['follows_following_index', ['following_id']],
        ],
        'users' => [
            ['users_username_idx', ['username']],
            ['users_role_index',   ['role']],
        ],
        'hero_slides' => [
            ['hero_slides_active_index', ['is_active']],
        ],
    ];

    public function up(): void
    {
        foreach ($this->indexes as $table => $definitions) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach ($definitions as [$name, $columns]) {
                if (!$this->hasAllColumns($table, $columns)) {
                    continue;
                }
                if ($this->indexExists($table, $name)) {
                    continue;
                }

                try {
                    Schema::table($table, function (Blueprint $blueprint) use ($columns, $name) {
                        $blueprint->index($columns, $name);
                    });
                } catch (\Throwable $e) {
                    // index serupa sudah ada / driver tidak mendukung -> lanjut saja
                }
            }
        }
    }

    public function down(): void
    {
        foreach ($this->indexes as $table => $definitions) {
            if (!Schema::hasTable($table)) {
                continue;
            }

            foreach ($definitions as [$name, $columns]) {
                if (!$this->indexExists($table, $name)) {
                    continue;
                }

                try {
                    Schema::table($table, function (Blueprint $blueprint) use ($name) {
                        $blueprint->dropIndex($name);
                    });
                } catch (\Throwable $e) {
                    // biarkan
                }
            }
        }
    }

    private function hasAllColumns(string $table, array $columns): bool
    {
        foreach ($columns as $column) {
            if (!Schema::hasColumn($table, $column)) {
                return false;
            }
        }

        return true;
    }

    private function indexExists(string $table, string $index): bool
    {
        try {
            $driver = DB::connection()->getDriverName();

            if ($driver === 'sqlite') {
                $rows = DB::select("PRAGMA index_list('{$table}')");
                foreach ($rows as $row) {
                    if (($row->name ?? null) === $index) {
                        return true;
                    }
                }

                return false;
            }

            if ($driver === 'pgsql') {
                return !empty(DB::select(
                    'select 1 from pg_indexes where tablename = ? and indexname = ?',
                    [$table, $index]
                ));
            }

            // mysql / mariadb
            return !empty(DB::select("SHOW INDEX FROM `{$table}` WHERE Key_name = ?", [$index]));
        } catch (\Throwable $e) {
            return false;
        }
    }
};
