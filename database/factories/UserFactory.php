<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected $model = User::class;

    /** Password yang dipakai bersama semua user hasil factory: "password". */
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'username'          => $this->uniqueUsername(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'avatar'            => null,
            'bio'               => null,
            'role'              => User::ROLE_USER,
            'remember_token'    => Str::random(10),
        ];
    }

    /** User dengan hak akses panel admin. */
    public function admin(): static
    {
        return $this->state(fn () => ['role' => User::ROLE_ADMIN]);
    }

    /** Email belum diverifikasi. */
    public function unverified(): static
    {
        return $this->state(fn () => ['email_verified_at' => null]);
    }

    /** User tanpa username (akun lama sebelum fitur profil publik). */
    public function withoutUsername(): static
    {
        return $this->state(fn () => ['username' => null]);
    }

    private function uniqueUsername(): string
    {
        $base = Str::slug(fake()->userName(), '_');
        $base = $base !== '' ? Str::limit($base, 18, '') : 'user';

        return $base . '_' . Str::lower(Str::random(6));
    }
}
