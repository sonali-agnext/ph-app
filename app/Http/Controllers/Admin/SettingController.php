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
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
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
    //caste category
    public function manageCasteCategory(Request $request){
        $castes = CasteCategory::all();
        return view('admin.caste.index',['castes' => $castes]);
    }

    public function editCasteCategory(Request $request){
        $id = $request->id;
        $caste = CasteCategory::find($id);
        return view('admin.caste.edit',['caste' => $caste]);
    }

    public function updateCasteCategory(Request $request){
        $id = $request->id;
        $castes = CasteCategory::where('id',$id)->update(['caste_name'=> $request->caste_name]);
        if($castes){
            return back()->with('success','Caste updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteCasteCategory(Request $request){
        $id = $request->id;
        $castes = CasteCategory::where('id',$id)->firstorfail()->delete();
        if($castes){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addCasteCategory(Request $request){
        return view('admin.caste.add');
    }

    public function createCasteCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'caste_name' => 'required|unique:caste_categories'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','Caste name should be unique and required!');
        }else{
            $castes = CasteCategory::create(['caste_name'=> $request->caste_name]);
            if($castes){
                return back()->with('success','Caste created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //applicant type
    public function manageAplicantType(Request $request){
        $applicants = ApplicantType::all();

        return view('admin.applicant.index',['applicants' => $applicants]);
    }

    public function editAplicantType(Request $request){
        $id = $request->id;
        $applicant = ApplicantType::find($id);
        return view('admin.applicant.edit',['applicant' => $applicant]);
    }

    public function updateAplicantType(Request $request){
        $id = $request->id;
        $applicant = ApplicantType::where('id',$id)->update(['applicant_type_name'=> $request->applicant_type_name]);
        if($applicant){
            return back()->with('success','Applicant Type updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteAplicantType(Request $request){
        $id = $request->id;
        $applicant = ApplicantType::where('id',$id)->firstorfail()->delete();
        if($applicant){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addAplicantType(Request $request){
        return view('admin.applicant.add');
    }

    public function createAplicantType(Request $request){
        $validator = Validator::make($request->all(), [
            'applicant_type_name' => 'required|unique:applicant_types'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','Applicant Type name should be unique and required!');
        }else{
            $applicant = ApplicantType::create(['applicant_type_name'=> $request->applicant_type_name]);
            if($applicant){
                return back()->with('success','Applicant Type created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //district
    public function manageDistrict(Request $request){
        $districts = District::all();

        return view('admin.district.index',['districts' => $districts]);
    }

    public function editDistrict(Request $request){
        $id = $request->id;
        $district = District::find($id);
        return view('admin.district.edit',['district' => $district]);
    }

    public function updateDistrict(Request $request){
        $id = $request->id;
        $district = District::where('id',$id)->update(['district_name'=> $request->district_name]);
        if($district){
            return back()->with('success','District updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteDistrict(Request $request){
        $id = $request->id;
        $district = District::where('id',$id)->firstorfail()->delete();
        $districts = Tehsil::where('district_id', $id)->get();
        if(!empty($districts)){
            foreach($districts as $district){
                $tehsil = Tehsil::where('id', $district->id)->delete();
                $city = City::where('tehsil_id',$district->id)->firstorfail()->delete();
            }
        }
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addDistrict(Request $request){
        return view('admin.district.add');
    }

    public function createDistrict(Request $request){
        $validator = Validator::make($request->all(), [
            'district_name' => 'required|unique:districts'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','District name should be unique and required!');
        }else{
            $district = District::create(['district_name'=> $request->district_name]);
            if($district){
                return back()->with('success','District created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //tehsil
    public function manageTehsil(Request $request){
        $tehsils = Tehsil::select('tehsils.*','districts.district_name')
        ->join('districts','tehsils.district_id','=','districts.id')
        ->get();

        return view('admin.tehsil.index',['tehsils' => $tehsils]);
    }

    public function editTehsil(Request $request){
        $id = $request->id;
        $tehsil = Tehsil::find($id);
        $district = District::all();
        return view('admin.tehsil.edit',['tehsil' => $tehsil, 'district' => $district]);
    }

    public function updateTehsil(Request $request){
        $id = $request->id;
        $tehsil = Tehsil::where('id',$id)->update(['district_id'=> $request->district_id,'tehsil_name'=> $request->tehsil_name]);
        if($tehsil){
            return back()->with('success','Block updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteTehsil(Request $request){
        $id = $request->id;
        $tehsil = Tehsil::where('id',$id)->firstorfail()->delete();
        $districts = City::where('tehsil_id', $id)->get();
        if(!empty($districts)){
            foreach($districts as $district){
                $tehsil = City::where('id', $district->id)->delete();
            }
        }
        if($tehsil){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addTehsil(Request $request){
        $district = District::all();
        return view('admin.tehsil.add',['district' => $district]);
    }

    public function createTehsil(Request $request){
        $validator = Validator::make($request->all(), [
            'district_id'=> 'required',
            'tehsil_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Block name should be unique and required!');
        }else{
            $tehsil = Tehsil::create(['district_id' => $request->district_id,'tehsil_name'=> $request->tehsil_name]);
            if($tehsil){
                return back()->with('success','Block created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //city
    public function manageCity(Request $request){
        $cities = City::select('cities.*','tehsils.tehsil_name')
        ->join('tehsils','cities.tehsil_id','=','tehsils.id')
        ->get();

        return view('admin.city.index',['cities' => $cities]);
    }

    public function editCity(Request $request){
        $id = $request->id;
        $city = City::find($id);
        $tehsil = Tehsil::all();
        return view('admin.city.edit',['city' => $city, 'tehsil' => $tehsil]);
    }

    public function updateCity(Request $request){
        $id = $request->id;
        $city = City::where('id',$id)->update(['tehsil_id'=> $request->tehsil_id,'city_name'=> $request->city_name]);
        if($city){
            return back()->with('success','Village/City updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteCity(Request $request){
        $id = $request->id;
        $city = City::where('id',$id)->firstorfail()->delete();
        if($city){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addCity(Request $request){
        $tehsil = Tehsil::all();
        return view('admin.city.add',['tehsil' => $tehsil]);
    }

    public function createCity(Request $request){
        $validator = Validator::make($request->all(), [
            'tehsil_id'=> 'required',
            'city_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Village/City name should be unique and required!');
        }else{
            $city = City::create(['tehsil_id' => $request->tehsil_id,'city_name'=> $request->city_name]);
            if($city){
                return back()->with('success','Village/City created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

}
