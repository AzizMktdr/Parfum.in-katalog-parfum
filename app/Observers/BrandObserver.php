<?php

namespace App\Observers;

use App\Models\Brand;
use App\Services\ImageResizeService;
use Illuminate\Support\Facades\Cache;

class BrandObserver
{
    public function saved(Brand $brand): void
    {
        $this->clearCaches($brand);

        if (!$brand->logo) return;
        if (!$brand->wasChanged('logo') && !$brand->wasRecentlyCreated) return;

        ImageResizeService::resizeAndCrop($brand->logo, 400, 400);
    }

    public function deleted(Brand $brand): void
    {
        $this->clearCaches($brand);
    }

    private function clearCaches(Brand $brand): void
    {
        Cache::forget('home.brands');
        Cache::forget('brands.index');
        Cache::forget('fragrances.index');
        if ($brand->slug) {
            Cache::forget("brand.{$brand->slug}");
        }
    }
}
