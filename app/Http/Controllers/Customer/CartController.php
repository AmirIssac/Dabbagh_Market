<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Shop\CartItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function viewCart(){
        $user = User::findOrFail(Auth::user()->id);
        $cart = $user->cart;
        $cart_items = $cart->cartItems;
        $tax = Setting::first()->tax;
        $cart_total = 0 ;
        foreach($cart_items as $item){
            if($item->product->discount){
                $discount_type = $item->product->discount->type;
                if($discount_type == 'percent'){
                            $discount = $item->product->price * $item->product->discount->value / 100;
                            $cart_total = $cart_total +  (($item->product->price - $discount) * $item->quantity / 1000);
                            }
                else
                            $cart_total = $cart_total +  (($item->product->price - $item->product->discount->value) * $item->quantity / 1000);
            }
            else  // no discount for this item
                $cart_total = $cart_total + ($item->product->price * $item->quantity / 1000);

        }
        return view('Customer.cart.view_details',['cart'=>$cart,'cart_items'=>$cart_items,'cart_total' => $cart_total,'tax'=>$tax]);
    }

    public function deleteCartItem($id){
        $cart_item = CartItem::findOrFail($id);
        $cart_item->delete();
        return back();
    }
}
