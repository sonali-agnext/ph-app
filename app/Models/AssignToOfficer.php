<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignToOfficer extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'officer_id', 'tehsil_id', 'district_id'
    ];
}