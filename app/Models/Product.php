<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'brand_id', 'category', 'collection', 'gender',
        'price', 'volume_ml', 'description', 'image', 'affiliate_link', 'is_active'
    ];

    protected $casts = ['is_active' => 'boolean', 'price' => 'decimal:2'];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function notes()
    {
        return $this->belongsToMany(Note::class, 'product_note')->withPivot('note_type');
    }

    public function topNotes()
    {
        return $this->belongsToMany(Note::class, 'product_note')
                    ->wherePivot('note_type', 'top');
    }

    public function middleNotes()
    {
        return $this->belongsToMany(Note::class, 'product_note')
                    ->wherePivot('note_type', 'middle');
    }

    public function baseNotes()
    {
        return $this->belongsToMany(Note::class, 'product_note')
                    ->wherePivot('note_type', 'base');
    }

    public function accords()
    {
        return $this->belongsToMany(Accord::class, 'product_accord');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_slug', 'slug');
    }

    /**
     * URL gambar siap pakai.
     * 1. Null/kosong        → placeholder
     * 2. Path statis        → asset('images/...')
     * 3. Upload Filament    → asset('storage/...')
     */
    public function getImageUrlAttribute(): string
    {
        if (!$this->image) {
            return asset('images/products/placeholder.png');
        }
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        return asset('storage/' . ltrim($this->image, '/'));
    }

    /**
     * Average rating — jika reviews sudah di-load via eager loading,
     * pakai collection (no extra query). Jika belum, pakai aggregasi DB
     * langsung (1 query, tanpa tarik semua baris).
     */
    public function getAverageRatingAttribute(): float
    {
        // Jika sudah di-eager load, hitung dari koleksi yang sudah ada
        if ($this->relationLoaded('reviews')) {
            $reviews = $this->reviews;
            if ($reviews->isEmpty()) return 0.0;
            return round($reviews->avg(fn($r) => ($r->sillage + $r->projection + $r->longevity) / 3), 1);
        }

        // Fallback: aggregasi langsung di DB (1 query ringan)
        $avg = $this->reviews()
            ->selectRaw('AVG((sillage + projection + longevity) / 3) as avg_val')
            ->value('avg_val');

        return round((float) ($avg ?? 0), 1);
    }
}
