<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index(){
        $settings = Setting::all();
        foreach($settings as $setting){
            switch($setting->key){
                case 'tax' : $tax = (float) $setting->value;
                             break ;
                case 'min_order_limit' : $min_order = (float) $setting->value;
                                         break ;
                case 'close_delivery' : $close_delivery = $setting->value;
                                            break ;
                case 'hours_deliver_when_free' : $hours_deliver = (int) $setting->value;
                                                 break ;
                case 'number_of_orders_increase_time' : $number_of_orders = (int) $setting->value;
                                                        break ;
                case 'contact_phone' : $contact_phone =  $setting->value;
                                    break ;
                case 'contact_email' : $contact_email =  $setting->value;
                                    break ;
            }
        }
        return view('Admin.settings.index',['tax'=>$tax,'min_order'=>$min_order,'close_delivery'=>$close_delivery,
                                            'hours_deliver_when_free'=>$hours_deliver,'number_of_orders_increase_time'=>$number_of_orders,
                                            'contact_phone' => $contact_phone , 'contact_email' => $contact_email]);
    }

    public function update(Request $request){
        $setting_tax = Setting::where('key','tax')->first();
        $setting_min_order = Setting::where('key','min_order_limit')->first();
        $setting_close_delivery = Setting::where('key','close_delivery')->first();
        $setting_hours_deliver_when_free = Setting::where('key','hours_deliver_when_free')->first();
        $setting_number_of_orders_increase_time = Setting::where('key','number_of_orders_increase_time')->first();
        $setting_contact_phone = Setting::where('key','contact_phone')->first();
        $setting_contact_email = Setting::where('key','contact_email')->first();
        $setting_tax->update([
            'value' => $request->tax ,
        ]);
        $setting_min_order->update([
            'value' => $request->min_order_val ,
        ]);
        $setting_close_delivery->update([
            'value' => $request->close_delivery_time ,
        ]);
        $setting_hours_deliver_when_free->update([
            'value' => $request->hours_to_deliver_free ,
        ]);
        $setting_number_of_orders_increase_time->update([
            'value' => $request->number_of_orders_increase ,
        ]);
        $setting_contact_phone->update([
            'value' => $request->contact_phone ,
        ]);
        $setting_contact_email->update([
            'value' => $request->contact_email ,
        ]);
        return back();
    }
}
