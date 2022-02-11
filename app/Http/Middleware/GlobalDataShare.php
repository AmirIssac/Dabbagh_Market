<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GlobalDataShare
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()){
            $user = User::find(Auth::user()->id);
            $cart = $user->cart;
            $cart_items = $cart->cartItems;
            // sharing data with all views
            View::share(['user' => $user, 'cart' => $cart , 'cart_items' => $cart_items]);
          }
        return $next($request);
    }
}
