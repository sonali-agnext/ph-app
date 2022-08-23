<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeCategory extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'govt_scheme_id','category_name'
    ];
}
