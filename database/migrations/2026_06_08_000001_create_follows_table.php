<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('follows', function (Blueprint $table) {
            $table->id();
            // user yang melakukan follow
            $table->foreignId('follower_id')->constrained('users')->cascadeOnDelete();
            // user yang di-follow
            $table->foreignId('following_id')->constrained('users')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['follower_id', 'following_id']); // 1 user hanya follow 1x ke target yang sama
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('follows');
    }
};
