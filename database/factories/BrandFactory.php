<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Brand>
 */
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition(): array
    {
        $name = fake()->words(2, true);

        return [
            'name'        => Str::title($name),
            'slug'        => Str::slug($name) . '-' . Str::lower(Str::random(6)),
            'logo'        => null,
            'description' => fake()->sentence(),
            'country'     => 'Indonesia',
        ];
    }
}
