<?php

namespace Database\Factories;

use App\Models\Favorite;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Favorite>
 */
class FavoriteFactory extends Factory
{
    protected $model = Favorite::class;

    public function definition(): array
    {
        $product = null;

        return [
            'product_slug'  => function () use (&$product) {
                $product ??= Product::factory()->create();

                return $product->slug;
            },
            'user_id'       => User::factory(),
            'product_name'  => function () use (&$product) {
                $product ??= Product::factory()->create();

                return $product->name;
            },
            'product_brand' => 'Parfum.in',
            'product_image' => 'images/products/placeholder.png',
        ];
    }

    /** Favorit untuk produk tertentu. */
    public function forProduct(Product $product): static
    {
        return $this->state(fn () => [
            'product_slug' => $product->slug,
            'product_name' => $product->name,
        ]);
    }
}
