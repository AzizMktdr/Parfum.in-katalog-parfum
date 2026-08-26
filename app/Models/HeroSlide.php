<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;

class HeroSlide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'subtitle', 'description',
        'button_text', 'button_link',
        'image', 'bg_color', 'product_id',
        'order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order'     => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Resolve image URL:
     * - "images/products/..." → file statis di public/ folder
     * - semua lainnya         → file upload di storage/app/public/
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            if ($this->product?->image) {
                return $this->resolveStorageOrPublic($this->product->image);
            }
            return asset('images/products/california-signature.png');
        }

        return $this->resolveStorageOrPublic($this->image);
    }

    private function resolveStorageOrPublic(string $path): string
    {
        // Hanya path di bawah images/products/ yang merupakan file statis public/
        if (str_starts_with($path, 'images/products/')) {
            return asset($path);
        }
        // Semua upload Filament (hero/, products/, dst) ada di storage/
        return Storage::disk('public')->url($path);
    }

    public function getResolvedLinkAttribute(): string
    {
        if ($this->button_link) return $this->button_link;
        if ($this->product) return route('product.detail', $this->product->slug);
        return route('fragrances.index');
    }
}
