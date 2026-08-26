<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('title');                      // Judul besar di hero
            $table->string('subtitle')->nullable();       // Teks watermark di belakang
            $table->text('description')->nullable();      // Deskripsi kecil kiri bawah
            $table->string('button_text')->default('Lihat Detail'); // Teks tombol
            $table->string('button_link')->nullable();    // URL tombol
            $table->string('image')->nullable();          // Gambar produk / background
            $table->string('bg_color')->nullable();       // Warna background slide
            $table->foreignId('product_id')              // Opsional: link ke produk
                  ->nullable()
                  ->constrained()
                  ->onDelete('set null');
            $table->integer('order')->default(0);         // Urutan tampil
            $table->boolean('is_active')->default(true);  // Aktif / nonaktif
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
    }
};
