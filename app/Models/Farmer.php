<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Farmer extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'language', 'applicant_type_id', 'name', 'mobile_number', 'father_husband_name', 'gender', 'resident', 'aadhar_number', 'pan_number', 'caste_category_id', 'state', 'district_id', 'tehsil_id', 'city_id','farmer_unique_id', 'full_address', 'pin_code'
    ];
}
