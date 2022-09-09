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

class SchemeController extends Controller
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
        $scheme_categories = GovtScheme::all();
        return view('admin.pscheme_category.add');
    }

    public function createPSchemeCategory(Request $request){
        $validator = Validator::make($request->all(), [
            'govt_name' => 'required|unique:govt_schemes'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','Parent Scheme Category name should be unique and required!');
        }else{
            $district = GovtScheme::create(['govt_name'=> $request->govt_name]);
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

    //Scheme Component
    public function manageSchemeComponent(Request $request){
        $scheme_sub_categories = Component::select('components.*','scheme_sub_categories.subcategory_name')
        ->join('scheme_sub_categories','components.scheme_sub_category_id','=','scheme_sub_categories.id')
        ->get();

        return view('admin.component.index',['scheme_subcategories' => $scheme_sub_categories]);
    }

    public function editSchemeComponent(Request $request){
        $id = $request->id;
        $scheme_sub_category = Component::find($id);
        $scheme_category = SchemeSubCategory::all();
        return view('admin.component.edit',['scheme_sub_category' => $scheme_sub_category, 'scheme_category' => $scheme_category]);
    }

    public function updateSchemeComponent(Request $request){
        $id = $request->id;
        $scheme_sub_category = Component::where('id',$id)->update(['scheme_sub_category_id'=> $request->scheme_category_id,'component_name'=> $request->category_name]);
        if($scheme_sub_category){
            return back()->with('success','Scheme Component updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteSchemeComponent(Request $request){
        $id = $request->id;
        $tehsil = Component::where('id',$id)->firstorfail()->delete();
        if($tehsil){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addSchemeComponent(Request $request){
        $scheme_categories = SchemeSubCategory::all();
        return view('admin.component.add',['scheme_category' => $scheme_categories]);
    }

    public function createSchemeComponent(Request $request){
        $validator = Validator::make($request->all(), [
            'scheme_category_id'=> 'required',
            'component_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme Component name should be unique and required!');
        }else{
            $tehsil = Component::create(['scheme_sub_category_id' => $request->scheme_category_id,'component_name'=> $request->component_name]);
            if($tehsil){
                return back()->with('success','Scheme Component created successfully!');
            }else{
                return back()->with('error','Something Went Wrong!');
            }
        }        
    }

    //Scheme Sub Component
    public function manageSchemeSubComponent(Request $request){
        $scheme_sub_categories = SubComponent::select('sub_components.*','components.component_name')
        ->join('components','sub_components.component_id','=','components.id')
        ->get();

        return view('admin.sub_component.index',['scheme_subcategories' => $scheme_sub_categories]);
    }

    public function editSchemeSubComponent(Request $request){
        $id = $request->id;
        $scheme_sub_category = SubComponent::find($id);
        $scheme_category = Component::all();
        return view('admin.sub_component.edit',['scheme_sub_category' => $scheme_sub_category, 'scheme_category' => $scheme_category]);
    }

    public function updateSchemeSubComponent(Request $request){
        $id = $request->id;
        $scheme_sub_category = SubComponent::where('id',$id)->update(['component_id' => $request->scheme_category_id,'sub_component_name'=> $request->category_name, 'year' => !empty($request->year)? $request->year : '', 'status' => $request->status]);
        if($scheme_sub_category){
            return back()->with('success','Scheme Sub Component updated successfully!');
        }else{
            return back()->with('error','Something Went Wrong!');
        }        
    }

    public function deleteSchemeSubComponent(Request $request){
        $id = $request->id;
        $tehsil = SubComponent::where('id',$id)->firstorfail()->delete();
        if($tehsil){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function addSchemeSubComponent(Request $request){
        $scheme_categories = Component::all();
        return view('admin.sub_component.add',['scheme_category' => $scheme_categories]);
    }

    public function createSchemeSubComponent(Request $request){
        $validator = Validator::make($request->all(), [
            'scheme_category_id'=> 'required',
            'sub_component_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme Sub Component name should be unique and required!');
        }else{
            $tehsil = SubComponent::create(['component_id' => $request->scheme_category_id,'sub_component_name'=> $request->sub_component_name, 'year' => !empty($request->year)? $request->year : '', 'status' => $request->status]);
            if($tehsil){
                return back()->with('success','Scheme Sub Component created successfully!');
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
        $scheme_category = SchemeCategory::where('id',$scheme->category_id)->get();
        $scheme_subcategory = SchemeSubCategory::where('id',$scheme->scheme_subcategory_id)->get();
        $govt_schemes = GovtScheme::all();
        $components = Component::where('id',$scheme->component_id)->get();
        $subcomponents = SubComponent::where('id',$scheme->sub_component_id)->where('status',"1")->get();

        return view('admin.scheme.edit',['subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes,'scheme' => $scheme, 'scheme_subcategory' => $scheme_subcategory]);
    }

    public function updateScheme(Request $request){
        $id = $request->id;
        if($request->hasFile('scheme_image')){
            $filename = time().$request->scheme_image->getClientOriginalName();
            $request->scheme_image->storeAs('scheme-images',$filename,'public');
            $scheme = Scheme::where('id',$id)->update([
                'units' => $request->units,
                'year' => $request->year,
                'govt_id' => $request->govt_id,
                'category_id'=>$request->scheme_category_id,
                'component_id' => $request->component_id,
                'sub_component_id' => $request->sub_component_id,
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
                'units' => $request->units,
                'year' => $request->year,
                'govt_id' => $request->govt_id,
                'category_id'=>$request->scheme_category_id,
                'component_id' => $request->component_id,
                'sub_component_id' => $request->sub_component_id,
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
        $govt_schemes = GovtScheme::all();
        $scheme_subcategories = SchemeSubCategory::all();
        return view('admin.scheme.add',['scheme_subcategory' => $scheme_subcategories, 'govt_schemes' => $govt_schemes]);
    }

    public function createScheme(Request $request){
        $validator = Validator::make($request->all(), [
            'govt_id'=>'required',
            'scheme_category_id'=>'required',
            'scheme_subcategory_id'=> 'required',
            'scheme_name' => 'required'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Scheme name should be unique and fill required!');
        }else{
            if($request->hasFile('scheme_image')){
                $filename = time().$request->scheme_image->getClientOriginalName();
                $request->scheme_image->storeAs('scheme-images',$filename,'public');
                $scheme = Scheme::create([
                    'units' => $request->units,
                    'year' => $request->year,
                    'govt_id' => $request->govt_id,
                    'category_id'=>$request->scheme_category_id,
                    'component_id' => $request->component_id,
                    'sub_component_id' => $request->sub_component_id,
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

    public function fetchSchemeCategory(Request $request){
        if(!empty($request->id)){
            $scheme = SchemeCategory::where('govt_scheme_id',$request->id)->all();
            return response()
            ->json(['message' => 'success', 'data' => $scheme]);
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }

    public function fetchComponentType(Request $request){
        if(!empty($request->id)){
            $scheme = SchemeSubCategory::where('scheme_category_id',$request->id)->all();
            return response()
            ->json(['message' => 'success', 'data' => $scheme]);
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }

    public function fetchComponent(Request $request){
        if(!empty($request->id)){
            $scheme = Component::where('scheme_sub_category_id',$request->id)->all();
            return response()
            ->json(['message' => 'success', 'data' => $scheme]);
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }
    
    public function fetchSubComponent(Request $request){
        if(!empty($request->id)){
            $scheme = SubComponent::where('component_id',$request->id)->first();
            return response()
            ->json(['message' => 'success', 'data' => $scheme]);
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }
}
