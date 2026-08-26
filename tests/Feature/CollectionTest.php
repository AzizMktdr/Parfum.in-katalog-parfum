<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\CollectionItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_tidak_bisa_membuat_koleksi(): void
    {
        $this->post(route('collections.store'), ['name' => 'Koleksi Tamu'])
            ->assertRedirect(route('login'));

        $this->assertDatabaseCount('collections', 0);
    }

    public function test_user_bisa_membuat_koleksi_beserta_produknya(): void
    {
        $user     = User::factory()->create();
        $products = Product::factory()->count(2)->create();

        $response = $this->actingAs($user)->post(route('collections.store'), [
            'name'      => 'Parfum Malam',
            'is_public' => 1,
            'products'  => $products->pluck('slug')->all(),
        ]);

        $collection = Collection::first();

        $response->assertRedirect(route('collections.show', $collection));
        $this->assertSame('Parfum Malam', $collection->name);
        $this->assertSame($user->id, $collection->user_id);
        $this->assertCount(2, $collection->items);
    }

    public function test_produk_tidak_dikenal_ditolak_saat_membuat_koleksi(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('collections.create'))
            ->post(route('collections.store'), [
                'name'     => 'Koleksi Palsu',
                'products' => ['slug-yang-tidak-ada'],
            ])
            ->assertSessionHasErrors('products.0');

        $this->assertDatabaseCount('collections', 0);
    }

    public function test_koleksi_privat_hanya_bisa_dilihat_pemiliknya(): void
    {
        $owner      = User::factory()->create();
        $orangLain  = User::factory()->create();
        $collection = Collection::factory()->private()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)->get(route('collections.show', $collection))->assertStatus(200);
        $this->actingAs($orangLain)->get(route('collections.show', $collection))->assertStatus(403);
        $this->get(route('collections.show', $collection))->assertStatus(403);
    }

    public function test_koleksi_publik_bisa_dilihat_siapa_saja(): void
    {
        $collection = Collection::factory()->create();

        $this->get(route('collections.show', $collection))->assertStatus(200);
    }

    public function test_hanya_pemilik_yang_bisa_menambah_item(): void
    {
        $owner      = User::factory()->create();
        $orangLain  = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $owner->id]);
        $product    = Product::factory()->create();

        $this->actingAs($orangLain)
            ->postJson(route('collections.items.toggle', $collection), ['product_slug' => $product->slug])
            ->assertStatus(403);

        $this->assertDatabaseCount('collection_items', 0);
    }

    public function test_toggle_item_menambah_lalu_menghapus_produk(): void
    {
        $owner      = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $owner->id]);
        $product    = Product::factory()->create();

        $this->actingAs($owner)
            ->postJson(route('collections.items.toggle', $collection), ['product_slug' => $product->slug])
            ->assertStatus(200)
            ->assertJson(['added' => true, 'count' => 1]);

        $this->assertDatabaseHas('collection_items', [
            'collection_id' => $collection->id,
            'product_slug'  => $product->slug,
        ]);

        $this->actingAs($owner)
            ->postJson(route('collections.items.toggle', $collection), ['product_slug' => $product->slug])
            ->assertStatus(200)
            ->assertJson(['added' => false, 'count' => 0]);

        $this->assertDatabaseCount('collection_items', 0);
    }

    public function test_slug_produk_wajib_valid_saat_toggle_item(): void
    {
        $owner      = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)
            ->postJson(route('collections.items.toggle', $collection), ['product_slug' => 'tidak-ada'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('product_slug');

        $this->assertDatabaseCount('collection_items', 0);
    }

    public function test_like_koleksi_orang_lain_tercatat_sekali(): void
    {
        $collection = Collection::factory()->create();
        $user       = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('collections.like', $collection))
            ->assertJson(['liked' => true, 'count' => 1]);

        $this->actingAs($user)
            ->postJson(route('collections.like', $collection))
            ->assertJson(['liked' => false, 'count' => 0]);

        $this->assertDatabaseCount('collection_likes', 0);
    }

    public function test_koleksi_privat_tidak_bisa_dilike_orang_lain(): void
    {
        $collection = Collection::factory()->private()->create();
        $user       = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('collections.like', $collection))
            ->assertStatus(403);
    }

    public function test_hanya_pemilik_yang_bisa_menghapus_koleksi(): void
    {
        $owner      = User::factory()->create();
        $orangLain  = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($orangLain)
            ->delete(route('collections.destroy', $collection))
            ->assertStatus(403);

        $this->actingAs($owner)
            ->delete(route('collections.destroy', $collection))
            ->assertRedirect(route('collections.index'));

        $this->assertDatabaseCount('collections', 0);
    }

    public function test_menghapus_koleksi_ikut_menghapus_itemnya(): void
    {
        $owner      = User::factory()->create();
        $collection = Collection::factory()->create(['user_id' => $owner->id]);
        $product    = Product::factory()->create();

        CollectionItem::create([
            'collection_id' => $collection->id,
            'product_slug'  => $product->slug,
        ]);

        $this->actingAs($owner)->delete(route('collections.destroy', $collection));

        $this->assertDatabaseCount('collection_items', 0);
    }

    public function test_halaman_koleksi_saya_hanya_menampilkan_milik_sendiri(): void
    {
        $user  = User::factory()->create();
        $milik = Collection::factory()->create(['user_id' => $user->id, 'name' => 'Punya Saya']);
        Collection::factory()->create(['name' => 'Punya Orang Lain']);

        $this->actingAs($user)
            ->get(route('collections.index'))
            ->assertStatus(200)
            ->assertSee($milik->name)
            ->assertDontSee('Punya Orang Lain');
    }
}
