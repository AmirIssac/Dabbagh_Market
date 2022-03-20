<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\OrderSystem;
use App\Models\Shop\Order;
use App\Models\Store;
use App\Models\User;
use Carbon\Carbon;
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
        // send to view the updated_at timestamp of last pending order when page opened
        $pending_orders = collect();
        foreach($stores as $store){
            $store_orders = $store->orders()->where('status','pending')->orderBy('updated_at','DESC')->get();
            foreach($store_orders as $store_order)
                $pending_orders->add($store_order);
        }
        $last_updated_pending_order_timestamp = $pending_orders->first()->updated_at;


        // orders statistics
        $pending = 0 ;
        $preparing = 0 ;
        $shipping = 0 ;
        $delivered = 0 ;
        $rejected = 0 ;
        foreach($orders as $single_order){
            switch($single_order->status){
                case 'pending' : $pending++ ; break;
                case 'preparing' : $preparing++ ; break;
                case 'shipping' : $shipping++ ; break;
                case 'delivered' : $delivered++ ; break;
                case 'rejected' : $rejected++ ; break;
                default : break;
            }
        $status_arr = array('pending'=>$pending,'preparing'=>$preparing,'shipping'=>$shipping,'delivered'=>$delivered,'rejected'=>$rejected);
        }
        return view('Employee.orders.index',['orders'=>$orders,'last_updated_order_timestamp'=>$last_updated_pending_order_timestamp,
                                                'status_arr'=>$status_arr]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();
        $order_items = $order->orderItems;
        $order_center_system = $order->orderSystems->first();
        $order_employee_systems = $order->orderSystems()->where('id','!=',$order_center_system->id)->get();
        $estimated_time = $order->estimated_time;
        return view('Employee.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items,
                    'order_center_system'=>$order_center_system,'order_employee_systems'=>$order_employee_systems,
                    'estimated_time' => $estimated_time]);
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
            'employee_note' => $request->employee_note ,
        ]);
        // change payment cash status
        $payment_detail = $order->paymentDetail ;
        if($payment_detail->provider == 'cash' && $status == 'delivered'){
            $payment_detail->update([
                'status' => 'success',
            ]);
        }
        if($payment_detail->provider == 'cash' && $status == 'rejected'){
            $payment_detail->update([
                'status' => 'failed',
            ]);
        }
        return back();
    }

    public function ajaxCheckNewOrders(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $stores = $user->stores;   // stores this employee works in
        $orders = collect();
        foreach($stores as $store){
            $store_orders = $store->orders()->where('status','pending')->orderBy('updated_at','DESC')->get();
            foreach($store_orders as $store_order)
                $orders->add($store_order);
        }
        // $last_updated_pending_order = $orders->first();
        $new_orders_count = $orders->where('updated_at' , '>' ,  Carbon::parse($request->updated_at) )->count(); 
        //return response($orders->first());
        return response($new_orders_count);
    }
}

