<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'tehsil_id', 'city_name'
    ];
}
