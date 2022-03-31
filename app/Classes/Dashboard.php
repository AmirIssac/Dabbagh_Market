<?php
namespace App\Classes;

use App\Models\Shop\Order;

class Dashboard
{
    public function ordersByYearChart($year){
        // all orders
        $january = Order::whereYear('created_at',$year)->whereMonth('created_at',1)->count();
        $february = Order::whereYear('created_at',$year)->whereMonth('created_at',2)->count();
        $march = Order::whereYear('created_at',$year)->whereMonth('created_at',3)->count();
        $april = Order::whereYear('created_at',$year)->whereMonth('created_at',4)->count();
        $may = Order::whereYear('created_at',$year)->whereMonth('created_at',5)->count();
        $june = Order::whereYear('created_at',$year)->whereMonth('created_at',6)->count();
        $july = Order::whereYear('created_at',$year)->whereMonth('created_at',7)->count();
        $august = Order::whereYear('created_at',$year)->whereMonth('created_at',8)->count();
        $september = Order::whereYear('created_at',$year)->whereMonth('created_at',9)->count();
        $october = Order::whereYear('created_at',$year)->whereMonth('created_at',10)->count();
        $november = Order::whereYear('created_at',$year)->whereMonth('created_at',11)->count();
        $december = Order::whereYear('created_at',$year)->whereMonth('created_at',12)->count();
        $orders = array($january,$february,$march,$april,$may,$june,$july,$august,
                       $september,$october,$november,$december);
        // delivered orders
        $january = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',1)->count();
        $february = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',2)->count();
        $march = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',3)->count();
        $april = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',4)->count();
        $may = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',5)->count();
        $june = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',6)->count();
        $july = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',7)->count();
        $august = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',8)->count();
        $september = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',9)->count();
        $october = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',10)->count();
        $november = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',11)->count();
        $december = Order::where('status','delivered')->whereYear('created_at',$year)->whereMonth('created_at',12)->count();
        $delivered = array($january,$february,$march,$april,$may,$june,$july,$august,
                       $september,$october,$november,$december);
        return array('orders_count'=>$orders,'delivered'=>$delivered);
    }
}

?>