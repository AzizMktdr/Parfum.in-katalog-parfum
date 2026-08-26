<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_halaman_register_bisa_dibuka(): void
    {
        $this->get(route('register'))->assertStatus(200);
    }

    public function test_user_baru_bisa_mendaftar_dan_langsung_login(): void
    {
        $response = $this->post(route('register.post'), [
            'name'                  => 'Bahlil',
            'email'                 => 'bahlil@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree'                 => 'on',
        ]);

        $response->assertRedirect(route('home'));
        $this->assertAuthenticated();

        $user = User::where('email', 'bahlil@example.com')->first();
        $this->assertNotNull($user);
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    /** Registrasi publik tidak boleh bisa menyuntikkan role admin. */
    public function test_user_baru_selalu_berperan_user_biasa(): void
    {
        $this->post(route('register.post'), [
            'name'                  => 'Calon Admin',
            'email'                 => 'calon-admin@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree'                 => 'on',
            'role'                  => 'admin',
        ]);

        $user = User::where('email', 'calon-admin@example.com')->firstOrFail();

        $this->assertSame(User::ROLE_USER, $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_registrasi_gagal_tanpa_menyetujui_syarat(): void
    {
        $response = $this->from(route('register'))->post(route('register.post'), [
            'name'                  => 'Tanpa Setuju',
            'email'                 => 'tanpa-setuju@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('register'));
        $response->assertSessionHasErrors('agree');
        $this->assertGuest();
        $this->assertDatabaseMissing('users', ['email' => 'tanpa-setuju@example.com']);
    }

    public function test_email_yang_sudah_terdaftar_ditolak(): void
    {
        User::factory()->create(['email' => 'dobel@example.com']);

        $response = $this->from(route('register'))->post(route('register.post'), [
            'name'                  => 'Dobel',
            'email'                 => 'dobel@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
            'agree'                 => 'on',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->assertSame(1, User::where('email', 'dobel@example.com')->count());
    }

    public function test_password_kurang_dari_delapan_karakter_ditolak(): void
    {
        $response = $this->from(route('register'))->post(route('register.post'), [
            'name'                  => 'Pendek',
            'email'                 => 'pendek@example.com',
            'password'              => 'abc123',
            'password_confirmation' => 'abc123',
            'agree'                 => 'on',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function test_konfirmasi_password_harus_cocok(): void
    {
        $response = $this->from(route('register'))->post(route('register.post'), [
            'name'                  => 'Beda',
            'email'                 => 'beda@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password456',
            'agree'                 => 'on',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }
}
