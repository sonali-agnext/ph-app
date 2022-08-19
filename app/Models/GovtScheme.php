<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GovtScheme extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'govt_name'
    ];
}