<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'product_slug',
        'sillage', 'projection', 'longevity', 'review_text',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tambahkan ini ↓
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_slug', 'slug');
    }
}