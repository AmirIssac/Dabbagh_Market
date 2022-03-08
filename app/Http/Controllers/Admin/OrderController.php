<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSystem;
use App\Models\Shop\Order;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('created_at','DESC')->simplePaginate(15);
        return view('Admin.orders.index',['orders'=>$orders]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();   // for select input
        $order_store = $order->store;
        $order_items = $order->orderItems;
        return view('Admin.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items,'order_store'=>$order_store]);
    }
    public function transferOrder(Request $request , $id){
        $order = Order::findOrFail($id);
        if(!$request->change_order_transfer){    // transfer
            $order->update([
            'store_id' => $request->store_id,
            ]);
            $order_system = OrderSystem::create([
                'order_id' => $order->id,
                'user_id' => Auth::user()->id,
                'status' => $order->status,
                'employee_note' => $request->admin_note,
            ]);
        }
        else{     // change transfer
            $order->update([
                'store_id' => $request->store_id,
                ]);
            $order_system = $order->orderSystems->first();
            $order_system->update([
                    'user_id' => Auth::user()->id,
                ]);
        }
        return back();
    }
}
