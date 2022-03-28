<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OrderSystem;
use App\Models\RejectReason;
use App\Models\Shop\Order;
use App\Models\Store;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(){
        $orders = Order::orderBy('store_id')->orderBy('created_at','DESC')->get();
        // orders statistics
        $pending = 0 ;
        $preparing = 0 ;
        $shipping = 0 ;
        $delivered = 0 ;
        $rejected = 0 ;
        $all_orders_no_paginate = Order::get();
        foreach($all_orders_no_paginate as $single_order){
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
        return view('Admin.orders.index',['orders'=>$orders,'status_arr'=>$status_arr]);
    }
    public function editOrder($id){
        $order = Order::findOrFail($id);
        $stores = Store::all();   // for select input
        $order_store = $order->store;
        $order_items = $order->orderItems;
        $order_center_system = $order->orderSystems->first();
        // calculate the estimated hours remaining
        /*
        $estimated = $order->estimated_time;
        $estimated_time = $estimated->diffForHumans(now());
        $estimated_time =  now()->diff($estimated)->format('%H:%I:%S')." Minutes";
        */
        $estimated_time = $order->estimated_time;


        $done_in = false ; // caculate the time between making order and finish it
        if($order->status == 'delivered' || $order->status == 'rejected'){
            $last_process_time = $order->orderSystems->last()->created_at;
            $done_in = $last_process_time->diffInSeconds($order->created_at);
            $done_in = gmdate('H:i:s', $done_in);
        }

        if($order_center_system){
            $order_employee_systems = $order->orderSystems()->where('id','!=',$order_center_system->id)->get();
            return view('Admin.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items,'order_store'=>$order_store,
                    'order_center_system'=>$order_center_system,'order_employee_systems'=>$order_employee_systems,
                    'estimated_time' => $estimated_time,'done_in' => $done_in]);
        }
        else{   // not transfered yet
            // get reasons of reject
            $reject_reasons = RejectReason::all();
            return view('Admin.orders.edit',['order'=>$order,'stores'=>$stores,'order_items'=>$order_items,'order_store'=>$order_store,
                        'estimated_time' => $estimated_time,'reject_reasons'=>$reject_reasons,'done_in' => $done_in]);
        }
    }
    public function transferOrder(Request $request , $id){
        $order = Order::findOrFail($id);
        // check if order rejected
        if($request->store_id == 'reject'){
            $order->update([
                'status' => 'rejected'
            ]);
            $reason_id = $request->reject_reason;
            $order->rejectReasons()->attach($reason_id);
            $reason_note = RejectReason::find($reason_id);
            $order_system = OrderSystem::create([
                'order_id' => $order->id,
                'user_id' => Auth::user()->id,
                'status' => $order->status,
                'employee_note' => $reason_note->name_en,
            ]);
            return back();
        }
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
            return back();
        }
        else{     // change transfer
            $order->update([
                'store_id' => $request->store_id,
                ]);
            $order_system = $order->orderSystems->first();
            $order_system->update([
                    'user_id' => Auth::user()->id ,
                ]);
            return back();
        }
    }
}
