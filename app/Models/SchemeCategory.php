<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeCategory extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'category_name'
    ];
}
