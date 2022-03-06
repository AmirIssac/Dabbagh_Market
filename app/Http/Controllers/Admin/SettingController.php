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
            }
        }
        return view('Admin.settings.index',['tax'=>$tax,'min_order'=>$min_order]);
    }

    public function update(Request $request){
        $setting_tax = Setting::where('key','tax')->first();
        $setting_min_order = Setting::where('key','min_order_limit')->first();
        $setting_tax->update([
            'value' => $request->tax ,
        ]);
        $setting_min_order->update([
            'value' => $request->min_order_val ,
        ]);
        return back();
    }
}
