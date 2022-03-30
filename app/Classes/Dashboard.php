<?php
namespace App\Classes;

use App\Models\Shop\Order;

class Dashboard
{
    public function ordersByYearChart($year){
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
        $array = array($january,$february,$march,$april,$may,$june,$july,$august,
                       $september,$october,$november,$december);
        return $array;
    }
}

?>