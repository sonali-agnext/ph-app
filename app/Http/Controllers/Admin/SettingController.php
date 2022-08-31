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
    

    //parent scheme category
    public function managePSchemeCategory(Request $request){
        $schemecategories = GovtScheme::all();

        return view('admin.pscheme_category.index',['scheme_categories' => $schemecategories]);
    }

    public function editPSchemeCategory(Request $request){
        $id = $request->id;
        $schemecategory = GovtScheme::find($id);
        return view('admin.pscheme_category.edit',['scheme_category' => $schemecategory]);
    }

    public function updatePSchemeCategory(Request $request){
        $id = $request->id;
        $district = GovtScheme::where('id',$id)->update(['govt_name'=> $request->category_name]);
        if($district){
            return back()->with('success','Parent Scheme Category updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deletePSchemeCategory(Request $request){
        $id = $request->id;
        $district = GovtScheme::where('id',$id)->firstorfail()->delete();
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addPSchemeCategory(Request $request){
        return view('admin.scheme_category.add');
    }

    public function createPSchemeCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|unique:govt_schemes'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','Scheme Category name should be unique and required!');
        }else{
            $district = GovtScheme::create(['govt_name'=> $request->category_name]);
            if($district){
                return back()->with('success','Parent Scheme Category created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //Scheme Category
    public function manageSchemeCategory(Request $request){
        $scheme_sub_categories = SchemeCategory::select('scheme_categories.*','govt_schemes.govt_name')
        ->join('govt_schemes','scheme_categories.govt_scheme_id','=','govt_schemes.id')
        ->get();

        return view('admin.scheme_category.index',['scheme_subcategories' => $scheme_sub_categories]);
    }

    public function editSchemeCategory(Request $request){
        $id = $request->id;
        $scheme_sub_category = SchemeCategory::find($id);
        $scheme_category = GovtScheme::all();
        return view('admin.scheme_category.edit',['scheme_sub_category' => $scheme_sub_category, 'scheme_category' => $scheme_category]);
    }

    public function updateSchemeCategory(Request $request){
        $id = $request->id;
        // $scheme_sub_category = SchemeCategory::where('id',$id)->update(['govt_scheme_id	'=> $request->scheme_category_id,'category_name'=> "'".$request->subcategory_name."'"]);
        $scheme_sub_category = SchemeCategory::where('id',$id)->update(['govt_scheme_id'=> $request->scheme_category_id, 'category_name'=> $request->subcategory_name]);
        if($scheme_sub_category){
            return back()->with('success','Scheme Category updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteSchemeCategory(Request $request){
        $id = $request->id;
        $tehsil = SchemeCategory::where('id',$id)->firstorfail()->delete();
        if($tehsil){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addSchemeCategory(Request $request){
        $scheme_categories = GovtScheme::all();
        return view('admin.scheme_category.add',['scheme_category' => $scheme_categories]);
    }

    public function createSchemeCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'scheme_category_id'=> 'required',
            'subcategory_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme Sub Category name should be unique and required!');
        }else{
            $tehsil = SchemeCategory::create(['govt_scheme_id' => $request->scheme_category_id,'category_name'=> $request->subcategory_name]);
            if($tehsil){
                return back()->with('success','Scheme Category created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //Scheme Sub Category
    public function manageSchemeSubCategory(Request $request){
        $scheme_sub_categories = SchemeSubCategory::select('scheme_sub_categories.*','scheme_categories.category_name')
        ->join('scheme_categories','scheme_sub_categories.scheme_category_id','=','scheme_categories.id')
        ->get();

        return view('admin.scheme_subcategory.index',['scheme_subcategories' => $scheme_sub_categories]);
    }

    public function editSchemeSubCategory(Request $request){
        $id = $request->id;
        $scheme_sub_category = SchemeSubCategory::find($id);
        $scheme_category = SchemeCategory::all();
        return view('admin.scheme_subcategory.edit',['scheme_sub_category' => $scheme_sub_category, 'scheme_category' => $scheme_category]);
    }

    public function updateSchemeSubCategory(Request $request){
        $id = $request->id;
        $scheme_sub_category = SchemeSubCategory::where('id',$id)->update(['scheme_category_id'=> $request->scheme_category_id,'subcategory_name'=> $request->subcategory_name]);
        if($scheme_sub_category){
            return back()->with('success','Scheme Sub Category updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteSchemeSubCategory(Request $request){
        $id = $request->id;
        $tehsil = SchemeSubCategory::where('id',$id)->firstorfail()->delete();
        if($tehsil){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addSchemeSubCategory(Request $request){
        $scheme_categories = SchemeCategory::all();
        return view('admin.scheme_subcategory.add',['scheme_category' => $scheme_categories]);
    }

    public function createSchemeSubCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'scheme_category_id'=> 'required',
            'subcategory_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme Sub Category name should be unique and required!');
        }else{
            $tehsil = SchemeSubCategory::create(['scheme_category_id' => $request->scheme_category_id,'subcategory_name'=> $request->subcategory_name]);
            if($tehsil){
                return back()->with('success','Scheme Sub Category created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //Scheme
    public function manageScheme(Request $request){
        $schemes = Scheme::select('schemes.*','scheme_sub_categories.subcategory_name')
        ->join('scheme_sub_categories','schemes.scheme_subcategory_id','=','scheme_sub_categories.id')
        ->get();
        return view('admin.scheme.index',['schemes' => $schemes]);
    }

    public function editScheme(Request $request){
        $id = $request->id;
        $scheme = Scheme::find($id);
        $scheme_subcategory = SchemeSubCategory::all();
        return view('admin.scheme.edit',['scheme' => $scheme, 'scheme_subcategory' => $scheme_subcategory]);
    }

    public function updateScheme(Request $request){
        $id = $request->id;
        if($request->hasFile('scheme_image')){
            $filename = time().$request->scheme_image->getClientOriginalName();
            $request->scheme_image->storeAs('scheme-images',$filename,'public');
            $scheme = Scheme::where('id',$id)->update([
                'scheme_subcategory_id' => $request->scheme_subcategory_id,
                'scheme_name' => $request->scheme_name,
                'subsidy' => $request->subsidy,
                'sector' => json_encode($request->sector),
                'sector_description' => json_encode($request->sector_description),
                'terms' => json_encode($request->terms),
                'cost_norms' => $request->cost_norms,
                'detailed_description' => $request->detailed_description,
                'scheme_image' => $filename,
                'videos' => json_encode($request->video),
                'videos_title' => json_encode($request->title),
            ]);
            if($scheme){
                return back()->with('success','Schemes updated successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }else{
            $scheme = Scheme::where('id',$id)->update([
                'scheme_subcategory_id' => $request->scheme_subcategory_id,
                'scheme_name' => $request->scheme_name,
                'subsidy' => $request->subsidy,
                'sector' => json_encode($request->sector),
                'sector_description' => json_encode($request->sector_description),
                'terms' => json_encode($request->terms),
                'cost_norms' => $request->cost_norms,
                'detailed_description' => $request->detailed_description,
                'videos' => json_encode($request->video),
                'videos_title' => json_encode($request->title),
            ]);
            if($scheme){
                return back()->with('success','Schemes updated successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }       
    }

    public function deleteScheme(Request $request){
        $id = $request->id;
        $scheme = Scheme::where('id',$id)->firstorfail()->delete();
        if($scheme){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addScheme(Request $request){
        $scheme_subcategories = SchemeSubCategory::all();
        return view('admin.scheme.add',['scheme_subcategory' => $scheme_subcategories]);
    }

    public function createScheme(Request $request){
        $validator = Validator::make($request->all(), [
            'scheme_subcategory_id'=> 'required',
            'scheme_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme name should be unique and required!');
        }else{
            if($request->hasFile('scheme_image')){
                $filename = time().$request->scheme_image->getClientOriginalName();
                $request->scheme_image->storeAs('scheme-images',$filename,'public');
                $scheme = Scheme::create([
                    'scheme_subcategory_id' => $request->scheme_subcategory_id,
                    'scheme_name' => $request->scheme_name,
                    'subsidy' => $request->subsidy,
                    'sector' => json_encode($request->sector),
                    'sector_description' => json_encode($request->sector_description),
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                ]);
                if($scheme){
                    return back()->with('success','Schemes created successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }else{
                return back()->with('error','Something Went Wrong!');
            }
            
        }        
    }

}
