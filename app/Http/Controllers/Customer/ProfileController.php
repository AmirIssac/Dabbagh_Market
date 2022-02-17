<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function myProfile(){
        $user = User::findOrFail(Auth::user()->id);
        $profile = $user->profile;
        return view('Customer.profile.view')->with(['user'=>$user,'profile'=>$profile]);
    }

    public function submitProfile(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        $profile = $user->profile;
        $profile->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address_address' => $request->address_address,
            'address_latitude' => $request->address_latitude,
            'address_longitude' => $request->address_longitude,
        ]);
        return back();
    }
}
