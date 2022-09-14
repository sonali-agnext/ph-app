<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Scheme;
use App\Models\Component;
use App\Models\SubComponent;

class SchemeSubCategory extends Model
{
    public $timestamps = true;
    //
    protected $fillable = [
        'scheme_category_id', 'subcategory_name'
    ];

    public function fetchcrops($cid, $year){
        return $components = Scheme::where('id',$cid)->where('year',$year)->where('component_id',null)->where('sub_component_id',null)->where('status','1')->get();
    }

    public function fetchSubSchemeCategory($id){
        return $components = $this->where('id',$id)->first();
    }

    public function fetchComponentName($id){
        return $components = Component::where('id',$id)->first();
    }

    public function fetchSubComponentName($id){
        return $components = SubComponent::where('id',$id)->first();
    }

    public function fetchtargetstate($component_type,$component_id=null,$sub_component_id=null,$crop_id){
        if(empty($component_id) && !empty($sub_component_id)){
            return $components = TargetState::where('component_type_id',$component_type)
                                        ->where('sub_component_id',$sub_component_id)
                                        ->where('component_id',null)
                                        ->where('crop_id',$crop_id)                                        
                                        ->first();
        }elseif(!empty($component_id) && empty($sub_component_id)){
            return $components = TargetState::where('component_type_id',$component_type)
                                        ->where('component_id',$component_id)
                                        ->where('sub_component_id',null)  
                                        ->where('crop_id',$crop_id)                                        
                                        ->first();
        }elseif(empty($component_id) && empty($sub_component_id)){
            $components = TargetState::where('component_type_id',$component_type)
            ->where('crop_id',$crop_id)
            ->where('component_id',null)
            ->where('sub_component_id',null)                                        
            ->first();
            return $components;
        }else{
            return $components = TargetState::where('component_type_id',$component_type)
                                        ->where('component_id',$component_id)
                                        ->where('sub_component_id',$sub_component_id)
                                        ->where('crop_id',$crop_id)                                        
                                        ->first();
        }
    }
}
