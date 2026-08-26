<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Accord;
use Illuminate\Support\Str;

class PerfumeDataSeeder extends Seeder
{
    public function run(): void
    {
        // Hanya seed Accords (warna & deskripsi)
        // Produk ada di ParfumDatabaseSeeder
        $accordsData = [
            ['name' => 'Citrus',    'color' => '#F5A623', 'description' => 'Segar, ceria, dan mencerahkan.'],
            ['name' => 'Spices',    'color' => '#D0021B', 'description' => 'Hangat, berani, dan eksotis.'],
            ['name' => 'Wood',      'color' => '#8B572A', 'description' => 'Earthy, maskulin, dan tahan lama.'],
            ['name' => 'Amber',     'color' => '#F8A100', 'description' => 'Hangat, manis, dan mewah.'],
            ['name' => 'Floral',    'color' => '#FF6B9D', 'description' => 'Feminin, segar bunga, dan romantis.'],
            ['name' => 'Fruity',    'color' => '#7ED321', 'description' => 'Manis, playful, dan segar.'],
            ['name' => 'Musk',      'color' => '#9B9B9B', 'description' => 'Lembut, sensual, dan bersih.'],
            ['name' => 'Green',     'color' => '#417505', 'description' => 'Segar dedaunan, alami, dan menenangkan.'],
            ['name' => 'Watery',    'color' => '#4A90E2', 'description' => 'Segar air, bersih, dan ringan.'],
            ['name' => 'Aromatic',  'color' => '#7B68EE', 'description' => 'Herbal, segar, dan maskulin.'],
            ['name' => 'Synthetic', 'color' => '#B8B8B8', 'description' => 'Modern, futuristik, dan unik.'],
            ['name' => 'Gourmand',  'color' => '#C0392B', 'description' => 'Manis seperti makanan, vanila dan karamel.'],
            ['name' => 'Vanilla',   'color' => '#F3D19C', 'description' => 'Manis, creamy, lembut, dan comforting.'],
            ['name' => 'Leather',   'color' => '#4A2C2A', 'description' => 'Kulit, smoky, bold, dan elegan.'],
            ['name' => 'Oud',       'color' => '#3B2415', 'description' => 'Resinous, woody, intens, dan mewah.'],
            ['name' => 'Powdery',   'color' => '#E8D9F0', 'description' => 'Lembut, bersih, dan kosmetik.'],
            ['name' => 'Fresh',     'color' => '#6DD3CE', 'description' => 'Segar, clean, ringan, dan mudah dipakai.'],
            ['name' => 'Coffee',    'color' => '#5B3A29', 'description' => 'Pahit-manis, roasted, dan gourmand.'],
            ['name' => 'Tropical',  'color' => '#FFB347', 'description' => 'Buah tropis, cerah, dan liburan.'],
        ];

        foreach ($accordsData as $a) {
            Accord::updateOrCreate(
                ['slug' => Str::slug($a['name'])],
                array_merge($a, ['slug' => Str::slug($a['name'])])
            );
        }
        $this->command->info('✅ Accords seeded: ' . count($accordsData));
    }
}
