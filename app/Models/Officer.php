<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'phone_number', 'address', 'city_id', 'tehsil_id','district_id', 'state', 'pincode','avatar'
    ];
}
