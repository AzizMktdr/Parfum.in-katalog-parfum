<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_utama_bisa_dibuka(): void
    {
        Product::factory()->count(2)->create();

        $this->get(route('home'))->assertStatus(200);
    }

    public function test_detail_produk_aktif_bisa_dibuka(): void
    {
        $product = Product::factory()->create();

        $this->get(route('product.detail', $product->slug))
            ->assertStatus(200)
            ->assertSee($product->name);
    }

    /** Inti perbaikan: produk nonaktif tidak boleh bisa diakses publik. */
    public function test_detail_produk_nonaktif_menghasilkan_404_untuk_publik(): void
    {
        $product = Product::factory()->inactive()->create();

        $this->get(route('product.detail', $product->slug))->assertStatus(404);
    }

    public function test_user_biasa_juga_tidak_bisa_melihat_produk_nonaktif(): void
    {
        $product = Product::factory()->inactive()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('product.detail', $product->slug))
            ->assertStatus(404);
    }

    public function test_admin_bisa_melihat_pratinjau_produk_nonaktif(): void
    {
        $product = Product::factory()->inactive()->create();

        $this->actingAs(User::factory()->admin()->create())
            ->get(route('product.detail', $product->slug))
            ->assertStatus(200);
    }

    public function test_slug_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get(route('product.detail', 'slug-tidak-dikenal'))->assertStatus(404);
    }

    public function test_pencarian_produk_mengembalikan_json(): void
    {
        Product::factory()->create(['name' => 'Kuta Sunset']);

        $this->getJson(route('api.search-products'))
            ->assertStatus(200);
    }
}
