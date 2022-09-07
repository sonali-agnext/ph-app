<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'scheme_sub_category_id', 'component_name',
    ];

    //
}