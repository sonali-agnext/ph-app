<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tehsil extends Model
{
    //
    public $timestamps = true;
    protected $fillable = [
        'district_id', 'tehsil_name'
    ];

    public function getTehsilName($id){
        return $this->where('id',$id)->pluck('tehsil_name')->first();
    }
}
