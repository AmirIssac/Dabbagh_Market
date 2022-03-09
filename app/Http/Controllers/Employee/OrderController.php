<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\OrderSystem;
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
            $store_orders = $store->orders()->orderBy('created_at','DESC')->get();
            foreach($store_orders as $store_order)
                $orders->add($store_order);
        }
        return view('Employee.orders.index',['orders'=>$orders]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();
        $order_items = $order->orderItems;
        $order_center_system = $order->orderSystems->first();
        $order_employee_systems = $order->orderSystems()->where('id','!=',$order_center_system->id)->get();
        return view('Employee.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items,
                    'order_center_system'=>$order_center_system,'order_employee_systems'=>$order_employee_systems]);
    }

    public function acceptOrder($id){
        $order = Order::findOrFail($id);
        $order->update([
            'status' => 'preparing',
        ]);
        $order_system = OrderSystem::create([
            'order_id' => $order->id ,
            'user_id' => Auth::user()->id ,
            'status' => 'preparing' ,
        ]);
        return back();
    }

    public function changeStatus(Request $request , $id){
        $order = Order::findOrFail($id);
        $status = $request->order_status;
        $order->update([
            'status' => $status,
        ]);
        $order_system = OrderSystem::create([
            'order_id' => $order->id ,
            'user_id' => Auth::user()->id ,
            'status' => $status ,
        ]);
        return back();
    }
}

