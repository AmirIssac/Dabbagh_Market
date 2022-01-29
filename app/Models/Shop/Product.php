<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'code',
        'name_en',
        'name_ar',
        'description',
        'price',
        'unit',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

}
