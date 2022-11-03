<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function officer()
    {
        $items = DB::table('users')
        ->select('users.*', 'officers.id as officer_id' , 'officers.*','assign_to_officers.tehsil_id as assigned_tehsil','assign_to_officers.district_id as assigned_district')
        ->join('officers','officers.user_id','=','users.id')
        ->join('assign_to_officers','assign_to_officers.officer_id','=','officers.id')
        ->where('officers.user_id',auth()->user()->id)
        ->first();
        return $items;
    }

    public function officerdistrict($district_id)
    {
        $items = DB::table('users')
        ->select('users.*', 'officers.id as officer_id' , 'officers.*','assign_to_officers.tehsil_id as assigned_tehsil','assign_to_officers.district_id as assigned_district')
        ->join('officers','officers.user_id','=','users.id')
        ->join('assign_to_officers','assign_to_officers.officer_id','=','officers.id')
        ->where('assign_to_officers.district_id',$district_id)
        ->first();
        return $items;
    }
    public function officertehsil($tehsil_id)
    {
        $items = DB::table('users')
        ->select('users.*', 'officers.id as officer_id' , 'officers.*','assign_to_officers.tehsil_id as assigned_tehsil','assign_to_officers.district_id as assigned_district')
        ->join('officers','officers.user_id','=','users.id')
        ->join('assign_to_officers','assign_to_officers.officer_id','=','officers.id')
        ->where('assign_to_officers.tehsil_id',$tehsil_id)
        ->first();
        return $items;
    }
    public function officerstate()
    {
        $items = DB::table('users')
        ->select('users.*', 'officers.id as officer_id' , 'officers.*','assign_to_officers.tehsil_id as assigned_tehsil','assign_to_officers.district_id as assigned_district')
        ->join('officers','officers.user_id','=','users.id')
        ->where('users.role_id',3)
        ->get();
        return $items;
    }

    public function admin()
    {
        $items = DB::table('users')
        ->select('users.*')
        ->where('users.role_id',1)
        ->first();
        return $items;
    }

    public static function farmer($id)
    {
        $items = DB::table('users')
        ->select('users.*')
        ->join('farmers','farmers.user_id','=','users.id')
        ->where('farmers.id',$id)
        ->first();
        return $items;
    } 

    public static function appliedScheme()
    {
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
            ->where('applied_schemes.district_status','In Progress')
            ->orWhere('applied_schemes.district_status','Resubmit')
            ->whereRaw('DATE("updated_at") = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
            ->get();

            return $farmers;
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
            ->where('applied_schemes.status','In Progress')
            ->orWhere('applied_schemes.status','Resubmit')
            ->whereRaw('DATE("updated_at") = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
            ->get();

            return $farmers;
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
            ->where('applied_schemes.status','In Progress')
            ->orWhere('applied_schemes.status','Resubmit')
            ->orwhere('applied_schemes.district_status','In Progress')
            ->orWhere('applied_schemes.district_status','Resubmit')
            ->whereRaw('DATE("updated_at") = DATE_SUB(CURDATE(), INTERVAL 7 DAY)')
            ->get();

            return $farmers;
        }
    } 
}
