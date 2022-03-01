<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Shop\Order;
use App\Models\Shop\OrderItem;
use App\Models\Shop\Profile;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function checkout(){
        $user = User::findOrFail(Auth::user()->id);
        $profile = $user->profile;
        $cart = $user->cart;
        $cart_items = $cart->cartItems;
        $date = now()->toDateString();
        $total_order_price = 0 ;
        $tax = Setting::first()->tax;
        foreach($cart_items as $item){
            if($item->product->discount){
                $discount_type = $item->product->discount->type;
                if($discount_type == 'percent'){
                     $discount = $item->product->price * $item->product->discount->value / 100;
                     $new_price = $item->product->price - $discount;
                     if($item->product->unit == 'gram')
                        $total_order_price += $new_price * $item->quantity / 1000 ;
                     else
                        $total_order_price += $new_price * $item->quantity;
                     }
                else {
                     $new_price = $item->product->price - $item->product->discount->value;   
                     if($item->product->unit == 'gram')
                        $total_order_price += $new_price * $item->quantity / 1000 ;
                     else
                        $total_order_price += $new_price * $item->quantity;
                }   
            }
            else{   // no discount
                if($item->product->unit == 'gram')
                     $total_order_price += $item->product->price * $item->quantity / 1000  ;
                else
                     $total_order_price += $item->product->price * $item->quantity;
            } 
        } 
        return view('Customer.order.checkout',['cart'=>$cart , 'cart_items' => $cart_items,'date' => $date, 'total_order_price' => $total_order_price,'profile'=>$profile,'tax'=>$tax]);
    }

    public function submit(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $cart = $user->cart;
        $cart_items = $cart->cartItems;
        $total_order_price = 0 ;
        $tax = Setting::first()->tax;
        $number_of_today_orders = Order::whereYear('created_at',now()->year)->whereMonth('created_at',now()->month)
                                    ->whereDay('created_at',now()->day)->count();
        $date = Carbon::now();
        $date = $date->format('ymd');    // third segment
        $number = $date.str_pad($number_of_today_orders + 1, 4, "0", STR_PAD_LEFT);
        //$order_items_arr = array(array());
        // $order_items_arr is array of arrays
        foreach($cart_items as $item){
            if($item->product->discount){
                $discount_type = $item->product->discount->type;
                if($discount_type == 'percent'){
                     $discount = $item->product->price * $item->product->discount->value / 100;
                     $new_price = $item->product->price - $discount;
                     if($item->product->unit == 'gram')
                            $total_order_price += $new_price * $item->quantity / 1000 ;
                     else
                            $total_order_price += $new_price * $item->quantity;
                     // order item
                     $order_items_arr[] = ['product_id' => $item->product->id , 'price' => $new_price , 'discount' => $discount , 'quantity' => $item->quantity];
                     }
                else {
                     $new_price = $item->product->price - $item->product->discount->value;   
                     if($item->product->unit == 'gram')
                            $total_order_price += $new_price * $item->quantity / 1000 ;
                     else
                            $total_order_price += $new_price * $item->quantity;                     // order item
                     $order_items_arr[] = ['product_id' => $item->product->id , 'price' => $new_price , 'discount' => $item->product->discount->value  , 'quantity' => $item->quantity];
                }   
            }
            else{   // no discount
                     if($item->product->unit == 'gram')
                        $total_order_price += $item->product->price * $item->quantity / 1000  ;
                     else
                        $total_order_price += $item->product->price * $item->quantity;
                      // order item
                      $order_items_arr[] = ['product_id' => $item->product->id , 'price' => $item->product->price , 'discount' => 0  , 'quantity' => $item->quantity];
            } 
        }
        $tax_value = $tax * $total_order_price / 100 ;
        $grand_order_total = $total_order_price + $tax_value ;
        if($request->payment_method == 'cash')
            $order_status = 'pending';
        else
            $order_status = 'preparing';
        $address = $request->address1;   // default main address
        if($request->address2)
            $address = $request->address2;
        $order = Order::create([
            'user_id' => $user->id ,
            'number' =>  $number ,
            'status' => $order_status ,
            'sub_total' => $total_order_price ,
            'tax_ratio' => $tax ,
            'tax_value' => $tax_value ,
            'shipping' => 0 ,
            'total' => $grand_order_total ,
            'first_name' => $request->first_name , 
            'last_name' => $request->last_name ,
            'phone' => $request->phone ,
            'email' => $request->email ,
            'address' => $address ,
            'customer_note' => $request->customer_note ,
        ]);
        // inserting order_items
        foreach($order_items_arr as $order_item){
            OrderItem::create([
                'order_id' => $order->id ,
                'product_id' => $order_item['product_id'] ,
                'price' => $order_item['price'] ,
                'discount' => $order_item['discount'] ,
                'quantity' => $order_item['quantity'] ,
            ]);
        }
        // delete items from cart
        foreach($cart_items as $cart_item){
                $cart_item->delete();
        }

         return redirect(route('order.details',$order->id));

    }

    public function details($id){
        $order = Order::findOrFail($id);
        $order_items = $order->orderItems;
        return view('Customer.order.order_details',['order' => $order , 'order_items' => $order_items]);
    }

    public function showMyOrders(){
        $user = User::findOrFail(Auth::user()->id);
        $orders = $user->orders()->orderBy('updated_at','DESC')->get();
        return view('Customer.order.my_orders',['orders'=>$orders]);
    }
}