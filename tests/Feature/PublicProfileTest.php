<?php

namespace Tests\Feature;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_profil_publik_bisa_dibuka_lewat_username(): void
    {
        $user = User::factory()->create([
            'name'     => 'Budi Santoso',
            'username' => 'budi_santoso',
        ]);

        $this->get(route('profile.show', $user->username))
            ->assertStatus(200)
            ->assertSee('Budi Santoso');
    }

    public function test_profil_publik_bisa_dibuka_lewat_id_kalau_belum_punya_username(): void
    {
        $user = User::factory()->withoutUsername()->create(['name' => 'Tanpa Username']);

        $this->assertSame((string) $user->id, $user->route_handle);

        $this->get(route('profile.show', $user->id))
            ->assertStatus(200)
            ->assertSee('Tanpa Username');
    }

    public function test_handle_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get(route('profile.show', 'tidak-ada-orang-ini'))->assertStatus(404);
    }

    public function test_koleksi_privat_tidak_tampil_di_profil_publik(): void
    {
        $user = User::factory()->create(['username' => 'pemilik']);

        Collection::factory()->create([
            'user_id' => $user->id,
            'name'    => 'Koleksi Terbuka',
        ]);
        Collection::factory()->private()->create([
            'user_id' => $user->id,
            'name'    => 'Koleksi Rahasia',
        ]);

        $this->get(route('profile.show', 'pemilik'))
            ->assertStatus(200)
            ->assertSee('Koleksi Terbuka')
            ->assertDontSee('Koleksi Rahasia');
    }

    public function test_username_wajib_unik_saat_disimpan_di_profil(): void
    {
        User::factory()->create(['username' => 'sudah_dipakai']);
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => 'sudah_dipakai',
            ])
            ->assertSessionHasErrors('username');
    }

    public function test_user_bisa_menyimpan_username_dan_bio(): void
    {
        $user = User::factory()->withoutUsername()->create();

        $this->actingAs($user)
            ->patch(route('profile.update'), [
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => 'nama_baru',
                'bio'      => 'Penggemar parfum woody.',
            ])
            ->assertRedirect(route('profile.edit'));

        $user->refresh();

        $this->assertSame('nama_baru', $user->username);
        $this->assertSame('Penggemar parfum woody.', $user->bio);
    }

    public function test_username_dengan_karakter_terlarang_ditolak(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->from(route('profile.edit'))
            ->patch(route('profile.update'), [
                'name'     => $user->name,
                'email'    => $user->email,
                'username' => 'nama dengan spasi!',
            ])
            ->assertSessionHasErrors('username');
    }
}
