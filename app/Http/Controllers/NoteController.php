<?php
namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class NoteController extends Controller
{
    public function index()
    {
        $groups = Cache::remember('notes.index', 3600, function () {
            $dbNotes = Note::all();

            $accordOrder = [
                'Citrus', 'Fruity', 'Floral', 'Wood', 'Musk', 'Amber',
                'Spices', 'Aromatic', 'Green', 'Watery', 'Gourmand',
                'Vanilla', 'Oud', 'Leather', 'Synthetic', 'Powdery', 'Fresh',
            ];

            $accordColors = [
                'Citrus'    => '#F5A623',
                'Fruity'    => '#7ED321',
                'Floral'    => '#FF6B9D',
                'Wood'      => '#8B572A',
                'Musk'      => '#9B9B9B',
                'Amber'     => '#F8A100',
                'Spices'    => '#D0021B',
                'Aromatic'  => '#7B68EE',
                'Green'     => '#417505',
                'Watery'    => '#4A90E2',
                'Gourmand'  => '#C0392B',
                'Vanilla'   => '#F3D19C',
                'Oud'       => '#3B2415',
                'Leather'   => '#4A2C2A',
                'Synthetic' => '#B8B8B8',
                'Powdery'   => '#E8D9F0',
                'Fresh'     => '#6DD3CE',
            ];

            $grouped = $dbNotes
                ->filter(fn($n) => !empty($n->accord_group))
                ->groupBy('accord_group');

            return collect($accordOrder)
                ->filter(fn($accord) => $grouped->has($accord))
                ->map(fn($accord) => [
                    'slug'  => Str::slug($accord),
                    'name'  => $accord,
                    'color' => $accordColors[$accord] ?? '#888',
                    'notes' => $grouped[$accord]->unique('name')->map(fn($n) => [
                        'name'  => $n->name,
                        'image' => $this->resolveNoteImage($n),
                        'icon'  => $n->icon,
                    ])->values()->toArray(),
                ])
                ->values()
                ->toArray();
        });

        return view('notes.index', compact('groups'));
    }

    /**
     * Resolve image URL untuk note.
     * Cache-aware: hasil di-cache bersama note.index, jadi file_exists
     * hanya dijalankan sekali per cache TTL, bukan setiap request.
     */
    private function resolveNoteImage($note): ?string
    {
        foreach (['png', 'jpg', 'jpeg', 'webp'] as $ext) {
            $publicPath = "images/notes/{$note->slug}.{$ext}";
            if (file_exists(public_path($publicPath))) {
                return asset($publicPath);
            }
        }

        if (!empty($note->image_path)) {
            return asset('storage/' . $note->image_path);
        }

        return null;
    }

    public function search(Request $request)
    {
        $noteNames = $request->input('notes', []);

        if (empty($noteNames)) {
            return response()->json(['products' => []]);
        }

        $noteIds = Note::whereIn('name', $noteNames)->pluck('id');

        if ($noteIds->isEmpty()) {
            return response()->json(['products' => []]);
        }

        $products = Product::where('is_active', true)
            ->whereHas('notes', function ($q) use ($noteIds) {
                $q->whereIn('notes.id', $noteIds);
            })
            ->with(['brand', 'notes'])
            ->withCount(['notes as matched_notes_count' => function ($q) use ($noteIds) {
                $q->whereIn('notes.id', $noteIds);
            }])
            ->orderByDesc('matched_notes_count')
            ->limit(20)
            ->get()
            ->map(fn($p) => [
                'name'           => $p->name,
                'slug'           => $p->slug,
                'brand'          => $p->brand?->name ?? '',
                'image'          => $p->image_url,
                'category'       => $p->category ?? 'EDP',
                'matched_notes'  => $p->matched_notes_count,
                'total_selected' => count($noteNames),
            ]);

        return response()->json(['products' => $products]);
    }
}
