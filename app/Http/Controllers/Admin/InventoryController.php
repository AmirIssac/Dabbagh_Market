<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Category;
use App\Models\Shop\Product;
use App\Models\Shop\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventoryController extends Controller
{
    //

    public function index(){
        $products = Product::orderBy('updated_at','DESC')->simplePaginate(10);
        $categories = Category::all();
        return view('Admin.Inventory.index',['products'=>$products,'categories'=>$categories]);
    }

    public function storeProduct(Request $request){
        /*
        $imagePath = $request->file('primary_image')->storeAs(
            'Products', $request->code
        );
        */
        $imagePath = $request->file('primary_image')->store('Products/'.$request->code, 'public');
        if($request->availability == 'yes')
            $availability = true;
        else
            $availability = false;
        $product = Product::create([
            'category_id' => $request->category_id,
            'code' => $request->code,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'availability' => $availability,
            'image' => $imagePath,
        ]);
        // add additional images
        for($i=1;$i<5;$i++){
            if($request->file('image'.$i)){
                /*$image = $request->file('image1')->storeAs(
                    'Products', $request->code.'add'.$i
                );*/
                $image = $request->file('image'.$i)->store('Products/'.$request->code.'add'.$i, 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $image
                ]);
                }
        }
        return back();
    }

    public function editProductForm($id){
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('Admin.Inventory.edit_product_form',['product'=>$product,'categories'=>$categories]);
    }

    public function updateProduct(Request $request , $id){
        $product = Product::findOrFail($id);
        if($request->file('primary_image')){
            // delete old image
            $img = str_replace('/storage', '', $product->image);
            Storage::delete('/public' . $img);
            $imagePath = $request->file('primary_image')->store('Products/'.$request->code, 'public');
        }
        else{   // no update on image
            $imagePath = $product->image;
        }
        if($request->availability == 'yes')
            $availability = true;
        else
            $availability = false;
        $product->update([
            'category_id' => $request->category_id,
            'code' => $request->code,
            'name_en' => $request->name_en,
            'name_ar' => $request->name_ar,
            'description' => $request->description,
            'price' => $request->price,
            'unit' => $request->unit,
            'availability' => $availability,
            'image' => $imagePath,
        ]);
        // update additional images
        for($i=1;$i<5;$i++){
            if($request->file('image'.$i)){
                // delete old image and record
                if($product->productImages()->count() >= $i){   // exist so we delete
                $im = str_replace('/storage', '', $product->productImages[$i-1]->image);
                Storage::delete('/public' . $im);
                $product->productImages[$i-1]->delete();
                }
                $im = $request->file('image'.$i)->store('Products/'.$request->code.'add'.$i, 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $im,
                ]);
            }
        }
        return back();
    }
}
