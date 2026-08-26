<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HeroSlide;
use App\Models\Product;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('🎠 Seeding hero slides...');

        // Cari produk untuk dijadikan slide default
        $products = Product::with('brand')->whereIn('slug', [
            'california-signature',
            'dreamscape',
            'solaris',
        ])->get()->keyBy('slug');

        $slides = [
            [
                'order'       => 1,
                'title'       => "CALIFORNIA\nSIGNATURE",
                'subtitle'    => 'MYKONOS',
                'description' => 'Aroma citrus-aquatic yang segar, ceria, dan mewah. Terinspirasi suasana pantai California.',
                'button_text' => 'Lihat Detail',
                'button_link' => null,
                'product_id'  => $products['california-signature']->id ?? null,
                'image'       => 'images/products/california-signature.png',
                'bg_color'    => null,
                'is_active'   => true,
            ],
            [
                'order'       => 2,
                'title'       => "DREAMSCAPE",
                'subtitle'    => 'MYKONOS',
                'description' => 'Sebuah wewangian yang terasa seperti mimpi yang tidak ingin kamu tinggalkan.',
                'button_text' => 'Lihat Detail',
                'button_link' => null,
                'product_id'  => $products['dreamscape']->id ?? null,
                'image'       => 'images/products/dreamscape.png',
                'bg_color'    => null,
                'is_active'   => true,
            ],
            [
                'order'       => 3,
                'title'       => "SOLARIS",
                'subtitle'    => 'SAFF & CO',
                'description' => 'Sebuah uap penggoda yang menangkap mimpi-mimpimu. SOLARIS menyalakan api yang ada di dalam dirimu.',
                'button_text' => 'Lihat Detail',
                'button_link' => null,
                'product_id'  => $products['solaris']->id ?? null,
                'image'       => 'images/products/invade.png',
                'bg_color'    => null,
                'is_active'   => true,
            ],
        ];

        foreach ($slides as $data) {
            HeroSlide::updateOrCreate(
                ['order' => $data['order'], 'title' => $data['title']],
                $data
            );
        }

        $this->command->info('✅ Hero slides seeded: ' . count($slides));
    }
}
