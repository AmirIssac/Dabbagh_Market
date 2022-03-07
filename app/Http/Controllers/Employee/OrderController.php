<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Shop\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        //$orders = Order::orderBy('created_at','DESC')->simplePaginate(15);
        $user = User::findOrFail(Auth::user()->id);
        $stores = $user->stores;   // stores this employee works in
        $orders = collect();
        foreach($stores as $store){
            $store_orders = $store->orders;
            foreach($store_orders as $store_order)
                $orders->add($store_order);
        }
        return view('Employee.orders.index',['orders'=>$orders]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();
        $order_items = $order->orderItems;
        return view('Admin.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items]);
    }
}

