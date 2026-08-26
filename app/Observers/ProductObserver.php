<?php

namespace App\Observers;

use App\Models\Product;
use App\Services\ImageResizeService;
use Illuminate\Support\Facades\Cache;

class ProductObserver
{
    public function saved(Product $product): void
    {
        $this->clearCaches($product);

        if (!$product->image) return;
        if (!$product->wasChanged('image') && !$product->wasRecentlyCreated) return;

        $imagePath = $product->image;
        dispatch(function () use ($imagePath) {
            ImageResizeService::resizeAndCrop($imagePath, 600, 600);
        })->afterResponse();
    }

    public function deleted(Product $product): void
    {
        $this->clearCaches($product);
    }

    private function clearCaches(Product $product): void
    {
        // Home page
        Cache::forget('home.slides');
        Cache::forget('home.night_products');
        Cache::forget('home.day_products');
        Cache::forget('home.recommendations');
        Cache::forget('home.brands');

        // Listing pages
        Cache::forget('fragrances.index');
        Cache::forget('brands.index');
        Cache::forget('accords.index');
        Cache::forget('notes.index');

        // Search API
        Cache::forget('api.search-products');

        // Product detail & related
        if ($product->slug) {
            Cache::forget("product.{$product->slug}");
        }
        if ($product->brand_id) {
            Cache::forget("product.related.{$product->brand_id}.{$product->id}");
        }
    }
}
