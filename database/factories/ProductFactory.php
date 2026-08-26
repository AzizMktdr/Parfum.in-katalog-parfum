<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'name'        => Str::title($name),
            'slug'        => Str::slug($name) . '-' . Str::lower(Str::random(6)),
            'brand_id'    => Brand::factory(),
            'category'    => fake()->randomElement(['EDP', 'EDT', 'EDC', 'Parfum']),
            'collection'  => fake()->randomElement(['night', 'day', 'sport']),
            'gender'      => fake()->randomElement(['for men', 'for women', 'for women and men']),
            'price'       => fake()->numberBetween(150, 900) * 1000,
            'volume_ml'   => fake()->randomElement([30, 50, 100]),
            'description' => fake()->paragraph(),
            'image'       => 'images/products/placeholder.png',
            'is_active'   => true,
        ];
    }

    /** Produk yang dinonaktifkan admin (tidak boleh tampil ke publik). */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
