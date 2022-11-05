<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetBlock extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'district_id', 
        'tehsil_id', 
        'target_district_id', 
        'target_state_id', 
        'assigned_physical_target', 
        'assigned_private_physical_target', 
        'district_remarks', 
        'district_private_remarks', 
        'district_year', 
        'gen_target', 
        'sc_target', 
        'st_target', 
        'women_target', 
        'private_gen_target', 
        'assigned_gen_target', 
        'assigned_sc_target', 
        'assigned_st_target', 
        'assigned_women_target', 
        'assigned_private_gen_target', 
        'assigned_private_sc_target', 
        'assigned_private_st_target', 
        'assigned_private_women_target', 
        'private_st_target', 
        'private_sc_target', 
        'private_women_target'
    ];
}