<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_tidak_bisa_membuka_halaman_profil(): void
    {
        $this->get(route('profile.edit'))->assertRedirect(route('login'));
    }

    public function test_user_bisa_membuka_halaman_profil(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('profile.edit'))
            ->assertStatus(200)
            ->assertSee($user->email);
    }

    public function test_nama_dan_email_bisa_diperbarui(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->patch(route('profile.update'), [
            'name'  => 'Nama Baru',
            'email' => 'email-baru@example.com',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertSame('Nama Baru', $user->name);
        $this->assertSame('email-baru@example.com', $user->email);
    }

    public function test_ganti_email_mereset_status_verifikasi(): void
    {
        $user = User::factory()->create();
        $this->assertNotNull($user->email_verified_at);

        $this->actingAs($user)->patch(route('profile.update'), [
            'name'  => $user->name,
            'email' => 'email-lain@example.com',
        ]);

        $this->assertNull($user->fresh()->email_verified_at);
    }

    public function test_email_tetap_sama_tidak_dianggap_duplikat(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->patch(route('profile.update'), [
            'name'  => 'Nama Diubah',
            'email' => $user->email,
        ])->assertSessionHasNoErrors();

        $this->assertSame('Nama Diubah', $user->fresh()->name);
    }

    public function test_email_milik_user_lain_ditolak(): void
    {
        $user  = User::factory()->create();
        $lain  = User::factory()->create(['email' => 'dipakai@example.com']);

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name'  => $user->name,
                'email' => 'dipakai@example.com',
            ]);

        $response->assertSessionHasErrors('email');
        $this->assertNotSame($lain->email, $user->fresh()->email);
    }

    public function test_avatar_bisa_diupload_lalu_dihapus(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)->patch(route('profile.update'), [
            'name'   => $user->name,
            'email'  => $user->email,
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ])->assertRedirect(route('profile.edit'));

        $path = $user->fresh()->avatar;
        $this->assertNotNull($path);
        Storage::disk('public')->assertExists($path);

        $this->actingAs($user)->patch(route('profile.update'), [
            'name'          => $user->name,
            'email'         => $user->email,
            'remove_avatar' => '1',
        ])->assertRedirect(route('profile.edit'));

        $this->assertNull($user->fresh()->avatar);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_file_non_gambar_ditolak_sebagai_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name'   => $user->name,
                'email'  => $user->email,
                'avatar' => UploadedFile::fake()->create('virus.pdf', 100, 'application/pdf'),
            ])
            ->assertSessionHasErrors('avatar');

        $this->assertNull($user->fresh()->avatar);
    }

    public function test_password_bisa_diganti(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('profile.password.update'), [
            'current_password'      => 'password',
            'password'              => 'password-baru-123',
            'password_confirmation' => 'password-baru-123',
        ]);

        $response->assertRedirect(route('profile.edit'));
        $this->assertTrue(Hash::check('password-baru-123', $user->fresh()->password));
    }

    public function test_ganti_password_gagal_kalau_password_lama_salah(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.password.update'), [
                'current_password'      => 'password-yang-salah',
                'password'              => 'password-baru-123',
                'password_confirmation' => 'password-baru-123',
            ]);

        $response->assertSessionHasErrors('current_password');
        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }

    public function test_ganti_password_gagal_kalau_konfirmasi_tidak_cocok(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->put(route('profile.password.update'), [
                'current_password'      => 'password',
                'password'              => 'password-baru-123',
                'password_confirmation' => 'password-beda-456',
            ])
            ->assertSessionHasErrors('password');

        $this->assertTrue(Hash::check('password', $user->fresh()->password));
    }
}
