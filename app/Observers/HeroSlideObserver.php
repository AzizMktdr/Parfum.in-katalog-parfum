<?php

namespace App\Observers;

use App\Models\HeroSlide;
use App\Services\ImageResizeService;
use Illuminate\Support\Facades\Cache;

class HeroSlideObserver
{
    public function saved(HeroSlide $heroSlide): void
    {
        // Invalidate cache slides di homepage
        Cache::forget('home.slides');

        if (!$heroSlide->image) return;
        if (!$heroSlide->wasChanged('image') && !$heroSlide->wasRecentlyCreated) return;

        // Hero image: 600×800px (portrait 3:4)
        ImageResizeService::resizeAndCrop($heroSlide->image, 600, 800);
    }

    public function deleted(HeroSlide $heroSlide): void
    {
        Cache::forget('home.slides');
    }
}
