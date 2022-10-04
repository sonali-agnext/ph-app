<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetDistrict extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'district_id', 
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
        'private_sc_target',
        'private_st_target',
        'private_women_target'
    ];
}