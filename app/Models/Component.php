<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\SubComponent;
use App\Models\Component;

class Component extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'scheme_sub_category_id', 'component_name',
    ];

    //
    public function fetchsubcomponent($id){
        return $components = SubComponent::where('component_id',$id)->get();
    }

    public function fetchcomponent($id){
        return $components = Component::where('scheme_sub_category_id',$id)->get();
    }
}