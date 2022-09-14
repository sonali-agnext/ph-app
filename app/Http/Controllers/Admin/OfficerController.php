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

class OfficerController extends Controller
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
    public static function manageState(Request $request){
        $states = Farmer::select('farmers.*','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name')
        ->join('cities','farmers.city_id','=','cities.id')
        ->join('districts','farmers.district_id','=','districts.id')
        ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
        ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
        ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
        ->get();

        return view('admin.state_officer.index',['states' => $states]);
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
