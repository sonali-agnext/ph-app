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
        $states = Officer::select('officers.*','users.id as user_id','users.name','users.email')
        ->join('users','users.id','=','officers.user_id')
        ->where('users.role_id',3)
        ->orderBy('farmers.id','DESC')
        ->get();

        return view('admin.state_officer.index',['states' => $states]);
    }

    public function editState(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*', 'users.id as user_id','users.name','users.email','users.password','users.status')
        ->join('users','users.id','=','officers.user_id')
        ->where('officers.id', $id)->first();
        return view('admin.state_officer.edit',['state' => $state]);
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
        
        $ihrm = $request->ihrm;
        $designation = $request->designation;
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
                'ihrm'=> $ihrm, 
                'designation' => $designation,
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
                'ihrm'=> $ihrm, 
                'designation' => $designation,
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
                    $ihrm = $request->ihrm;
                    $designation = $request->designation;
                    
                    if($filename){
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,                             
                            'ihrm'=> $ihrm, 
                            'designation' => $designation,
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
        return view('admin.state_officer.add');
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
        $states = Officer::select('officers.*','users.id as user_id','assign_to_officers.district_id as district_officer_id','users.name','users.email')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('users.role_id',4)
        ->orderBy('farmers.id','DESC')
        ->get();

        return view('admin.district_officer.index',['states' => $states]);
    }

    public function editDistrict(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*','assign_to_officers.district_id as district_officer_id', 'users.id as user_id','users.name','users.email','users.status', 'users.password')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('officers.id', $id)->first();
        $districts = District::all();
        return view('admin.district_officer.edit',['state' => $state,'districts'=>$districts]);
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
        
        $ihrm = $request->ihrm;
        $designation = $request->designation;
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
                'ihrm'=> $ihrm, 
                'designation' => $designation,
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
                'ihrm'=> $ihrm, 
                'designation' => $designation,
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
                    $ihrm = $request->ihrm;
                    $designation = $request->designation;
                    $assign_district_id = $request->assign_district_id;
                    
                    if($filename){
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,                             
                            'ihrm'=> $ihrm, 
                            'designation' => $designation,
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
        $districts = District::all();
        return view('admin.district_officer.add',['districts' => $districts]);
    }

    //manage tehsil
    public static function manageTehsil(Request $request){
        $states = Officer::select('officers.*','users.id as user_id','users.name','assign_to_officers.tehsil_id as tehsil_officer_id','users.email')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('users.role_id',5)
        ->orderBy('farmers.id','DESC')
        ->get();

        return view('admin.tehsil_officer.index',['states' => $states]);
    }

    public function editTehsil(Request $request){
        $id = $request->id;
        $state = Officer::select('officers.*', 'assign_to_officers.tehsil_id as tehsil_officer_id', 'users.id as user_id','users.name','users.email','users.status', 'users.password')
        ->join('users','users.id','=','officers.user_id')
        ->join('assign_to_officers', 'assign_to_officers.officer_id','=','officers.id')
        ->where('officers.id', $id)->first();
        $cities = Tehsil::all();
        return view('admin.tehsil_officer.edit',['state' => $state,'tehsils' => $cities]);
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
        $ihrm = $request->ihrm;
        $designation = $request->designation;
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
                'ihrm'=> $ihrm, 
                'designation' => $designation,
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
                'ihrm'=> $ihrm, 
                'designation' => $designation
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
                    $ihrm = $request->ihrm;
                    $designation = $request->designation;
                    
                    if($request->hasFile('avatar')){            
                        $filename = time().$request->avatar->getClientOriginalName();
                        $request->avatar->storeAs('images',$filename,'public');
                        $farmer = Officer::create([
                            'user_id'=>$id,                            
                            'phone_number' => $mobile_number,
                            'ihrm'=> $ihrm, 
                            'designation' => $designation,
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
        $cities = Tehsil::all();
        return view('admin.tehsil_officer.add',['tehsils' => $cities]);
    }

}
