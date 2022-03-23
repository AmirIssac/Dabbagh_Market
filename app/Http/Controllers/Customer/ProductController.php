<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Shop\CartItem;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    

    public function indexByCategory($id){
        $category = Category::findOrFail($id);
        $categories = Category::all();
        $products = $category->products;
        return view('index',['categories'=>$categories,'products'=>$products]);
    }

    public function search(Request $request){
        $categories = Category::all();
        $products = Product::where(function($query) use ($request){
            $query->where('name_en','like','%'.$request->search.'%')
            ->orWhere('name_ar','like','%'.$request->search.'%');
        })->get();
        return view('index',['categories'=>$categories,'products'=>$products]);
    }

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

    public function ProductToFavorite($id){
        $product = Product::findOrFail($id);
        if(Auth::user()){     // logged user
                $user = User::findOrFail(Auth::user()->id);
                $favorite = $user->favorite;
                // check if product repeated in favorite so we remove it
                $favorite_products = $favorite->products;
                $check_product = false;
                foreach($favorite_products as $favorite_product){
                    if($favorite_product->id == $product->id){
                        $check_product = true;
                        break;
                    }
                }
                if(!$check_product){
                    $favorite->products()->attach($product->id);
                    return response('added');
                }
                else{
                    $favorite->products()->detach($product->id);
                    return response('removed');
                }
                
        }
    }

    public function removeFromFavorite($id){
        $product = Product::findOrFail($id);
        if(Auth::user()){     // logged user
                $user = User::findOrFail(Auth::user()->id);
                $favorite = $user->favorite;
                $favorite->products()->detach($product->id);
                return back();
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
