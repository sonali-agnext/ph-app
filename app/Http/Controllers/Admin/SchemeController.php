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
use App\Models\AppliedScheme;
use App\Models\Notification;
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
        $dpr_upload='';
        $self_upload='';
        if($request->hasFile('dpr_upload')){            
            $dpr_upload = time().$request->dpr_upload->getClientOriginalName();
            $request->dpr_upload->storeAs('scheme-doc',$dpr_upload,'public');
        }

        if($request->hasFile('self_upload')){
            $self_upload = time().$request->self_upload->getClientOriginalName();
            $request->self_upload->storeAs('scheme-doc',$self_upload,'public');
        }

        if($request->hasFile('scheme_image')){            
            $filename = time().$request->scheme_image->getClientOriginalName();
            $request->scheme_image->storeAs('scheme-images',$filename,'public');
            if(!empty($dpr_upload) && !empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'self_upload' => $self_upload,
                    'dpr_upload' => $dpr_upload
                ]);
                if($scheme){
    
                    $targets= TargetState::where('crop_id', $scheme->id)->where('component_type_id', $scheme->scheme_subcategory_id)->where('sub_component_id', $scheme->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"", 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }
            elseif(!empty($dpr_upload) && empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'dpr_upload' => $dpr_upload
                ]);
                if($scheme){
    
                    $targets= TargetState::where('crop_id', $scheme->id)->where('component_type_id', $scheme->scheme_subcategory_id)->where('sub_component_id', $scheme->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"", 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }
            elseif(empty($dpr_upload) && !empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'self_upload' => $self_upload
                ]);
                if($scheme){
    
                    $targets= TargetState::where('crop_id', $scheme->id)->where('component_type_id', $scheme->scheme_subcategory_id)->where('sub_component_id', $scheme->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"", 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }
            else{
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured                   
                ]);
                if($scheme){
    
                    $targets= TargetState::where('crop_id', $scheme->id)->where('component_type_id', $scheme->scheme_subcategory_id)->where('sub_component_id', $scheme->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"", 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }
            
        }else{
            if(!empty($dpr_upload) && !empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'self_upload' => $self_upload,
                    'dpr_upload' => $dpr_upload
                ]);
                if($scheme){
                    $targets= TargetState::where('crop_id', $request->id)->where('component_type_id', $request->scheme_subcategory_id)->where('sub_component_id', $request->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"",'private_remarks'=>"", 'year' =>$request->year]);
                    }else{
                        $target = TargetState::where('crop_id', $request->id)->update(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => $targets->physical_target,'financial_target' => "0",'private_physical_target'=>$targets->private_physical_target, 'remarks'=>$targets->remarks, 'private_remarks'=>$targets->private_remarks, 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }elseif(!empty($dpr_upload) && empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'dpr_upload' => $dpr_upload
                ]);
                if($scheme){
                    $targets= TargetState::where('crop_id', $request->id)->where('component_type_id', $request->scheme_subcategory_id)->where('sub_component_id', $request->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"",'private_remarks'=>"", 'year' =>$request->year]);
                    }else{
                        $target = TargetState::where('crop_id', $request->id)->update(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => $targets->physical_target,'financial_target' => "0",'private_physical_target'=>$targets->private_physical_target, 'remarks'=>$targets->remarks, 'private_remarks'=>$targets->private_remarks, 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }elseif(empty($dpr_upload) && !empty($self_upload)){
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'self_upload' => $self_upload
                ]);
                if($scheme){
                    $targets= TargetState::where('crop_id', $request->id)->where('component_type_id', $request->scheme_subcategory_id)->where('sub_component_id', $request->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"",'private_remarks'=>"", 'year' =>$request->year]);
                    }else{
                        $target = TargetState::where('crop_id', $request->id)->update(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => $targets->physical_target,'financial_target' => "0",'private_physical_target'=>$targets->private_physical_target, 'remarks'=>$targets->remarks, 'private_remarks'=>$targets->private_remarks, 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }
            else{
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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                ]);
                if($scheme){
                    $targets= TargetState::where('crop_id', $request->id)->where('component_type_id', $request->scheme_subcategory_id)->where('sub_component_id', $request->sub_component_id)->first();
    
                    if(empty($targets)){
                        $target = TargetState::create(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"",'private_remarks'=>"", 'year' =>$request->year]);
                    }else{
                        $target = TargetState::where('crop_id', $request->id)->update(['crop_id' => $request->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => $targets->physical_target,'financial_target' => "0",'private_physical_target'=>$targets->private_physical_target, 'remarks'=>$targets->remarks, 'private_remarks'=>$targets->private_remarks, 'year' =>$request->year]);
                    }
                    return back()->with('success','Schemes updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
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
                $dpr_upload = '';
                $self_upload = '';
                if($request->hasFile('dpr_upload')){
                    $dpr_upload = time().$request->dpr_upload->getClientOriginalName();
                    $request->dpr_upload->storeAs('scheme-doc',$filename,'public');
                }

                if($request->hasFile('self_upload')){
                    $self_upload = time().$request->self_upload->getClientOriginalName();
                    $request->self_upload->storeAs('scheme-doc',$filename,'public');
                }

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
                    'public_sector' => ($request->public_sector),
                    'private_sector' => ($request->private_sector),
                    'public_range' => empty($request->public_range)? '0.00': $request->public_range ,
                    'private_range' => empty($request->private_range)? '0.00' : $request->private_range,
                    'terms' => json_encode($request->terms),
                    'cost_norms' => $request->cost_norms,
                    'detailed_description' => $request->detailed_description,
                    'scheme_image' => $filename,
                    'videos' => json_encode($request->video),
                    'videos_title' => json_encode($request->title),
                    'is_featured' => empty($request->is_featured)?"0":$request->is_featured,
                    'dpr_upload' => $dpr_upload,
                    'self_upload' => $self_upload
                ]);
                if($scheme){
                    $target = TargetState::create(['crop_id' => $scheme->id, 'component_type_id' => $request->scheme_subcategory_id,'component_id'=>$request->component_id, 'sub_component_id'=> $request->sub_component_id, 'physical_target' => "0",'financial_target' => "0",'private_physical_target'=>"0", 'remarks'=>"",'private_remarks'=>"", 'year' =>$request->year]);
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
            $scheme = SchemeCategory::where('govt_scheme_id',$request->id)->get();
            if(!empty($scheme)){
                return response()
            ->json(['message' => 'success', 'data' => $scheme]);
            }else{
                return response()
            ->json(['message' => 'error']);
            }
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }

    public function fetchComponentType(Request $request){
        if(!empty($request->id)){
            $scheme = SchemeSubCategory::where('scheme_category_id',$request->id)->get();
            if(!empty($scheme)){
                return response()
            ->json(['message' => 'success', 'data' => $scheme]);
            }else{
                return response()
            ->json(['message' => 'error']);
            }
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }

    public function fetchComponent(Request $request){
        if(!empty($request->id)){
            $scheme = Component::where('scheme_sub_category_id',$request->id)->get();
            if(!empty($scheme)){
                return response()
            ->json(['message' => 'success', 'data' => $scheme]);
            }else{
                return response()
            ->json(['message' => 'error']);
            }
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }
    
    public function fetchSubComponent(Request $request){
        if(!empty($request->id)){
            $scheme = SubComponent::where('component_id',$request->id)->where('year',$request->year)->where('status','1')->get();
            if(!empty($scheme)){
                return response()
            ->json(['message' => 'success', 'data' => $scheme]);
            }else{
                return response()
            ->json(['message' => 'error']);
            }
            
        }else{
            return response()
            ->json(['message' => 'error']);
        }
    }

    public function manageAppliedScheme(Request $request){
        if(auth()->user()->role_id == 4){
            $farmers = AppliedScheme::select('applied_schemes.*','applied_schemes.status as applied_status','applied_schemes.id as apply_id','farmers.*', 'farmers.id as ffarmer_id','schemes.*','schemes.id as sscheme_id','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name', 'users.status','applied_schemes.created_at as acreated_at','applied_schemes.updated_at as aupdated_at')
            ->join('farmers','farmers.id','=','applied_schemes.farmer_id')
            ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
            ->join('cities','farmers.city_id','=','cities.id')
            ->join('users','farmers.user_id','=','users.id')
            ->join('districts','farmers.district_id','=','districts.id')
            ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
            ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
            ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
            ->where('farmers.district_id',auth()->user()->officer()->assigned_district)
            ->get();

            return view('admin.applied_scheme.index',['farmers' => $farmers]);
        }elseif(auth()->user()->role_id == 5){
            $farmers = AppliedScheme::select('applied_schemes.*','applied_schemes.status as applied_status','applied_schemes.id as apply_id','farmers.*', 'farmers.id as ffarmer_id','schemes.*','schemes.id as sscheme_id','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name', 'users.status','applied_schemes.updated_at as aupdated_at','applied_schemes.created_at as acreated_at')
            ->join('farmers','farmers.id','=','applied_schemes.farmer_id')
            ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
            ->join('cities','farmers.city_id','=','cities.id')
            ->join('users','farmers.user_id','=','users.id')
            ->join('districts','farmers.district_id','=','districts.id')
            ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
            ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
            ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
            ->where('farmers.tehsil_id',auth()->user()->officer()->assigned_tehsil)
            ->get();

            return view('admin.applied_scheme.index',['farmers' => $farmers]);
        }else{
            $farmers = AppliedScheme::select('applied_schemes.*','applied_schemes.status as applied_status','applied_schemes.id as apply_id','farmers.*', 'farmers.id as ffarmer_id','schemes.*','schemes.id as sscheme_id','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name', 'users.status','applied_schemes.updated_at as aupdated_at','applied_schemes.created_at as acreated_at')
            ->join('farmers','farmers.id','=','applied_schemes.farmer_id')
            ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
            ->join('cities','farmers.city_id','=','cities.id')
            ->join('users','farmers.user_id','=','users.id')
            ->join('districts','farmers.district_id','=','districts.id')
            ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
            ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
            ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
            ->get();

            return view('admin.applied_scheme.index',['farmers' => $farmers]);
        }
    }

    public function viewAppliedScheme(Request $request){        
        
        $farmers = AppliedScheme::select('applied_schemes.*','applied_schemes.status as applied_status','applied_schemes.id as apply_id','farmers.*','farmer_bank_details.*','farmers.id as ffarmer_id','schemes.*','schemes.id as sscheme_id','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name', 'users.status','applied_schemes.updated_at as aupdated_at','applied_schemes.created_at as acreated_at')
        ->join('farmers','farmers.id','=','applied_schemes.farmer_id')
        ->join('farmer_bank_details','farmer_bank_details.farmer_id','=','applied_schemes.farmer_id')
        ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
        ->join('cities','farmers.city_id','=','cities.id')
        ->join('users','farmers.user_id','=','users.id')
        ->join('districts','farmers.district_id','=','districts.id')
        ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
        ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
        ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
        ->where('applied_schemes.id', $request->id)
        ->first();


        return view('admin.applied_scheme.view',['farmers' => $farmers]);
    }

    public function appliedScheme(Request $request){
        $farmer = AppliedScheme::where('id', $request->id)->first();

        if(!empty($farmer) && $request->accept == 'accept'){
            if($farmer->stage == 'Tehsil'){
                $user = new User;
                $districtInfo =$user->officerdistrict(1);
                $updateFarmer = AppliedScheme::where('id', $request->id)->update(['tehsil_updated'=>date('Y-m-d H:i:s'), 'status'=>'Approved', 'stage' => 'District','attempts' => 0, 'approved_district'=>$districtInfo->officer_id,'district_status' => 'In Progress']);
                if($updateFarmer){
                    $user_id = User::officerdistrict($farmer->district_id);
                        Notification::create([
                            'user_id' => $user_id->id,
                            'message'=>('Application Approved by Tehsil Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Application Approved by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                    return response()
                    ->json(['message' => 'success']);
                }else{
                    return response()
                    ->json(['message' => 'error']);
                } 
            }elseif($farmer->stage == 'District'){
                $updateFarmer = AppliedScheme::where('id', $request->id)->update(['district_updated'=>date('Y-m-d H:i:s'), 'district_status'=>'Approved', 'stage' => 'State','attempts' => 0]);
                if($updateFarmer){
                    $user_id = User::officerdistrict($farmer->district_id);
                        Notification::create([
                            'user_id' => $user_id->id,
                            'message'=>('Application Approved by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Application Approved by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                    return response()
                    ->json(['message' => 'success']);
                }else{
                    return response()
                    ->json(['message' => 'error']);
                } 
            }else{

            }
            
        }else{
            $status = $request->status;
            $reasons = json_encode($request->reason);
            if($farmer->stage == 'Tehsil'){
                if($status == 'Resubmit'){
                    $updateFarmer = AppliedScheme::where('id', $request->id)->update(['tehsil_updated'=>date('Y-m-d H:i:s'), 'status'=>'Resubmit', 'stage' => 'Tehsil','reason' => $reasons,'approved_tehsil' => auth()->user()->user_id,'attempts'=>($farmer->attempts +1)]);
                    
                    if($updateFarmer){
                        Notification::create([
                            'user_id' => $farmer->approved_tehsil,
                            'message'=>('Resubmitted by Tehsil Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Resubmitted by Tehsil Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        return response()
                        ->json(['message' => 'success']);
                    }else{
                        return response()
                        ->json(['message' => 'error']);
                    } 
                }elseif($status == 'Rejected'){
                    $updateFarmer = AppliedScheme::where('id', $request->id)->update(['tehsil_updated'=>date('Y-m-d H:i:s'), 'status'=>'Rejected', 'stage' => 'Tehsil','approved_tehsil' => auth()->user()->user_id,'reason' => $reason]);
                    if($updateFarmer){
                        Notification::create([
                            'user_id' => $farmer->approved_tehsil,
                            'message'=>('Rejected by Tehsil Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Rejected by Tehsil Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        return response()
                        ->json(['message' => 'success']);
                    }else{
                        return response()
                        ->json(['message' => 'error']);
                    } 
                }
            }
            elseif($farmer->stage == 'District'){
                if($status == 'Resubmit'){
                    $updateFarmer = AppliedScheme::where('id', $request->id)->update(['district_updated'=>date('Y-m-d H:i:s'), 'district_status'=>'Resubmit', 'stage' => 'District','district_reason' => $reasons,'approved_district' => auth()->user()->user_id,'attempts'=>($farmer->attempts +1)]);
                    if($updateFarmer){
                        Notification::create([
                            'user_id' => $farmer->approved_district,
                            'message'=>('Resubmitted by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Resubmitted by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        return response()
                        ->json(['message' => 'success']);
                    }else{
                        return response()
                        ->json(['message' => 'error']);
                    } 
                }elseif($status == 'Rejected'){
                    $updateFarmer = AppliedScheme::where('id', $request->id)->update(['district_updated'=>date('Y-m-d H:i:s'), 'district_status'=>'Rejected', 'stage' => 'District','district_reason' => $reason,'approved_district' => auth()->user()->user_id]);
                    if($updateFarmer){
                        Notification::create([
                            'user_id' => $farmer->approved_district,
                            'message'=>('Rejected by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Rejected by District Officer <a href="'.url('/view-applied-scheme',['id'=>$farmer->id]).'">Click to view</a>')
                        ]);
                        return response()
                        ->json(['message' => 'success']);
                    }else{
                        return response()
                        ->json(['message' => 'error']);
                    } 
                }
            }
        }
    } 
}
