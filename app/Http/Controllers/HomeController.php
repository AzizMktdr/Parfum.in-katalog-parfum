<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Brand;
use App\Models\HeroSlide;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    private function resolveImage(?string $image): string
    {
        if (!$image) return '';
        if (str_starts_with($image, 'images/')) return $image;
        return 'storage/' . ltrim($image, '/');
    }

    public function index()
    {
        $slides = Cache::remember('home.slides', 3600, function () {
            $heroSlides = HeroSlide::active()->with('product.brand')->get();

            if ($heroSlides->isNotEmpty()) {
                return $heroSlides->map(fn($slide) => [
                    'title'       => $slide->title,
                    'description' => $slide->description ?? '',
                    'watermark'   => $slide->subtitle ?? ($slide->product?->brand?->name ?? ''),
                    'image'       => $slide->image_url,
                    'link'        => $slide->resolved_link,
                    'bg_color'    => $slide->bg_color ?? null,
                    'button_text' => $slide->button_text ?? 'Lihat Detail',
                ])->toArray();
            }

            return Product::where('is_active', true)->with('brand')->latest()->limit(3)->get()
                ->map(fn($p) => [
                    'title'       => strtoupper($p->name),
                    'description' => $p->description ?? 'Parfum eksklusif pilihan terbaik.',
                    'watermark'   => strtoupper($p->brand?->name ?? ''),
                    'image'       => $p->image_url,
                    'link'        => route('product.detail', ['slug' => $p->slug]),
                    'bg_color'    => null,
                    'button_text' => 'Lihat Detail',
                ])->toArray();
        });

        $mapProduct = fn($p) => [
            'name'  => $p->name,
            'brand' => $p->brand?->name ?? '',
            'image' => $p->image_url,
            'slug'  => $p->slug,
        ];

        $night_products = Cache::remember('home.night_products', 3600, function () use ($mapProduct) {
            return Product::where('collection', 'night')->where('is_active', true)
                ->with('brand')->limit(4)->get()->map($mapProduct)->toArray();
        });

        $day_products = Cache::remember('home.day_products', 3600, function () use ($mapProduct) {
            return Product::where('collection', 'day')->where('is_active', true)
                ->with('brand')->limit(4)->get()->map($mapProduct)->toArray();
        });

        $brands = Cache::remember('home.brands', 3600, function () {
            return Brand::limit(6)->get()->map(fn($b) => [
                'name' => $b->name,
                'logo' => $b->logo_url,
                'slug' => $b->slug,
            ])->toArray();
        });

        $recommendations = Cache::remember('home.recommendations', 3600, function () use ($mapProduct) {
            return Product::where('is_active', true)->with('brand')->latest()->limit(3)->get()
                ->map($mapProduct)->toArray();
        });

        $guides = [
            ['num'=>'01','title'=>'Aplikasi pada Pulse Points','text'=>'Semprotkan parfum pada titik nadi seperti pergelangan tangan, leher, dan belakang telinga. Area ini menghasilkan panas yang membantu menyebarkan aroma.'],
            ['num'=>'02','title'=>'Jangan Gosok Pergelangan','text'=>'Menggosok pergelangan tangan setelah menyemprot parfum dapat merusak molekul aroma dan mempercepat penguapan, sehingga wangi tidak bertahan lama.'],
            ['num'=>'03','title'=>'Waktu yang Tepat','text'=>'Aplikasikan parfum tepat setelah mandi saat kulit masih lembab. Kelembaban kulit membantu mengunci aroma lebih lama sepanjang hari.'],
            ['num'=>'04','title'=>'Jangan Semprotkan di Rambut','text'=>'Alkohol dalam parfum dapat membuat rambut kering dan kusam. Gunakan hair mist khusus rambut jika ingin rambut Anda harum.'],
            ['num'=>'05','title'=>'Semprotkan di Pakaian','text'=>'Kain dapat menahan aroma lebih lama dari kulit. Semprotkan sedikit pada pakaian dari jarak aman agar tidak meninggalkan noda.'],
            ['num'=>'06','title'=>'Tunggu Aroma Berkembang','text'=>'Setiap parfum memiliki top, middle, dan base note. Beri waktu 15–30 menit untuk merasakan aroma sesungguhnya di kulit Anda.'],
        ];

        return view('home', compact('slides','night_products','day_products','brands','recommendations','guides'));
    }
}
