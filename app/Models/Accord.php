<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accord extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'color', 'description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_accord');
    }
}
