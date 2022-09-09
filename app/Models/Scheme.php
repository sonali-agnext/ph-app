<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scheme extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'govt_id', 'category_id', 'component_id', 'sub_component_id', 'scheme_subcategory_id', 'scheme_name', 'non_project_based', 'subsidy', 'cost_norms', 'terms', 'detailed_description', 'videos', 'videos_title', 'scheme_image', 'public_sector', 'private_sector', 'is_featured', 'year', 'units'
    ];
}
