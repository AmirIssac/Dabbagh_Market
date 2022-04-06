<?php

namespace App\Models\Shop;

use App\Models\ProductRate;
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

    public function orderItem()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Favorite::class);
    }

    public function productsRate()
    {
        return $this->hasMany(ProductRate::class);
    }

    /*
    public function carts()
    {
        return $this->belongsToMany(Cart::class , 'cart_product');
    }
    */

    public function hasDiscount(){
        if($this->discount)
            return true;
        else
            return false;
    }

    public function rating(){
        $rate = 0 ;
        $product_rates = $this->productsRate;
        if($product_rates->count() > 0){
            foreach($product_rates as $product_rate)
                $rate += $product_rate->value;
            $rate = ceil($rate / $this->productsRate()->count());
        }
        return $rate;
    }

    public function reviews(){
        return $this->productsRate()->count();
    }

}
