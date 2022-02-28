<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserContoller extends Controller
{
    //

    public function index(){
        $customers = User::whereHas('roles', function (Builder $query) {
            $query->where('name','customer');
        })->orderBy('created_at','DESC')->simplePaginate(6);
        $super_admins = User::whereHas('roles', function (Builder $query) {
            $query->where('name','super_admin');
        })->get();
        $admins = User::whereHas('roles', function (Builder $query) {
            $query->where('name','admin');
        })->get();
        $employees = User::whereHas('roles', function (Builder $query) {
            $query->where('name','employee');
        })->get();
        return view('Admin.users.index',['customers' => $customers , 'super_admins' => $super_admins ,
                                        'admins' => $admins , 'employees' => $employees]);
    }

    public function viewUser($id){
        $person = User::findOrFail($id);
        $all_stores = Store::all();
        $user_stores = $person->stores;
        $orders_count = $person->orders->count();
        return view('Admin.users.view_user',['person' => $person,'user_stores'=>$user_stores,'orders_count' => $orders_count,'all_stores' => $all_stores]);
    }

    public function update(Request $request , $id){
        $user = User::findOrFail($id);
        $profile = $user->profile;
        if ($request->filled('confirm_password') && $request->new_password == $request->confirm_password)
            $user->update([
                'email' => $request->email ,
                'name' => $request->first_name ,
                'password' => Hash::make($request->new_password),
            ]);
        else
            $user->update([
                    'email' => $request->email ,
                    'name' => $request->first_name ,

            ]);
        $profile->update([
            'first_name' => $request->first_name ,
            'last_name' => $request->last_name ,
            'phone' => $request->phone ,
            'address_address' => $request->address ,
        ]);
        // attach stores
        $user->stores()->sync($request->stores);

        return back();
    }
}
