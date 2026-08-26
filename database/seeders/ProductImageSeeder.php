<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductImageSeeder extends Seeder
{
    public function run(): void
    {
        // Format: 'slug' => 'nama-file.png'
        // Semua file harus ada di: public/images/products/
        // Konvensi nama file = slug produk + .png

        $images = [
            // ── MYKONOS ──────────────────────────────────────────────
            'california-signature'    => 'images/products/california-signature.png',
            'penthouse-myk'           => 'images/products/penthouse-myk.png',
            'dreamscape'              => 'images/products/dreamscape.png',
            'royal-ispahan'           => 'images/products/royal-ispahan.png',
            'enchanted'               => 'images/products/enchanted.png',
            'hawaiian-crush'          => 'images/products/hawaiian-crush.png',
            'inception-mykonos'       => 'images/products/inception-mykonos.png',
            'slow-living'             => 'images/products/slow-living.png',
            'glitch-mykonos'          => 'images/products/glitch-mykonos.png',
            'milk-drops'              => 'images/products/milk-drops.png',

            // ── VELIXIR PARFUM ───────────────────────────────────────
            'adonis'                  => 'images/products/adonis.png',
            'apollo'                  => 'images/products/apollo.png',
            'ares'                    => 'images/products/ares.png',
            'aphrodite'               => 'images/products/aphrodite.png',
            'athena'                  => 'images/products/athena.png',
            'icarus'                  => 'images/products/icarus.png',
            'hera'                    => 'images/products/hera.png',
            'morpheus'                => 'images/products/morpheus.png',
            'persephone'              => 'images/products/persephone.png',
            'poseidon'                => 'images/products/poseidon.png',

            // ── HMNS PARFUM ──────────────────────────────────────────
            'alpha'                   => 'images/products/alpha.png',
            'farhampton'              => 'images/products/farhampton.png',
            'untitled-humans-aroma-01'=> 'images/products/untitled-humans-aroma-01.png',
            'philea'                  => 'images/products/philea.png',
            'sore-eterna'             => 'images/products/sore-eterna.png',
            'orgsm'                   => 'images/products/orgsm.png',
            'unrosed'                 => 'images/products/unrosed.png',
            'essence-of-the-sun'      => 'images/products/essence-of-the-sun.png',
            'addict'                  => 'images/products/addict.png',
            'untitled-humans-aroma-02'=> 'images/products/untitled-humans-aroma-02.png',

            // ── SAFF & CO ────────────────────────────────────────────
            'eulalie'                 => 'images/products/eulalie.png',
            'kie-raha'                => 'images/products/kie-raha.png',
            'rae-nira'                => 'images/products/rae-nira.png',
            'irai-leima'              => 'images/products/irai-leima.png',
            'solaris'                 => 'images/products/solaris.png',
            'saff'                    => 'images/products/saff.png',
            'ostara'                  => 'images/products/ostara.png',
            'las-pozas'               => 'images/products/las-pozas.png',
            'xocolatl'                => 'images/products/xocolatl.png',
            'sotb'                    => 'images/products/sotb.png',

            // ── MANDALIKA PARFUM ─────────────────────────────────────
            'no-1'                    => 'images/products/no-1.png',
            'only-the-brave'          => 'images/products/only-the-brave.png',
            '24-hours'                => 'images/products/24-hours.png',
            'gorgeous-tuberose'       => 'images/products/gorgeous-tuberose.png',
            'holy-sweet'              => 'images/products/holy-sweet.png',
            'remember-me'             => 'images/products/remember-me.png',
            'seduction-mandalika'     => 'images/products/seduction-mandalika.png',
            'the-only-one-mandalika'  => 'images/products/the-only-one-mandalika.png',
            'hypnotized'              => 'images/products/hypnotized.png',
            'mr-fantastic'            => 'images/products/mr-fantastic.png',

            // ── KAHF ─────────────────────────────────────────────────
            'true-brotherhood'        => 'images/products/true-brotherhood.png',
            'revered-oud-edt'         => 'images/products/revered-oud-edt.png',
            'humbling-forest-edt'     => 'images/products/humbling-forest-edt.png',
            'invigorating-waterfall-edt' => 'images/products/invigorating-waterfall-edt.png',
            'saffron-oud-edp'         => 'images/products/saffron-oud-edp.png',
            'humbling-forest-edp'     => 'images/products/humbling-forest-edp.png',
            'invigorating-waterfall-edp' => 'images/products/invigorating-waterfall-edp.png',
            'mineralwave'             => 'images/products/mineralwave.png',
            'aquaterrae'              => 'images/products/aquaterrae.png',
            'silverwood'              => 'images/products/silverwood.png',

            // ── CARL & CLAIRE ─────────────────────────────────────────
            'a-love-like-this'        => 'images/products/a-love-like-this.png',
            'black-dahlia'            => 'images/products/black-dahlia.png',
            'dancing-with-my-shadow'  => 'images/products/dancing-with-my-shadow.png',
            'delicate-embrace'        => 'images/products/delicate-embrace.png',
            'emily-in-paris-enchantee'=> 'images/products/emily-in-paris-enchantee.png',
            'morning-glory'           => 'images/products/morning-glory.png',
            'song-of-the-youth'       => 'images/products/song-of-the-youth.png',
            'spring-sonata'           => 'images/products/spring-sonata.png',
            'take-my-hand'            => 'images/products/take-my-hand.png',
            'talking-to-the-moon'     => 'images/products/talking-to-the-moon.png',

            // ── ALCHEMIST FRAGRANCE ───────────────────────────────────
            'home-garden'             => 'images/products/home-garden.png',
            'out-west'                => 'images/products/out-west.png',
            'onirique'                => 'images/products/onirique.png',
            'galleria'                => 'images/products/galleria.png',
            'got-my-mojo-back'        => 'images/products/got-my-mojo-back.png',
            'pink-laundry'            => 'images/products/pink-laundry.png',
            'powder-room'             => 'images/products/powder-room.png',
            'forest-rain'             => 'images/products/forest-rain.png',
            'farshore'                => 'images/products/farshore.png',
            'a-night-in-marrakesh'    => 'images/products/a-night-in-marrakesh.png',

            // ── OULLU ─────────────────────────────────────────────────
            'aether'                  => 'images/products/aether.png',
            'arcana'                  => 'images/products/arcana.png',
            'bird-song'               => 'images/products/bird-song.png',
            'deep-dive'               => 'images/products/deep-dive.png',
            'dia'                     => 'images/products/dia.png',
            'ego-oullu'               => 'images/products/ego-oullu.png',
            'phobos'                  => 'images/products/phobos.png',
            'solar-rays'              => 'images/products/solar-rays.png',
            'umbra'                   => 'images/products/umbra.png',
            'zephyr'                  => 'images/products/zephyr.png',

            // ── HINT ──────────────────────────────────────────────────
            'cherise-hint'            => 'images/products/cherise-hint.png',
            'dragon-hint'             => 'images/products/dragon-hint.png',
            'epitome-hint'            => 'images/products/epitome-hint.png',
            'fatale-hint'             => 'images/products/fatale-hint.png',
            'identity-hint'           => 'images/products/identity-hint.png',
            'matcha-hint'             => 'images/products/matcha-hint.png',
            'metaverse-hint'          => 'images/products/metaverse-hint.png',
            'noble-hint'              => 'images/products/noble-hint.png',
            'realm-hint'              => 'images/products/realm-hint.png',
            'resurrect-hint'          => 'images/products/resurrect-hint.png',
        ];

        $updated  = 0;
        $notFound = 0;
        $missing  = [];

        foreach ($images as $slug => $imagePath) {
            $product = Product::where('slug', $slug)->first();

            if (!$product) {
                $notFound++;
                continue;
            }

            // Hanya update kalau file PNG sudah ada di public/
            if (file_exists(public_path($imagePath))) {
                $product->update(['image' => $imagePath]);
                $updated++;
            } else {
                // File belum ada — catat tapi jangan update
                $missing[] = $slug . ' → ' . $imagePath;
            }
        }

        $this->command->info("✅ Updated: {$updated} produk");

        if ($notFound > 0) {
            $this->command->warn("⚠️  Slug tidak ditemukan di DB: {$notFound}");
        }

        if (!empty($missing)) {
            $this->command->warn('⚠️  File PNG belum ada (' . count($missing) . '):');
            foreach ($missing as $m) {
                $this->command->line("   - {$m}");
            }
            $this->command->line('');
            $this->command->line('Letakkan file PNG di folder: public/images/products/');
            $this->command->line('Lalu jalankan seeder ini lagi.');
        }
    }
}
