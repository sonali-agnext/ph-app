<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Farmer;
use App\Models\District;
use App\Models\Tehsil;
use App\Models\City;
use App\Models\ApplicantType;
use App\Models\CasteCategory;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class FarmerController extends Controller
{
    //Farmers
    public function manageFarmers(Request $request){
        $farmers = Farmer::select('farmers.*','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name')
        ->join('cities','farmers.city_id','=','cities.id')
        ->join('districts','farmers.district_id','=','districts.id')
        ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
        ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
        ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
        ->get();

        return view('admin.farmer.index',['farmers' => $farmers]);
    }
    public function editFarmer(Request $request){
        $id = $request->id;
        $farmer = Farmer::find($id);
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        $applicant_types = ApplicantType::all();
        $caste_categories = CasteCategory::all();
        return view('admin.farmer.edit',['farmer' => $farmer, 'cities'=>$cities, 'districts'=>$districts, 'tehsils'=>$tehsils, 'caste_categories' => $caste_categories, 'applicant_types'=>$applicant_types]);
    }

    public function updateFarmer(Request $request){
        $id = $request->id;
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|unique:farmers,mobile_number,'.$id
        ]);
        $mobile_number = $request->mobile_number;
        $language = $request->language;
        $applicant_type_id = $request->applicant_type_id;
        $applicant_name = $request->name;
        $father_husband_name = $request->father_husband_name;
        $gender = $request->gender;
        $resident = $request->resident;
        $aadhar_no = $request->aadhar_number;
        $pan_no = $request->pan_number;
        $caste_category = $request->caste_category_id;
        $state = $request->state;
        $district_id = $request->district_id;
        $tehsil_id = $request->tehsil_id;
        $city_id = $request->city_id;
        $full_address = $request->full_address;
        $postal_code = $request->pin_code;
        $farmer_unique_id = '';
        $farmer = Farmer::find($id);
        if ($validator->fails()) {
            return back()->with('error','Farmer Mobile Number should be unique and required!');
        }else{
        if($request->hasFile('avatar')){            
            $filename = time().$request->avatar->getClientOriginalName();
            $request->avatar->storeAs('images',$filename,'public');
            $district = Farmer::where('id',$id)->update([
                'language'=>$language,
                'applicant_type_id' => $applicant_type_id,
                'name'=> $applicant_name,
                'mobile_number' => $mobile_number,
                'father_husband_name' => $father_husband_name,
                'gender' => $gender, 
                'resident' => $resident, 
                'aadhar_number'=> $aadhar_no, 
                'pan_number'=> $pan_no, 
                'caste_category_id'=> $caste_category, 
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'full_address'=> $full_address, 
                'farmer_unique_id' => $farmer_unique_id,
                'pin_code'=> $postal_code, 
                'avatar' => $filename]);
                if($district){
                    $user=User::where('id',$farmer->user_id)->update(['name'=>$mobile_number]);
                    return back()->with('success','Farmer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }else{
            $district = Farmer::where('id',$id)->update([
                'language'=>$language,
                'applicant_type_id' => $applicant_type_id,
                'name'=> $applicant_name,
                'mobile_number' => $mobile_number,
                'father_husband_name' => $father_husband_name,
                'gender' => $gender, 
                'resident' => $resident, 
                'aadhar_number'=> $aadhar_no, 
                'pan_number'=> $pan_no, 
                'caste_category_id'=> $caste_category, 
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'full_address'=> $full_address, 
                'farmer_unique_id' => $farmer_unique_id,
                'pin_code'=> $postal_code]);
                if($district){
                    $user=User::where('id',$farmer->user_id)->update(['name'=>$mobile_number]);
                    return back()->with('success','Farmer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }
    }       
    }

    public function deleteFarmer(Request $request){
        $id = $request->id;
        $user_id = Farmer::find($id);
        $district = User::where('id',$user_id->user_id)->firstorfail()->delete();
        $district = Farmer::where('id',$id)->firstorfail()->delete();
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function createFarmer(Request $request){
        $validator = Validator::make($request->all(), [
            'mobile_number' => 'required|unique:farmers'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Farmer Mobile Number should be unique and required!');
        }else{
            $mobile_number = $request->mobile_number;
            
            $userFound = User::where('name', $mobile_number)->first();
        
            if(empty($userFound)){
                $user = new User;
                $user->name = $mobile_number;
                $user->email = $mobile_number.'@gmail.com';
                $user->password = Hash::make('phApp@abc');
                $user->role_id = 2;
                if($user->save()){              
                    $language = $request->language;                    
                    $id = $user->id;
                    $applicant_type_id = $request->applicant_type_id;
                    $applicant_name = $request->name;
                    $father_husband_name = $request->father_husband_name;
                    $gender = $request->gender;
                    $resident = $request->resident;
                    $aadhar_no = $request->aadhar_number;
                    $pan_no = $request->pan_number;
                    $caste_category = $request->caste_category_id;
                    $state = $request->state;
                    $district_id = $request->district_id;
                    $tehsil_id = $request->tehsil_id;
                    $city_id = $request->city_id;
                    $full_address = $request->full_address;
                    $postal_code = $request->pin_code;
                    $farmer_unique_id = '';
                    if(!empty($district_id) && !empty($tehsil_id)){ 
                        $district = District::findOrFail($district_id);
                        $tehsil = Tehsil::findOrFail($tehsil_id);
                        $district_two = substr($district->district_name, 0,2);
                        $tehsil_two = substr($tehsil->tehsil_name, 0,2);
                        $farmer_unique_id = 'PU'.$district_two.$tehsil_two;
                    }
                    if($request->hasFile('avatar')){            
                        $filename = time().$request->avatar->getClientOriginalName();
                        $request->avatar->storeAs('images',$filename,'public'); 
                        $farmer = Farmer::create([
                            'user_id'=>$id,
                            'language'=>$language,
                            'applicant_type_id' => $applicant_type_id,
                            'name'=> $applicant_name,
                            'mobile_number' => $mobile_number,
                            'father_husband_name' => $father_husband_name,
                            'gender' => $gender, 
                            'resident' => $resident, 
                            'aadhar_number'=> $aadhar_no, 
                            'pan_number'=> $pan_no, 
                            'caste_category_id'=> $caste_category, 
                            'state'=> $state, 
                            'district_id' => $district_id, 
                            'tehsil_id' => $tehsil_id, 
                            'city_id' => $city_id, 
                            'full_address'=> $full_address, 
                            'farmer_unique_id' => $farmer_unique_id,
                            'pin_code'=> $postal_code, 
                            'avatar' => $filename]);
                    
                        if($farmer){
                            $unique_id= $farmer_unique_id.str_pad($farmer->id, 6, '0', STR_PAD_LEFT);
                            $farmer_unique_id = strtoupper($unique_id);
                            $farmerupdate = Farmer::where('user_id', $id)->update(['farmer_unique_id' => $farmer_unique_id]);
                            
            
                            return back()->with('success','Farmer created successfully!');
                        }else{
                            return back()->with('error','Something Went Wrong!');
                        }           
                    }else{
                        return back()->with('error','Something Went Wrong!');
                    }
                    
                }else{
                    return back()->with('error','Something Went Wrong!');
                }
            }else{
                return back()->with('error','Something Went Wrong!');
            } 
        }   
    }
    public function addFarmer(Request $request){
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        $applicant_types = ApplicantType::all();
        $caste_categories = CasteCategory::all();
        return view('admin.farmer.add',['cities' => $cities, 'districts' => $districts,'tehsils' => $tehsils, 'caste_categories'=>$caste_categories, 'applicant_types' =>$applicant_types]);
    }
}
