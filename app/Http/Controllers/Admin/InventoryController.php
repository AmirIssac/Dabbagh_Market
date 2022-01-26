<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    //

    public function index(){
        $products = Product::simplePaginate(2);
        $categories = Category::all();
        return view('Admin.Inventory.index',['products'=>$products,'categories'=>$categories]);
    }

    public function storeProduct(Request $request){
        $imagePath = $request->file('primary_image')->storeAs(
            'Products', $request->code
        );
        $product = Product::create([
            'category_id' => $request->category_id,
            'code' => $request->code,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'image' => $imagePath,
        ]);
        return back();
    }
}
