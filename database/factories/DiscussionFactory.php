<?php

namespace Database\Factories;

use App\Models\Discussion;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Discussion>
 */
class DiscussionFactory extends Factory
{
    protected $model = Discussion::class;

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(),
            'title'         => Str::title(fake()->sentence(4)),
            'body'          => fake()->paragraph(),
            'likes_count'   => 0,
            'replies_count' => 0,
        ];
    }
}
