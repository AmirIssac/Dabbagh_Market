<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

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
        return view('Admin.users.view_user',['person' => $person]);
    }
}
