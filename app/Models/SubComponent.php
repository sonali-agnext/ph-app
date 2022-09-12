<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class SubComponent extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'component_id', 'sub_component_name', 'status', 'year'
    ];

    public function fetchcrops($cid, $sid){
        return $components = Scheme::where('component_id',$cid)->where('sub_component_id',$sid)->get();
    }
}