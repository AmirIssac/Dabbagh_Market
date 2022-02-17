<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'discount_id',
        'code',
        'name_en',
        'name_ar',
        'description',
        'price',
        'min_weight',
        'increase_by',
        'unit',
        'availability',
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

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    /*
    public function carts()
    {
        return $this->belongsToMany(Cart::class , 'cart_product');
    }
    */

}
