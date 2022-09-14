<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CasteCategory;
use App\Models\ApplicantType;
use App\Models\District;
use App\Models\Tehsil;
use App\Models\City;
use App\Models\SchemeCategory;
use App\Models\SchemeSubCategory;
use App\Models\Scheme;
use App\Models\Farmer;
use App\Models\User;
use App\Models\AdminProfile;
use App\Models\GovtScheme;
use App\Models\Component;
use App\Models\SubComponent;
use App\Models\TargetState;
use Illuminate\Support\Facades\Validator;

class SubsidyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }        

    //parent scheme category
    public static function manageStateSubsidy(Request $request){
        $scheme_category = SchemeCategory::all();
        if($request->year){
        $scheme_subcategories = SchemeSubCategory::selectRaw(
            "schemes.*,
            scheme_sub_categories.*,
            schemes.id as scheme_id"
        )
            ->join('schemes', 'schemes.scheme_subcategory_id', '=', 'scheme_sub_categories.id')
            
            ->where('schemes.year',$request->year)
            
            
            ->orderBy('scheme_sub_categories.id')
            ->orderBy('schemes.id')
            // select('schemes.*', 'schemes.id as scheme_id', 'scheme_sub_categories.*')
            // ->join('schemes', 'scheme_sub_categories.id', '=', 'schemes.scheme_subcategory_id')
            // ->where('schemes.status',"1")
            ->get();
        }else{
            $scheme_subcategories = SchemeSubCategory::selectRaw(
                "schemes.*,
                scheme_sub_categories.*,
                schemes.id as scheme_id"
            )
                ->join('schemes', 'schemes.scheme_subcategory_id', '=', 'scheme_sub_categories.id')
               
                ->orderBy('scheme_sub_categories.id')
                ->orderBy('schemes.id')
                // select('schemes.*', 'schemes.id as scheme_id', 'scheme_sub_categories.*')
                // ->join('schemes', 'scheme_sub_categories.id', '=', 'schemes.scheme_subcategory_id')
                // ->where('schemes.status',"1")
                ->get();
        }
        $array_cat = [];
        $new_array = [];
        foreach($scheme_subcategories as $key=>$val){
            if(empty($array_cat)){
                $array_cat['category_id_'.$val->scheme_category_id][0]= $val;
            }else{
                array_push($array_cat['category_id_'.$val->scheme_category_id], $val);
            }            
        }

        $govt_schemes = GovtScheme::all();
        $components = Component::all();
        $subcomponents = SubComponent::where('status',"1")->get();

        return view('admin.targetset.edit',['year'=>$request->year,'subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes, 'scheme_subcategory' => $array_cat]);
    }

    public static function updateStateSubsidy(Request $request){
        // $targets = TargetState::where('id',)->update();
        $all_targets = $request->target_id;
        $all_private_targets = $request->private_target_id;
        $all_remarks = $request->remarks;
        $all_private_remarks = $request->private_remarks;
        $all_physical_target = $request->physical_target;
        $all_private_physical_target=$request->private_physical_target;
        
        foreach($all_targets as $key=> $target){
            $targets = TargetState::where('id',$target)->update(['physical_target'=> $all_physical_target[$key], 'remarks' => $all_remarks[$key]]);
            $privatetargets = TargetState::where('id',$all_private_targets[$key])->update(['private_physical_target'=> $all_private_physical_target[$key],'private_remarks' => $all_private_remarks[$key]]);
        }

        return redirect()->route('manage-subsidy-state')->with('success','Schemes updated successfully!');
        
    }

}
