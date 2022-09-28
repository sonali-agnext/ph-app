<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmerLandDetail extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'farmer_id', 'total_land_area', 'state', 'district_id', 'tehsil_id', 'city_id', 'pin_code', 'land_address', 'area_information', 'upload_fard', 'pattedar_no', 'upload_pattedar', 'khewat_no', 'khatauni_no', 'khasra_no'
    ];
}
