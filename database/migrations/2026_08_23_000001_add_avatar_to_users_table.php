<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Menyelaraskan skema users dengan model:
 * - kolom `avatar` sudah ada di User::$fillable tapi belum pernah dibuat di DB.
 * - `role` dipakai untuk filter di panel admin & laporan, jadi perlu index.
 */
return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'avatar')) {
                $table->string('avatar')->nullable()->after('email');
            }
        });

        if (Schema::hasColumn('users', 'role') && ! Schema::hasIndex('users', 'users_role_index')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('role', 'users_role_index');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasIndex('users', 'users_role_index')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropIndex('users_role_index');
            });
        }

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'avatar')) {
                $table->dropColumn('avatar');
            }
        });
    }
};
