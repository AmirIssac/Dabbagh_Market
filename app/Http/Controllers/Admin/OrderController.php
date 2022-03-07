<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Store;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at','DESC')->simplePaginate(15);
        return view('Admin.orders.index',['orders'=>$orders]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();
        $order_items = $order->orderItems;
        return view('Admin.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items]);
    }
}
