<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Note extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'type', 'icon', 'description', 'image_path'];

    /**
     * URL gambar note untuk dipakai di view: {{ $note->image_url }}
     * - Jika ada upload Filament (image_path terisi) → pakai Storage::url()
     * - Jika tidak ada → kembalikan null (tidak ada placeholder, gambar tidak di-load)
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }
        return Storage::disk('public')->url($this->image_path);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_note')
                    ->withPivot('note_type');
    }
}
