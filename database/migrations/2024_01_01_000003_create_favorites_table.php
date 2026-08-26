<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('favorites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('product_slug');
            $table->string('product_name');
            $table->string('product_brand');
            $table->string('product_image');
            $table->timestamps();
            $table->unique(['user_id', 'product_slug']);
        });
    }
    public function down(): void { Schema::dropIfExists('favorites'); }
};
