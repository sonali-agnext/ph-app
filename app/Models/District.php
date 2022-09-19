<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'district_name'
    ];

    //
    public function getDistrictName($id){
        return $this->where('id',$id)->pluck('district_name')->first();
    }
}
