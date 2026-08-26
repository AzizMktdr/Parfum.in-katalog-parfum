<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'product_slug' => fn () => Product::factory()->create()->slug,
            'sillage'      => fake()->numberBetween(1, 5),
            'projection'   => fake()->numberBetween(1, 5),
            'longevity'    => fake()->numberBetween(1, 5),
            'review_text'  => fake()->paragraph(),
        ];
    }

    /** Review untuk produk tertentu. */
    public function forProduct(Product $product): static
    {
        return $this->state(fn () => ['product_slug' => $product->slug]);
    }
}
