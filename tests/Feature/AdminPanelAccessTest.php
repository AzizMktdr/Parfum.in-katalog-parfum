<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminPanelAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_diarahkan_ke_login_panel(): void
    {
        $this->get('/admin')->assertRedirect();
    }

    /** Inti perbaikan: user biasa tidak boleh masuk panel admin Filament. */
    public function test_user_biasa_dilarang_masuk_panel_admin(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_tidak_ditolak_panel_admin(): void
    {
        $admin = User::factory()->admin()->create();

        $response = $this->actingAs($admin)->get('/admin');

        $this->assertNotSame(403, $response->getStatusCode());
    }
}
