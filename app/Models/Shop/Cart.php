<?php

namespace App\Models\Shop;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function calculateDeliverTime($order_submit = false){
        $close_delivery = Setting::where('key','close_delivery')->first()->value;
        $hours_deliver_when_free = (float) Setting::where('key','hours_deliver_when_free')->first()->value;
        $number_of_orders_increase_time = (float) Setting::where('key','number_of_orders_increase_time')->first()->value;
        //$time_line =  Carbon::create(now()->year,now()->month,now()->day,19,00);    // 1 pm is the line for delivery time change for next day
        $H = substr($close_delivery, 0, 2);
        $M = substr($close_delivery, 3, 2);
        $time_line =  Carbon::create(now()->year,now()->month,now()->day,$H,$M);    // the line for delivery time change for next day
        if(now() < $time_line){   // delivery today
            // calculate the number of orders not delivered
            $busy_orders_count = Order::where(function($query){
                $query->where('status','pending')
                ->orWhere('status','preparing');
            })->count();
            // if we are free we take X hours to deliver the order for example
            // we increase one hour for every Y orders for example
           if($order_submit == false){
                return  ceil($busy_orders_count * 1 / $number_of_orders_increase_time) + $hours_deliver_when_free ;  // round hours to the upper number
           }
           else{
                $hours_remaining_to_deliver = ceil($busy_orders_count * 1 / $number_of_orders_increase_time) + $hours_deliver_when_free ;  // round hours to the upper number
                return   Carbon::create(now()->year,now()->month,now()->day,now()->hour + $hours_remaining_to_deliver,now()->minute,now()->second);
           }
        }
        else{    // deliver tomorrow
            if($order_submit == false){
                 return 'order now and we will deliver it to you tomorrow';
            }
            else{
                return  Carbon::create(now()->year,now()->month,now()->day + 1,now()->hour,now()->minute,now()->second);
            }
        }
    }
}
