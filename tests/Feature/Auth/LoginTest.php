<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_login_bisa_dibuka(): void
    {
        $this->get(route('login'))->assertStatus(200);
    }

    public function test_login_berhasil_dengan_kredensial_benar(): void
    {
        $user = User::factory()->create(['email' => 'benar@example.com']);

        $response = $this->post(route('login.post'), [
            'email'    => 'benar@example.com',
            'password' => 'password',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        User::factory()->create(['email' => 'salah@example.com']);

        $response = $this->from(route('login'))->post(route('login.post'), [
            'email'    => 'salah@example.com',
            'password' => 'password-yang-salah',
        ]);

        $response->assertRedirect(route('login'));
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_yang_sudah_login_tidak_bisa_membuka_halaman_login(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('login'))->assertRedirect(route('home'));
    }

    public function test_user_bisa_logout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirect(route('home'));
        $this->assertGuest();
    }

    /** Route login dibatasi throttle:5,1 untuk menahan brute force. */
    public function test_login_dibatasi_setelah_lima_percobaan_gagal(): void
    {
        User::factory()->create(['email' => 'brute@example.com']);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login.post'), [
                'email'    => 'brute@example.com',
                'password' => 'salah',
            ])->assertStatus(302);
        }

        $this->post(route('login.post'), [
            'email'    => 'brute@example.com',
            'password' => 'salah',
        ])->assertStatus(429);
    }
}
