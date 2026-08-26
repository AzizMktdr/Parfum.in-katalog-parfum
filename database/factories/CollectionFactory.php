<?php

namespace Database\Factories;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Collection>
 */
class CollectionFactory extends Factory
{
    protected $model = Collection::class;

    public function definition(): array
    {
        return [
            'user_id'     => User::factory(),
            'name'        => Str::title(fake()->words(2, true)),
            'description' => fake()->sentence(),
            'is_public'   => true,
        ];
    }

    /** Koleksi privat: hanya bisa dilihat pemiliknya. */
    public function private(): static
    {
        return $this->state(fn () => ['is_public' => false]);
    }
}
