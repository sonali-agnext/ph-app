<?php

namespace App\Http\Controllers\Admin;

use App\Rules\MatchOldPassword;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdminProfile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // public function viewAdminProfile(Request $request){
    //     return view('admin.caste.index');
    // }
    public function viewAdminProfile(Request $request){
        return view('admin.profile.index');
    }

    public function updateAdminProfile(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required'
        ]);
 
        if ($validator->fails()) {
            return back()->with('error','Admin Name and email should be required!');
        }else{
            if($request->hasFile('avatar')){
                
                $filename = time().$request->avatar->getClientOriginalName();                
                $request->avatar->storeAs('images/admin',$filename,'public');
                $profile=AdminProfile::where('user_id', auth()->user()->id)->first();
                if(empty($profile)){
                    $update_profile = AdminProfile::create(['user_id' => auth()->user()->id,'avatar'=> $filename]);
                }else{
                    $update_profile = AdminProfile::where('user_id', auth()->user()->id)->update(['avatar'=> $filename]);
                }                
            }

            $user = User::where('id', auth()->user()->id)->update(['name'=> $request->name, 'email' =>$request->email]);
            if($user){
                return back()->with('success','Profile updated successfully!');
            }else{
                return back()->with('error','Something went wrong!');
            }
        }
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => 'required',
            'new_confirm_password' => 'same:new_password'
        ]);
        if ($validator->fails()) {
            return back()->withInput()->withErrors($validator->messages());
        }else{
            $user = User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);
            if($user){
                return back()->with('success','Password change successfully.');
            }else{
                return back()->with('error','Something went wrong!');
            }
        }
    }
}
