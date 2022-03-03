<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop\CartItem;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    //

    public function viewProduct($id){
        $product = Product::findOrFail($id);
        return view ('Customer.product.view',['product'=>$product]);
    }

    /*
    public function addProductToCart(Request $request,$id){
        $product = Product::findOrFail($id);
        $user = User::findOrFail(Auth::user()->id);
        $cart = $user->cart;
        //$cart->products()->attach([$product->id]);
        // check if product repeated in cart so we increase quantity
        $check_product = CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
        if($check_product){
            $check_product->update([
                'quantity' => $check_product->quantity + $request->quantity,   // quantity is the weight in gram
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
    */

    public function addProductToCart(Request $request,$id){
        $product = Product::findOrFail($id);
        //$user = User::findOrFail(Auth::user()->id);
        if(Auth::user()){     // logged user
                $user = User::findOrFail(Auth::user()->id);
                $cart = $user->cart;
                //$cart->products()->attach([$product->id]);
                // check if product repeated in cart so we increase quantity
                $check_product = CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
                if($check_product){
                    $check_product->update([
                        'quantity' => $check_product->quantity + $request->quantity,   // quantity is the weight in gram
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
        else{    // Guest
                if(!Session::get('cart')){    // the first time we add to cart so we initialize the cart array to store in Session
                //$cart = array(array());   // array contain the each cart_item as array
                $cart_item = array('product_id'=>$product->id,'quantity'=>$request->quantity);
                $cart[]=$cart_item;
                Session::put('cart',$cart);
                }
                else{    // no init needed
                    $cart = Session::get('cart');
                    $product_exist = false ;
                    $i = 0 ;
                    foreach($cart as $item){
                        if($item['product_id'] == $product->id){  // product exist in the cart before
                            $new_quantity = $request->quantity ;
                            $cart[$i]['quantity'] = $cart[$i]['quantity'] + $new_quantity ;
                            $product_exist = true ;
                            break;
                        }
                        $i++;
                    }
                    Session::put('cart',$cart);
                    if(!$product_exist){
                        $cart_item = array('product_id'=>$product->id,'quantity'=>$request->quantity);
                        $cart[]=$cart_item;
                        Session::put('cart',$cart);
                    }
                }
                return response('success');
        }
    }

    public function updateProductCart(Request $request , $id){
            $product = Product::findOrFail($id);
            if(Auth::user()){    // Customer
                $user = User::findOrFail(Auth::user()->id);
                $cart = $user->cart;
                //$cart->products()->attach([$product->id]);
                // check if product repeated in cart so we increase quantity
                $check_product = CartItem::where('cart_id',$cart->id)->where('product_id',$product->id)->first();
                if($check_product){
                    $check_product->update([
                        'quantity' => (int) $request->quantity,
                    ]);
                }
                return response('success');
            }
            else{   // Guest
                $cart = Session::get('cart');
                $i = 0 ;
                foreach($cart as $item){
                    if($item['product_id'] == $product->id){  // product exist in the cart before
                        $new_quantity = (int) $request->quantity ;
                        $cart[$i]['quantity'] =  $new_quantity ;
                        break;
                    }
                    $i++;
                }
                Session::put('cart',$cart);
                return response('success');
            }
            
    }
}
