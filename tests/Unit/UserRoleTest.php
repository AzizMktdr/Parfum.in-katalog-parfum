<?php

namespace Tests\Unit;

use App\Models\User;
use Filament\Panel;
use Tests\TestCase;

class UserRoleTest extends TestCase
{
    public function test_default_role_adalah_user(): void
    {
        $user = new User(['name' => 'Budi']);

        $this->assertSame(User::ROLE_USER, $user->role);
        $this->assertFalse($user->isAdmin());
    }

    public function test_is_admin_hanya_true_untuk_role_admin(): void
    {
        $admin = new User(['name' => 'Admin', 'role' => User::ROLE_ADMIN]);
        $biasa = new User(['name' => 'Biasa', 'role' => User::ROLE_USER]);

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($biasa->isAdmin());
    }

    public function test_akses_panel_hanya_untuk_admin(): void
    {
        $panel = new Panel();

        $admin = new User(['name' => 'Admin', 'role' => User::ROLE_ADMIN]);
        $biasa = new User(['name' => 'Biasa', 'role' => User::ROLE_USER]);

        $this->assertTrue($admin->canAccessPanel($panel));
        $this->assertFalse($biasa->canAccessPanel($panel));
    }

    public function test_avatar_url_null_kalau_belum_upload(): void
    {
        $user = new User(['name' => 'Budi']);

        $this->assertNull($user->avatar_url);
    }

    public function test_avatar_url_memakai_path_storage(): void
    {
        $user = new User(['name' => 'Budi', 'avatar' => 'avatars/foto.jpg']);

        $this->assertStringContainsString('storage/avatars/foto.jpg', $user->avatar_url);
    }

    public function test_inisial_diambil_dari_huruf_pertama_nama(): void
    {
        $this->assertSame('B', (new User(['name' => 'budi santoso']))->initial);
    }
}
