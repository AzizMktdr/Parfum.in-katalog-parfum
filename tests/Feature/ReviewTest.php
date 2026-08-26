<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReviewTest extends TestCase
{
    use RefreshDatabase;

    private function payload(array $override = []): array
    {
        return array_merge([
            'sillage'    => 4,
            'projection' => 5,
            'longevity'  => 3,
            'body'       => 'Wanginya tahan lama dan cocok dipakai malam hari.',
        ], $override);
    }

    public function test_guest_tidak_bisa_mengirim_review(): void
    {
        $product = Product::factory()->create();

        $this->postJson(route('review.store', $product->slug), $this->payload())
            ->assertStatus(401)
            ->assertJson(['require_login' => true]);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_login_bisa_mengirim_review(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $response = $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload());

        $response->assertStatus(200)->assertJson(['success' => true]);

        $this->assertDatabaseHas('reviews', [
            'user_id'      => $user->id,
            'product_slug' => $product->slug,
            'sillage'      => 4,
        ]);
    }

    /** Sebelum diperbaiki, review bisa dibuat untuk slug produk yang tidak ada. */
    public function test_review_untuk_produk_yang_tidak_ada_ditolak(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson(route('review.store', 'slug-yang-tidak-ada'), $this->payload())
            ->assertStatus(404);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_review_untuk_produk_nonaktif_ditolak(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->inactive()->create();

        $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload())
            ->assertStatus(404);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_user_tidak_bisa_review_produk_yang_sama_dua_kali(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload())
            ->assertStatus(200);

        $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload())
            ->assertStatus(422);

        $this->assertDatabaseCount('reviews', 1);
    }

    /** Unique index (user_id, product_slug) menutup celah race condition. */
    public function test_database_menolak_review_duplikat(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        Review::factory()->for($user)->forProduct($product)->create();

        $this->expectException(QueryException::class);

        Review::factory()->for($user)->forProduct($product)->create();
    }

    public function test_nilai_rating_di_luar_satu_sampai_lima_ditolak(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload(['sillage' => 9]))
            ->assertStatus(422);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_isi_review_terlalu_pendek_ditolak(): void
    {
        $user    = User::factory()->create();
        $product = Product::factory()->create();

        $this->actingAs($user)
            ->postJson(route('review.store', $product->slug), $this->payload(['body' => 'bagus']))
            ->assertStatus(422);

        $this->assertDatabaseCount('reviews', 0);
    }

    public function test_daftar_review_produk_bisa_diambil(): void
    {
        $product = Product::factory()->create();
        $user    = User::factory()->create(['name' => 'Reviewer Satu']);

        Review::factory()->for($user)->forProduct($product)->create([
            'sillage'     => 5,
            'projection'  => 5,
            'longevity'   => 5,
            'review_text' => 'Parfum terbaik yang pernah saya coba.',
        ]);

        $response = $this->getJson(route('reviews.index', $product->slug));

        $response->assertStatus(200)
            ->assertJsonCount(1, 'reviews')
            ->assertJsonPath('reviews.0.author', 'Reviewer Satu')
            ->assertJsonPath('reviews.0.rating', 5);
    }
}
