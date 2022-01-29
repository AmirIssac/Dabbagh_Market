<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //

    public function viewProduct($id){
        $product = Product::findOrFail($id);
        return view ('Customer.product.view',['product'=>$product]);
    }
}
