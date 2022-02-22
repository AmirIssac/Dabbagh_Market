<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'number',
        'status',
        'sub_total',
        'tax_ratio',
        'tax_value',
        'shipping',
        'total',
        'first_name',
        'last_name',
        'phone',
        'email',
        'address',
        'customer_note',
        'employee_note',
        'estimated_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function paymentDetails()
    {
        return $this->hasOne(PaymentDetail::class);
    }

}
