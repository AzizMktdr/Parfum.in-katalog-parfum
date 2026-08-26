<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // product <-> notes (top/middle/base)
        Schema::create('product_note', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('note_id')->constrained()->onDelete('cascade');
            $table->string('note_type')->default('middle'); // top, middle, base
        });

        // product <-> accords
        Schema::create('product_accord', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('accord_id')->constrained()->onDelete('cascade');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('product_accord');
        Schema::dropIfExists('product_note');
    }
};
