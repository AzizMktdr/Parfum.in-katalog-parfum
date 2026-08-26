<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_lupa_password_bisa_dibuka(): void
    {
        $this->get(route('password.request'))->assertStatus(200);
    }

    public function test_link_reset_dikirim_ke_email_terdaftar(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email])
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /** Email tak terdaftar tetap dijawab sama, supaya tidak jadi alat enumerasi akun. */
    public function test_email_tidak_terdaftar_tidak_membocorkan_informasi(): void
    {
        Notification::fake();

        $this->post(route('password.email'), ['email' => 'tidak-ada@example.com'])
            ->assertSessionHas('status')
            ->assertSessionHasNoErrors();

        Notification::assertNothingSent();
    }

    public function test_halaman_form_reset_bisa_dibuka(): void
    {
        $this->get(route('password.reset', ['token' => 'token-contoh']))
            ->assertStatus(200);
    }

    public function test_password_bisa_direset_dengan_token_valid(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), ['email' => $user->email]);

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use (&$token) {
            $token = $notification->token;

            return true;
        });

        $response = $this->post(route('password.update'), [
            'token'                 => $token,
            'email'                 => $user->email,
            'password'              => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('login'));
        $this->assertTrue(Hash::check('password-baru-123', $user->fresh()->password));
    }

    public function test_token_tidak_valid_ditolak(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('password.reset', ['token' => 'token-palsu']))
            ->post(route('password.update'), [
                'token'                 => 'token-palsu',
                'email'                 => $user->email,
                'password'              => 'password-baru-123',
                'password_confirmation' => 'password-baru-123',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_password_baru_harus_minimal_delapan_karakter(): void
    {
        $user = User::factory()->create();

        $response = $this->from(route('password.reset', ['token' => 'apa-saja']))
            ->post(route('password.update'), [
                'token'                 => 'apa-saja',
                'email'                 => $user->email,
                'password'              => 'abc123',
                'password_confirmation' => 'abc123',
            ]);

        $response->assertSessionHasErrors('password');
    }
}
