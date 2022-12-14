<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tehsil;
use App\Models\City;
use App\Models\Notification;

class AjaxController extends Controller
{
    //
    public function fetchTehsil(Request $request){
        $district_id = $request->district_id;
        $tehsil = Tehsil::where('district_id', $district_id)->get();
        return response()
        ->json(['data' =>$tehsil]);
    }

    public function fetchVillage(Request $request){
        $tehsil_id = $request->tehsil_id;
        $city = City::where('tehsil_id', $tehsil_id)->get();
        return response()
        ->json(['data' =>$city]);
    }

    public function fetchNotification(Request $request){
        $user_id = auth()->user()->id;
        $count = Notification::where('user_id', $user_id)->where('read_status', 0)->count();
        $notification = Notification::where('user_id', $user_id)->orderBy('id', 'DESC')->get();
        return response()->json(['data' => $notification,'count' => $count]);
    }
}
