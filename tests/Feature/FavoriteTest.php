<?php

namespace Tests\Feature;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_tidak_bisa_menyimpan_favorit(): void
    {
        $product = Product::factory()->create();

        $this->postJson(route('favorites.toggle'), ['slug' => $product->slug])
            ->assertStatus(401)
            ->assertJson(['require_login' => true]);

        $this->assertDatabaseCount('favorites', 0);
    }

    public function test_guest_diarahkan_ke_login_saat_membuka_daftar_favorit(): void
    {
        $this->get(route('favorites.index'))->assertRedirect(route('login'));
    }

    public function test_toggle_menambah_lalu_menghapus_favorit(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->postJson(route('favorites.toggle'), ['slug' => $product->slug])
            ->assertStatus(200)
            ->assertJson(['success' => true, 'is_favorite' => true, 'count' => 1]);

        $this->assertDatabaseHas('favorites', [
            'user_id'      => $user->id,
            'product_slug' => $product->slug,
            'product_name' => $product->name,
        ]);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle'), ['slug' => $product->slug])
            ->assertStatus(200)
            ->assertJson(['success' => true, 'is_favorite' => false, 'count' => 0]);

        $this->assertDatabaseCount('favorites', 0);
    }

    /** Sebelum diperbaiki, slug asal-asalan tetap tersimpan sebagai favorit. */
    public function test_slug_produk_yang_tidak_ada_ditolak(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('favorites.toggle'), ['slug' => 'slug-palsu'])
            ->assertStatus(422);

        $this->assertDatabaseCount('favorites', 0);
    }

    public function test_slug_wajib_dikirim(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('favorites.toggle'), [])
            ->assertStatus(422);
    }

    public function test_status_favorit_bisa_dicek(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->getJson(route('favorites.status', ['slug' => $product->slug]))
            ->assertStatus(200)
            ->assertJson(['is_favorite' => false, 'count' => 0]);

        Favorite::factory()->for($user)->forProduct($product)->create();

        $this->actingAs($user)
            ->getJson(route('favorites.status', ['slug' => $product->slug]))
            ->assertStatus(200)
            ->assertJson(['is_favorite' => true, 'count' => 1]);
    }

    public function test_guest_selalu_dapat_status_kosong(): void
    {
        $product = Product::factory()->create();

        $this->getJson(route('favorites.status', ['slug' => $product->slug]))
            ->assertStatus(200)
            ->assertJson(['is_favorite' => false, 'count' => 0]);
    }

    public function test_favorit_bisa_dihapus_dari_halaman_favorit(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        Favorite::factory()->for($user)->forProduct($product)->create();

        $this->actingAs($user)
            ->delete(route('favorites.destroy', $product->slug))
            ->assertRedirect();

        $this->assertDatabaseCount('favorites', 0);
    }

    public function test_user_hanya_melihat_favorit_miliknya(): void
    {
        $user      = User::factory()->create();
        $userLain  = User::factory()->create();
        $produkA   = Product::factory()->create(['name' => 'Parfum Milik Saya']);
        $produkB   = Product::factory()->create(['name' => 'Parfum Orang Lain']);

        Favorite::factory()->for($user)->forProduct($produkA)->create();
        Favorite::factory()->for($userLain)->forProduct($produkB)->create();

        $this->actingAs($user)
            ->get(route('favorites.index'))
            ->assertStatus(200)
            ->assertSee('Parfum Milik Saya')
            ->assertDontSee('Parfum Orang Lain');
    }
}
