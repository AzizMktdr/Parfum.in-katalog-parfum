<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'logo', 'description', 'country', 'est', 'website'];

    /**
     * URL logo yang siap dipakai di view: {{ $brand->logo_url }}
     */
    public function getLogoUrlAttribute(): string
    {
        if (!$this->logo) {
            return '';
        }
        if (str_starts_with($this->logo, 'images/')) {
            return asset($this->logo);
        }
        return Storage::disk('public')->url($this->logo);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
