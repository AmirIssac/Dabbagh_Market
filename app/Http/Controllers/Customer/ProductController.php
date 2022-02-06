<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop\CartItem;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    //

    public function viewProduct($id){
        $product = Product::findOrFail($id);
        return view ('Customer.product.view',['product'=>$product]);
    }

    public function addProductToCart(Request $request,$id){
        $product = Product::findOrFail($id);
        $user = User::findOrFail(Auth::user()->id);
        $cart = $user->cart;
        //$cart->products()->attach([$product->id]);
        // check if product repeated in cart so we increase quantity
        $check_product = CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
        if($check_product){
            $check_product->update([
                'quantity' => $check_product->quantity + $request->quantity,
            ]);
        }
        else{
            $cartItem = CartItem::create([
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'quantity' => $request->quantity,
            ]);
        }
        return response('success');
    }
}
