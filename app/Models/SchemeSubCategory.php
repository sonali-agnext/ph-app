<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SchemeSubCategory extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'scheme_category_id', 'subcategory_name'
    ];
}
