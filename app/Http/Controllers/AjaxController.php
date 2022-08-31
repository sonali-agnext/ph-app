<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tehsil;
use App\Models\City;

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
}
