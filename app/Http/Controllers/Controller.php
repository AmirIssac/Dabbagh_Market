<?php

namespace App\Http\Controllers;

use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){
        $categories = Category::all();
        $products = Product::all();
        return view('index',['categories'=>$categories,'products'=>$products]);
    }

    public function adminDashboard(){
        return view('Admin.dashboard');
    }

    public function signUpForm(){
        return view('auth.signUp');
    }
}
