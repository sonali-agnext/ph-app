<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CasteCategory extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'caste_name'
    ];
}
