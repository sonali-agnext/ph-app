<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'scheme_subcategory_id', 'scheme_name', 'subsidy', 'cost_norms', 'terms', 'detailed_description', 'videos', 'videos_title', 'scheme_image','sector','sector_description','is_featured'
    ];
}
