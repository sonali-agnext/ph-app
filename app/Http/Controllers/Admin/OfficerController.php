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
use App\Models\Officer;
use App\Models\AssignToOfficer;
use Illuminate\Support\Facades\Hash;
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

    //manage state
    public static function manageState(Request $request){
        $states = Officer::select('officers.*','users.id as user_id','users.name','users.email','cities.city_name','districts.district_name','tehsils.tehsil_name')
        ->join('users','users.id','=','officers.user_id')
        ->join('cities','officers.city_id','=','cities.id')
        ->join('districts','officers.district_id','=','districts.id')
        ->join('tehsils','officers.tehsil_id','=','tehsils.id')
        ->where('users.role_id',3)
        ->get();

        return view('admin.state_officer.index',['states' => $states]);
    }

    public function editState(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*', 'users.id as user_id','users.name','users.email','users.password','users.status')
        ->join('users','users.id','=','officers.user_id')
        ->where('officers.id', $id)->first();
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.state_officer.edit',['state' => $state, 'cities'=>$cities, 'districts'=>$districts, 'tehsils'=>$tehsils]);
    }

    public function updateState(Request $request){
        $id = $request->id;
        $user_id = $request->user_id;
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user_id
        ]);
        $mobile_number = $request->phone_number;
        $name = $request->name;
        $email = $request->email;
        
        $state = $request->state;
        $district_id = $request->district_id;
        $tehsil_id = $request->tehsil_id;
        $city_id = $request->city_id;
        $full_address = $request->address;
        $postal_code = $request->pincode;
        $farmer_unique_id = '';
        $farmer = Officer::find($id);
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
        if($request->hasFile('avatar')){            
            $filename = time().$request->avatar->getClientOriginalName();
            $request->avatar->storeAs('images',$filename,'public');
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
                'avatar' => $filename
            ]);
                if($district){
                    $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email]);
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }else{
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
            ]);
                if($district){
                    if(!empty($request->password)){
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status, 'password'=>Hash::make($request->password)]);
                    }else{
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status]);
                    }
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }
    }       
    }

    public function createState(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
            $mobile_number = $request->phone_number;
            
            $userFound = User::where('email', $request->email)->first();
            $name = $request->name;
            $email = $request->email;
            if(empty($userFound)){
                $user = new User;
                $user->name = $name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->status = $request->status;
                $user->role_id = 3;
                $filename = '';
                if($request->hasFile('avatar')){            
                    $filename = time().$request->avatar->getClientOriginalName();
                    $request->avatar->storeAs('images',$filename,'public');
                }
                if($user->save()){            
                                       
                    $id = $user->id;                    
                    $state = $request->state;
                    $district_id = $request->district_id;
                    $tehsil_id = $request->tehsil_id;
                    $city_id = $request->city_id;
                    $full_address = $request->address;
                    $postal_code = $request->pincode;
                    
                    if($filename){
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,                             
                            'state'=> $state, 
                            'district_id' => $district_id, 
                            'tehsil_id' => $tehsil_id, 
                            'city_id' => $city_id, 
                            'address'=> $full_address,                             
                            'pincode'=> $postal_code, 
                            'avatar' => $filename]);
                    
                        if($farmer){                            
                            return back()->with('success','State Officer created successfully!');
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
    public function addState(Request $request){
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.state_officer.add',['cities' => $cities, 'districts' => $districts,'tehsils' => $tehsils]);
    }

    public function deleteState(Request $request){
        $id = $request->id;
        $user_id = Officer::find($id);
        $district = User::where('id',$user_id->user_id)->firstorfail()->delete();
        $district = Officer::where('id',$id)->firstorfail()->delete();
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    //manage district
    public static function manageDistrict(Request $request){
        $states = Officer::select('officers.*','users.id as user_id','assign_to_officers.district_id as district_officer_id','users.name','users.email','cities.city_name','districts.district_name','tehsils.tehsil_name')
        ->join('users','users.id','=','officers.user_id')
        ->join('cities','officers.city_id','=','cities.id')
        ->join('districts','officers.district_id','=','districts.id')
        ->join('tehsils','officers.tehsil_id','=','tehsils.id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('users.role_id',4)
        ->get();

        return view('admin.district_officer.index',['states' => $states]);
    }

    public function editDistrict(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*','assign_to_officers.district_id as district_officer_id', 'users.id as user_id','users.name','users.email','users.status', 'users.password')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('officers.id', $id)->first();
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.district_officer.edit',['state' => $state, 'cities'=>$cities, 'districts'=>$districts, 'tehsils'=>$tehsils]);
    }

    public function updateDistrict(Request $request){
        $id = $request->id;
        $user_id = $request->user_id;
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user_id
        ]);
        $mobile_number = $request->phone_number;
        $name = $request->name;
        $email = $request->email;
        
        $state = $request->state;
        $district_id = $request->district_id;
        $tehsil_id = $request->tehsil_id;
        $city_id = $request->city_id;
        $full_address = $request->address;
        $postal_code = $request->pincode;
        $farmer_unique_id = '';
        $farmer = Officer::find($id);
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
        if($request->hasFile('avatar')){            
            $filename = time().$request->avatar->getClientOriginalName();
            $request->avatar->storeAs('images',$filename,'public');
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
                'avatar' => $filename
            ]);
                if($district){
                    if(!empty($request->password)){
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status, 'password'=>Hash::make($request->password)]);
                    }else{
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status]);
                    }
                    $findAssign = AssignToOfficer::where('officer_id',$id);
                    if(empty($findAssign)){
                        $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'district_id'=>$request->assign_district_id]);
                    }else{
                        $assign=AssignToOfficer::where('officer_id', $farmer->id)->update(['district_id'=>$request->assign_district_id]);
                    }
                    
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }else{
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
            ]);
                if($district){
                    if(!empty($request->password)){
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status, 'password'=>Hash::make($request->password)]);
                    }else{
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status]);
                    }
                    $findAssign = AssignToOfficer::where('officer_id',$id);
                    if(empty($findAssign)){
                        $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'district_id'=>$request->assign_district_id]);
                    }else{
                        $assign=AssignToOfficer::where('officer_id', $farmer->id)->update(['district_id'=>$request->assign_district_id]);
                    }
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }
    }       
    }

    public function deleteDistrict(Request $request){
        $id = $request->id;
        $user_id = Officer::find($id);
        $district = User::where('id',$user_id->user_id)->firstorfail()->delete();
        $district = Officer::where('id',$id)->firstorfail()->delete();
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function createDistrict(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
            $mobile_number = $request->phone_number;
            
            $userFound = User::where('email', $request->email)->first();
            $name = $request->name;
            $email = $request->email;
            if(empty($userFound)){
                $user = new User;
                $user->name = $name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->status = $request->status;
                $user->role_id = 4;
                $filename = '';
                if($request->hasFile('avatar')){            
                    $filename = time().$request->avatar->getClientOriginalName();
                    $request->avatar->storeAs('images',$filename,'public');
                }
                if($user->save()){            
                                       
                    $id = $user->id;                    
                    $state = $request->state;
                    $district_id = $request->district_id;
                    $tehsil_id = $request->tehsil_id;
                    $city_id = $request->city_id;
                    $full_address = $request->address;
                    $postal_code = $request->pincode;
                    $assign_district_id = $request->assign_district_id;
                    
                    if($filename){
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,                             
                            'state'=> $state, 
                            'district_id' => $district_id, 
                            'tehsil_id' => $tehsil_id, 
                            'city_id' => $city_id, 
                            'address'=> $full_address,                             
                            'pincode'=> $postal_code, 
                            'avatar' => $filename]);
                    
                        if($farmer){
                            $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'district_id'=>$assign_district_id]);
                            return back()->with('success','District Officer created successfully!');
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
    public function addDistrict(Request $request){
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.district_officer.add',['cities' => $cities, 'districts' => $districts,'tehsils' => $tehsils]);
    }

    //manage tehsil
    public static function manageTehsil(Request $request){
        $states = Officer::select('officers.*','users.id as user_id','users.name','assign_to_officers.tehsil_id as tehsil_officer_id','users.email','cities.city_name','districts.district_name','tehsils.tehsil_name')
        ->join('users','users.id','=','officers.user_id')
        ->join('cities','officers.city_id','=','cities.id')
        ->join('districts','officers.district_id','=','districts.id')
        ->join('tehsils','officers.tehsil_id','=','tehsils.id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('users.role_id',5)
        ->get();

        return view('admin.tehsil_officer.index',['states' => $states]);
    }

    public function editTehsil(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*', 'assign_to_officers.tehsil_id as tehsil_officer_id', 'users.id as user_id','users.name','users.email','users.status', 'users.password')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('officers.id', $id)->first();
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.tehsil_officer.edit',['state' => $state, 'cities'=>$cities, 'districts'=>$districts, 'tehsils'=>$tehsils]);
    }

    public function updateTehsil(Request $request){
        $id = $request->id;
        $user_id = $request->user_id;
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users,email,'.$user_id
        ]);
        $mobile_number = $request->phone_number;
        $name = $request->name;
        $email = $request->email;
        
        $state = $request->state;
        $district_id = $request->district_id;
        $tehsil_id = $request->tehsil_id;
        $city_id = $request->city_id;
        $full_address = $request->address;
        $postal_code = $request->pincode;
        $farmer_unique_id = '';
        $farmer = Officer::find($id);
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
        if($request->hasFile('avatar')){            
            $filename = time().$request->avatar->getClientOriginalName();
            $request->avatar->storeAs('images',$filename,'public');
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
                'avatar' => $filename
            ]);
                if($district){
                    if(!empty($request->password)){
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status, 'password'=>Hash::make($request->password)]);
                    }else{
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status]);
                    }
                    $findAssign = AssignToOfficer::where('officer_id',$id);
                    if(empty($findAssign)){
                        $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'tehsil_id'=>$request->assign_tehsil_id]);
                    }else{
                        $assign=AssignToOfficer::where('officer_id', $farmer->id)->update(['tehsil_id'=>$request->assign_district_id]);
                    }
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }else{
            $district = Officer::where('id',$id)->update([
                'phone_number' => $mobile_number,                
                'state'=> $state, 
                'district_id' => $district_id, 
                'tehsil_id' => $tehsil_id, 
                'city_id' => $city_id, 
                'address'=> $full_address, 
                'pincode'=> $postal_code, 
            ]);
                if($district){
                    if(!empty($request->password)){
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status, 'password'=>Hash::make($request->password)]);
                    }else{
                        $user=User::where('id',$farmer->user_id)->update(['name'=>$name, 'email' => $email, 'status'=> $request->status]);
                    }
                    $findAssign = AssignToOfficer::where('officer_id',$farmer->id);

                    if(empty($findAssign)){
                        $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'tehsil_id'=>$request->assign_tehsil_id]);
                    }else{
                        $assign=AssignToOfficer::where('officer_id', $farmer->id)->update(['tehsil_id'=>$request->assign_tehsil_id]);
                    }
                    return back()->with('success','Officer updated successfully!');
                }else{
                    return back()->with('error','Something Went Wrong!');
                } 
        }
    }       
    }

    public function deleteTehsil(Request $request){
        $id = $request->id;
        $user_id = Officer::find($id);
        $district = User::where('id',$user_id->user_id)->firstorfail()->delete();
        $district = Officer::where('id',$id)->firstorfail()->delete();
        if($district){
            return response()
            ->json(['message' => 'success']);
        }else{
            return response()
            ->json(['message' => 'error']);
        }        
    }

    public function createTehsil(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|unique:users'
        ]);
        
        if ($validator->fails()) {
            return back()->with('error','Email should be unique and required!');
        }else{
            $mobile_number = $request->phone_number;
            
            $userFound = User::where('email', $request->email)->first();
            $name = $request->name;
            $email = $request->email;
            if(empty($userFound)){
                $user = new User;
                $user->name = $name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->status = $request->status;
                $user->role_id = 5;
                if($user->save()){            
                                       
                    $id = $user->id;                    
                    $state = $request->state;
                    $district_id = $request->district_id;
                    $tehsil_id = $request->tehsil_id;
                    $city_id = $request->city_id;
                    $full_address = $request->address;
                    $postal_code = $request->pincode;
                    
                    if($request->hasFile('avatar')){            
                        $filename = time().$request->avatar->getClientOriginalName();
                        $request->avatar->storeAs('images',$filename,'public');
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,                             
                            'state'=> $state, 
                            'district_id' => $district_id, 
                            'tehsil_id' => $tehsil_id, 
                            'city_id' => $city_id, 
                            'address'=> $full_address,                             
                            'pincode'=> $postal_code, 
                            'avatar' => $filename]);
                    
                        if($farmer){
                            $assign=AssignToOfficer::create(['officer_id'=> $farmer->id,'tehsil_id'=>$request->assign_tehsil_id]);
                            return back()->with('success','Tehsil Officer created successfully!');
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
    public function addTehsil(Request $request){
        $cities = City::all();
        $districts = District::all();
        $tehsils = Tehsil::all();
        return view('admin.tehsil_officer.add',['cities' => $cities, 'districts' => $districts,'tehsils' => $tehsils]);
    }

}
