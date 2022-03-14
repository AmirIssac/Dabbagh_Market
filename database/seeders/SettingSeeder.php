<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = array('tax' => '5' , 'min_order_limit' => '125' , 'close_delivery' => '13:00:00',
                         'hours_deliver_when_free' => '3' , 'number_of_orders_increase_time' => '5');

        foreach($settings as $setting){
            Setting::create([
                'key' => key($settings) , 
                'value' => $settings[key($settings)] ,
            ]);
            next($settings);
        }
    }
}
