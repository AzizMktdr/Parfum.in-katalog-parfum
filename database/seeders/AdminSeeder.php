<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Membuat akun admin pertama.
 *
 * Kredensial diambil dari .env:
 *   ADMIN_NAME, ADMIN_EMAIL, ADMIN_PASSWORD
 *
 * Kalau ADMIN_PASSWORD kosong, seeder membuat password acak dan
 * menampilkannya SEKALI di terminal. Tidak ada password default
 * yang tersimpan di dalam repository.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $name  = (string) env('ADMIN_NAME', 'Admin Parfumin');
        $email = (string) env('ADMIN_EMAIL', 'admin@parfumin.test');

        $existing = User::where('email', $email)->first();

        if ($existing) {
            $existing->forceFill([
                'name' => $name,
                'role' => User::ROLE_ADMIN,
            ])->save();

            $this->command?->warn("Admin sudah ada: {$email} — role dipastikan admin, password tidak diubah.");

            return;
        }

        $plainPassword = (string) env('ADMIN_PASSWORD', '');
        $generated     = false;

        if (trim($plainPassword) === '') {
            $plainPassword = Str::password(16);
            $generated     = true;
        }

        User::create([
            'name'     => $name,
            'username' => $this->uniqueUsername($name),
            'email'    => $email,
            'password' => $plainPassword, // dienkripsi otomatis oleh cast 'hashed'
            'role'     => User::ROLE_ADMIN,
        ]);

        $this->command?->info("Admin dibuat: {$email}");

        if ($generated) {
            $this->command?->warn('Password acak (hanya ditampilkan sekali): ' . $plainPassword);
            $this->command?->warn('Simpan sekarang, lalu ganti lewat halaman profil.');
        } else {
            $this->command?->info('Password diambil dari ADMIN_PASSWORD di .env');
        }
    }

    private function uniqueUsername(string $name): string
    {
        $base = Str::slug($name, '_');
        $base = $base !== '' ? Str::limit($base, 24, '') : 'admin';

        $candidate = $base;
        $suffix    = 1;

        while (User::where('username', $candidate)->exists()) {
            $candidate = $base . '_' . $suffix;
            $suffix++;
        }

        return $candidate;
    }
}
