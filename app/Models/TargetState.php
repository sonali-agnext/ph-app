<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TargetState extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'component_type_id',
        'component_id',
        'sub_component_id',
        'crop_id',
        'physical_target',
        'financial_target',
        'remarks'
    ];
}