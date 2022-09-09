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
        $scheme_subcategory = SchemeSubCategory::all();
        $govt_schemes = GovtScheme::all();
        $components = Component::all();
        $subcomponents = SubComponent::where('status',"1")->get();

        return view('admin.targetset.edit',['subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes, 'scheme_subcategory' => $scheme_subcategory]);
    }

}
