<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(){
        $user = User::findOrFail(Auth::user()->id);
        $cart = $user->cart;
        $cart_items = $cart->cartItems;
        $date = now()->toDateString();
        $total_order_price = 0 ;
        foreach($cart_items as $item){
            if($item->product->discount){
                $discount_type = $item->product->discount->type;
                if($discount_type == 'percent'){
                     $discount = $item->product->price * $item->product->discount->value / 100;
                     $new_price = $item->product->price - $discount;
                     $total_order_price += $new_price * $item->quantity / 1000 ;
                     }
                else {
                     $new_price = $item->product->price - $item->product->discount->value;   
                     $total_order_price += $new_price * $item->quantity / 1000 ;
                }   
            }
            else{   // no discount
                     $total_order_price += $item->product->price * $item->quantity / 1000  ;
            } 
        } 
        return view('Customer.order.checkout',['cart'=>$cart , 'cart_items' => $cart_items,'date' => $date, 'total_order_price' => $total_order_price]);
    }
}