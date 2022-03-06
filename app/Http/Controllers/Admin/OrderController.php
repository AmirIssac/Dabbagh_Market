<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at','DESC')->simplePaginate(15);
        return view('Admin.orders.index',['orders'=>$orders]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $order_items = $order->orderItems;
    }
}
