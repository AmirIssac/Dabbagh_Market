<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_ar',
        'address',
        'contact_phone',
        'address_latitude',
        'address_longitude',
    ];

}
