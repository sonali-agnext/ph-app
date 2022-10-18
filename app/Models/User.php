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

    public function farmer($id)
    {
        $items = DB::table('users')
        ->select('users.*')
        ->join('farmers','officers.user_id','=','users.id')
        ->where('farmers.id',$id)
        ->first();
        return $items;
    } 
}
