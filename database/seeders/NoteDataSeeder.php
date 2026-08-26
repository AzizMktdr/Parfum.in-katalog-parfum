<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Note;
use Illuminate\Support\Str;

class NoteDataSeeder extends Seeder
{
    public function run(): void
    {
        // Format: [name, type (top/middle/base), accord_group]
        // accord_group = nama group di halaman Notes frontend
        $notes = [

            // ════════════════════════════════════════
            // CITRUS
            // ════════════════════════════════════════
            ['Bergamot',               'top',    'Citrus'],
            ['Lemon',                  'top',    'Citrus'],
            ['Mandarin Orange',        'top',    'Citrus'],
            ['Grapefruit',             'top',    'Citrus'],
            ['Yuzu',                   'top',    'Citrus'],
            ['Orange',                 'top',    'Citrus'],
            ['Bigarade',               'top',    'Citrus'],
            ['Mandarin Zest',          'top',    'Citrus'],
            ['White Bergamot',         'top',    'Citrus'],
            ['Italian Lemon',          'top',    'Citrus'],
            ['Petit Grain',            'top',    'Citrus'],
            ['Neroli',                 'top',    'Citrus'],
            ['Citrus',                 'top',    'Citrus'],

            // ════════════════════════════════════════
            // FRUITY
            // ════════════════════════════════════════
            ['Lychee',                 'top',    'Fruity'],
            ['Raspberry',              'top',    'Fruity'],
            ['Mango',                  'top',    'Fruity'],
            ['Pear',                   'top',    'Fruity'],
            ['Peach',                  'top',    'Fruity'],
            ['Apple',                  'top',    'Fruity'],
            ['Green Apple',            'top',    'Fruity'],
            ['Blackcurrant',           'top',    'Fruity'],
            ['Red Berries',            'top',    'Fruity'],
            ['Cherry',                 'top',    'Fruity'],
            ['Litchi',                 'top',    'Fruity'],
            ['Pomegranate',            'top',    'Fruity'],
            ['Rhubarb',                'top',    'Fruity'],
            ['Strawberry',             'top',    'Fruity'],
            ['Pineapple',              'top',    'Fruity'],
            ['Blackberry',             'top',    'Fruity'],
            ['Mixed Berries',          'top',    'Fruity'],
            ['Cassis',                 'top',    'Fruity'],
            ['Fig',                    'top',    'Fruity'],
            ['Sparkling Blackcurrant', 'top',    'Fruity'],
            ['Ripe Fruit',             'top',    'Fruity'],
            ['Cotton Flower',          'top',    'Fruity'],
            ['Passion Fruit',          'top',    'Fruity'],
            ['Cassis Bud',             'top',    'Fruity'],
            ['Red Fruits',             'top',    'Fruity'],
            ['Fizzy Grapefruit',       'top',    'Fruity'],
            ['Pink Grapefruit',        'top',    'Fruity'],
            ['Rum',                    'top',    'Fruity'],

            // ════════════════════════════════════════
            // FLORAL
            // ════════════════════════════════════════
            ['Rose',                   'middle', 'Floral'],
            ['Jasmine',                'middle', 'Floral'],
            ['Peony',                  'middle', 'Floral'],
            ['Violet',                 'middle', 'Floral'],
            ['Iris',                   'middle', 'Floral'],
            ['Lily of the Valley',     'middle', 'Floral'],
            ['Tuberose',               'middle', 'Floral'],
            ['Magnolia',               'middle', 'Floral'],
            ['Orange Blossom',         'middle', 'Floral'],
            ['Freesia',                'middle', 'Floral'],
            ['Ylang-ylang',            'middle', 'Floral'],
            ['Mimosa',                 'middle', 'Floral'],
            ['White Floral',           'middle', 'Floral'],
            ['Bulgarian Rose',         'middle', 'Floral'],
            ['Rose Absolute',          'middle', 'Floral'],
            ['Sampaguita',             'middle', 'Floral'],
            ['Tiare Flower',           'middle', 'Floral'],
            ['Water Iris',             'middle', 'Floral'],
            ['Orchid',                 'middle', 'Floral'],
            ['Rose Mist',              'middle', 'Floral'],
            ['Jasmine Sambac',         'middle', 'Floral'],
            ['Turkish Rose',           'middle', 'Floral'],
            ['Velvet Note',            'middle', 'Floral'],
            ['Calypsone',              'middle', 'Floral'],
            ['Raat Ki Rani',           'middle', 'Floral'],
            ['Oeillet',                'middle', 'Floral'],
            ['Cape Jasmine',           'middle', 'Floral'],
            ['Petalia',                'middle', 'Floral'],
            ['Heliotrope',             'middle', 'Floral'],
            ['Acacia',                 'middle', 'Floral'],
            ['Earthy Accents',         'middle', 'Floral'],
            ['Palmarosa',              'middle', 'Floral'],

            // ════════════════════════════════════════
            // WOOD
            // ════════════════════════════════════════
            ['Cedarwood',              'middle', 'Wood'],
            ['Sandalwood',             'middle', 'Wood'],
            ['Teak Wood',              'middle', 'Wood'],
            ['Guaiac Wood',            'middle', 'Wood'],
            ['Cashmere Wood',          'middle', 'Wood'],
            ['Soft Wood',              'middle', 'Wood'],
            ['Akigalawood',            'middle', 'Wood'],
            ['Cedar',                  'middle', 'Wood'],
            ['Redwood',                'middle', 'Wood'],
            ['Cedarwood',              'base',   'Wood'],
            ['Sandalwood',             'base',   'Wood'],
            ['Patchouli',              'base',   'Wood'],
            ['Vetiver',                'base',   'Wood'],
            ['Sulawesi Patchouli',     'base',   'Wood'],
            ['Red Cedar',              'base',   'Wood'],
            ['Guaiac Wood',            'base',   'Wood'],
            ['Oakmoss',                'base',   'Wood'],
            ['Moss',                   'base',   'Wood'],
            ['Amberwood',              'base',   'Wood'],
            ['Woody Notes',            'base',   'Wood'],
            ['Cypriol',                'base',   'Wood'],

            // ════════════════════════════════════════
            // MUSK
            // ════════════════════════════════════════
            ['Musk',                   'base',   'Musk'],
            ['Clean Musks',            'base',   'Musk'],
            ['Cashmeran',              'base',   'Musk'],
            ['Ambrette',               'base',   'Musk'],
            ['Cashmere',               'base',   'Musk'],
            ['Musky Undertones',       'base',   'Musk'],

            // ════════════════════════════════════════
            // AMBER
            // ════════════════════════════════════════
            ['Amber',                  'base',   'Amber'],
            ['Dry Amber',              'base',   'Amber'],
            ['Golden Amber',           'base',   'Amber'],
            ['Tolu Balsam',            'base',   'Amber'],
            ['Labdanum',               'base',   'Amber'],
            ['Ambergris',              'base',   'Amber'],
            ['Crystal Amber',          'middle', 'Amber'],
            ['Immortelle',             'middle', 'Amber'],

            // ════════════════════════════════════════
            // SPICES
            // ════════════════════════════════════════
            ['Pink Pepper',            'top',    'Spices'],
            ['Black Pepper',           'top',    'Spices'],
            ['Cardamom',               'top',    'Spices'],
            ['Ginger',                 'top',    'Spices'],
            ['Cinnamon',               'top',    'Spices'],
            ['Saffron',                'top',    'Spices'],
            ['Nutmeg',                 'top',    'Spices'],
            ['Clove',                  'top',    'Spices'],
            ['Cajuput',                'top',    'Spices'],
            ['Tobacco',                'top',    'Spices'],
            ['Peppercorn',             'top',    'Spices'],
            ['Coriander Seed',         'middle', 'Spices'],
            ['Incense',                'middle', 'Spices'],
            ['Geranium',               'middle', 'Spices'],
            ['Clary Sage',             'middle', 'Spices'],
            ['Juniper Berries',        'middle', 'Spices'],

            // ════════════════════════════════════════
            // AROMATIC
            // ════════════════════════════════════════
            ['Lavender',               'top',    'Aromatic'],
            ['Mint',                   'top',    'Aromatic'],
            ['Rosemary',               'top',    'Aromatic'],
            ['Sage',                   'top',    'Aromatic'],
            ['Cypress',                'top',    'Aromatic'],
            ['Coriander',              'top',    'Aromatic'],
            ['Lavender',               'middle', 'Aromatic'],
            ['Sage',                   'middle', 'Aromatic'],

            // ════════════════════════════════════════
            // GREEN
            // ════════════════════════════════════════
            ['Grass',                  'top',    'Green'],
            ['Green Tea',              'top',    'Green'],
            ['Violet Leaves',          'top',    'Green'],
            ['Green Leaves',           'top',    'Green'],
            ['Green Notes',            'middle', 'Green'],
            ['Tea',                    'middle', 'Green'],
            ['White Tea',              'middle', 'Green'],
            ['Floral Rose Accord',     'top',    'Green'],
            ['Matcha',                 'top',    'Green'],
            ['Rain Accord',            'top',    'Green'],

            // ════════════════════════════════════════
            // WATERY
            // ════════════════════════════════════════
            ['Sea Salt',               'top',    'Watery'],
            ['Marine Notes',           'top',    'Watery'],
            ['Aquatic Notes',          'top',    'Watery'],
            ['Ozonic Notes',           'top',    'Watery'],
            ['Melon',                  'top',    'Watery'],
            ['Coconut Water',          'top',    'Watery'],
            ['Aquamare',               'middle', 'Watery'],
            ['Marine Notes',           'middle', 'Watery'],
            ['Water Notes',            'middle', 'Watery'],
            ['Solar Accord',           'middle', 'Watery'],

            // ════════════════════════════════════════
            // GOURMAND
            // ════════════════════════════════════════
            ['Coffee',                 'top',    'Gourmand'],
            ['Chocolate',              'top',    'Gourmand'],
            ['Almond',                 'top',    'Gourmand'],
            ['Dark Chocolate',         'top',    'Gourmand'],
            ['Sugar',                  'top',    'Gourmand'],
            ['Milk Accord',            'top',    'Gourmand'],
            ['Praline',                'middle', 'Gourmand'],
            ['Cacao',                  'middle', 'Gourmand'],
            ['Tonka Bean',             'middle', 'Gourmand'],
            ['Vanilla',                'middle', 'Gourmand'],
            ['Caramel',                'middle', 'Gourmand'],
            ['Benzoin',                'middle', 'Gourmand'],
            ['Tonka Bean',             'base',   'Gourmand'],
            ['Praline',                'base',   'Gourmand'],
            ['Heliotrope',             'base',   'Gourmand'],
            ['Rice Accord',            'middle', 'Gourmand'],

            // ════════════════════════════════════════
            // VANILLA
            // ════════════════════════════════════════
            ['Vanilla',                'base',   'Vanilla'],
            ['Madagascar Vanilla',     'middle', 'Vanilla'],

            // ════════════════════════════════════════
            // OUD
            // ════════════════════════════════════════
            ['Oud',                    'middle', 'Oud'],
            ['Oud',                    'base',   'Oud'],
            ['Agarwood',               'base',   'Oud'],
            ['Gourmand Notes',         'middle', 'Oud'],

            // ════════════════════════════════════════
            // LEATHER
            // ════════════════════════════════════════
            ['Leather',                'middle', 'Leather'],
            ['Leather',                'base',   'Leather'],

            // ════════════════════════════════════════
            // SYNTHETIC
            // ════════════════════════════════════════
            ['Iso E Super',            'base',   'Synthetic'],
            ['Synthetic Notes',        'base',   'Synthetic'],
            ['Aldehydes',              'top',    'Synthetic'],
            ['Powdery Notes',          'middle', 'Synthetic'],
            ['Cotton Accord',          'middle', 'Synthetic'],

            // ════════════════════════════════════════
            // POWDERY
            // ════════════════════════════════════════
            ['Orris Root',             'base',   'Powdery'],
            ['Iris',                   'base',   'Powdery'],

            // ════════════════════════════════════════
            // FRESH
            // ════════════════════════════════════════
            ['Amberwood',              'middle', 'Fresh'],
        ];

        $created = 0;
        $updated = 0;

        foreach ($notes as [$name, $type, $accordGroup]) {
            $slug = Str::slug($name . '-' . $type);

            $result = Note::updateOrCreate(
                ['slug' => $slug],
                [
                    'name'         => $name,
                    'type'         => $type,
                    'accord_group' => $accordGroup,
                    'icon'         => null,
                ]
            );

            $result->wasRecentlyCreated ? $created++ : $updated++;
        }

        $this->command->info("✅ Notes seeded: {$created} created, {$updated} updated");
        $this->command->info('Total notes in DB: ' . Note::count());
    }
}
