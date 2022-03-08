<?php

namespace App\Models;

use App\Models\Shop\Cart;
use App\Models\Shop\Order;
use App\Models\Shop\PaymentDetail;
use App\Models\Shop\Profile;
use App\Models\Shop\Transaction;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable , HasRoles;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // relationships
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function orderSystems()
    {
        return $this->hasMany(OrderSystem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function paymentsDetails()
    {
        return $this->hasMany(PaymentDetail::class);
    }

    public function stores(){
        return $this->belongsToMany(Store::class, 'store_user');
    }


    // custom functions

    public function adminstrative(){    //  موظف او ادمن
        $user = User::find(Auth::user()->id);
        if($user->hasRole('super_admin') || $user->hasRole('admin') || $user->hasRole('employee'))
            return true;
        else
            return false;
    }

    public function isSuperAdmin($user){
        if($user->hasRole('super_admin'))
            return true;
        else
            return false;
    }

    public function isAdmin($user){
        if($user->hasRole('admin'))
            return true;
        else
            return false;
    }
    public function isEmployee($user){
        if($user->hasRole('employee'))
            return true;
        else
            return false;
    }
    public function isCustomer($user){
        if($user->hasRole('customer'))
            return true;
        else
            return false;
    }


}
