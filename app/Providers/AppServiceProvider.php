<?php

namespace App\Providers;

use App\Models\Brand;
use App\Models\HeroSlide;
use App\Models\Note;
use App\Models\Product;
use App\Observers\BrandObserver;
use App\Observers\HeroSlideObserver;
use App\Observers\NoteObserver;
use App\Observers\ProductObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Product::observe(ProductObserver::class);
        Brand::observe(BrandObserver::class);
        HeroSlide::observe(HeroSlideObserver::class);
        Note::observe(NoteObserver::class);
    }
}
