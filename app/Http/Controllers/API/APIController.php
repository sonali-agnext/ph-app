<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Farmer;
use App\Models\District;
use App\Models\Tehsil;
use App\Models\City;
use App\Models\ApplicantType;
use App\Models\CasteCategory;
use App\Models\PersonalAccessToken;
use App\Models\Scheme;
use App\Models\SchemeCategory;
use App\Models\SchemeSubCategory;
use App\Models\GovtScheme;
use App\Models\MarketPrice;
use App\Models\Component;
use App\Models\SubComponent;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Models\YoutubeVideo;

class APIController extends Controller
{
    public function compareToken($bearer){
        [$id, $token] = explode('|', $bearer, 2);
        $accessToken = PersonalAccessToken::find($id);
        if(empty($accessToken)){
            return false;
        }else{
            return true;
        }
    }

    public function alreadyExists(Request $request){
        try{
            $mobile_number = $request->mobile_number;
            $userFound = User::where('name', $mobile_number)->first();
            if(empty($userFound)){
                return response()
                    ->json(['message' => ''], 200);
            }else{
                if($userFound->status){
                    return response()
                    ->json(['message' => 'Mobile Number Already Exists!'], 401);
                }else{
                    return response()
                    ->json(['message' => 'Your account is inactive. Please contact to administrator!'], 401);
                }
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function register(Request $request){

            $mobile_number = $request->mobile_number;
            $language = $request->language;
            $role_id = 2;

            $userFound = User::where('name', $mobile_number)->first();
            
            if(empty($userFound)){
                $user = new User;
                $user->name = $mobile_number;
                $user->email = $mobile_number.'@gmail.com';
                $user->password = Hash::make('phApp@abc');
                $user->status = 1;
                $user->role_id = $role_id;
                if($user->save()){
                    $farmer = new Farmer;
                    $farmer->mobile_number = $mobile_number;
                    $farmer->applicant_type_id=1;
                    $farmer->language = $language;
                    $farmer->name = 'null';
                    $farmer->father_husband_name = 'null';
                    $farmer->gender = 'null';
                    $farmer->resident = 'null';
                    $farmer->aadhar_number = 'null';
                    $farmer->pan_number = 'null';
                    $farmer->caste_category_id = 1;
                    $farmer->state = 'null';
                    $farmer->district_id = 1;
                    $farmer->tehsil_id = 1;
                    $farmer->city_id = 1;
                    $farmer->farmer_unique_id = 'null';
                    $farmer->full_address = 'null';
                    $farmer->pin_code ='null';
                    $farmer->avatar ='null';
                    $farmer->user_id = $user->id;
                    $farmer->save();
                    return response()
                    ->json(['message' => 'Registered Successfully!!','token' => $user->createToken("auth_token")->plainTextToken,'token_type' => 'Bearer', 'user_id' => $user->id], 200);
                }else{
                    return response()
                    ->json(['message' => 'Something Went Wrong'], 401);
                }
            }else{
                return response()
                    ->json(['message' => 'Mobile Number Already Exists!'], 401);
            }
    }

    public function login(Request $request){
        try{
            $mobile_number = $request->mobile_number;
            $userFound = User::where('name', $mobile_number)->first();
            if($userFound){
                if(!$userFound->status){
                    return response()
                    ->json(['message' => 'Mobile Number not exists!'], 401);
                }else{
                    $farmerFound = Farmer::where('mobile_number', $mobile_number)->where('user_id', $userFound->id)->first();
                    return response()
                    ->json(['message' => 'Login Successfully!!','token' => $userFound->createToken("auth_token")->plainTextToken,'token_type' => 'Bearer', 'user_id' => $userFound->id, 'userInfo' => $farmerFound], 200);
                }
            }else{
                return response()
                ->json(['message' => 'Mobile Number not exists!'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function logout(Request $request){
        try{
            $bearer = $request->token;
            [$id, $token] = explode('|', $bearer, 2);
            $accessToken = PersonalAccessToken::where('id', $id)->delete();
            if($accessToken){
                return response()
                    ->json(['message' => 'Logout Successfully'], 200);
            }else{
                return response()
                ->json(['message' => 'Token Invalid'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function district(Request $request){ 
        try{
            $district_data = $this->fetchDistrict();  

            return response()
            ->json(['message' => 'District, Tehsil and Village/City', 'data' => $district_data], 200);
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function fetchDistrict(){
        $districts = District::all();

        $all_district = [];
        if(!empty($districts)){
            foreach($districts as $key => $district){
                $all_district['district'][$key]['district_id'] = $district->id;
                $all_district['district'][$key]['district_name'] = $district->district_name;
                $tehsils = Tehsil::where('district_id', $district->id)->get();
                if(!empty($tehsils)){
                    foreach($tehsils as $tkey => $tehsil){
                        $all_district['district'][$key]['tehsil'][$tkey]['tehsil_id'] = $tehsil->id;
                        $all_district['district'][$key]['tehsil'][$tkey]['tehsil_name'] = $tehsil->tehsil_name;

                        $villages = City::where('tehsil_id', $tehsil->id)->get();
                        if(!empty($villages)){
                            foreach($villages as $ckey => $village){
                                $all_district['district'][$key]['tehsil'][$tkey]['city'][$ckey]['city_id'] = $village->id;
                                $all_district['district'][$key]['tehsil'][$tkey]['city'][$ckey]['city_name'] = $village->city_name;
                            }
                        }
                    }
                }
            }
        }
        $all_district['applicantType']= $this->applicantType();
        $all_district['CasteCategory']= $this->CasteCategory();
        return $all_district;
    }

    public function applicantType(){
        $applicants = ApplicantType::select('id','applicant_type_name')->get();
        return $applicants;
        // return response()
        //     ->json(['message' => 'Applicant Type', 'data' => $applicants], 200);
    }

    public function CasteCategory(){
        $castes = CasteCategory::select('id','caste_name')->get();
        return $castes;
        // return response()
        //     ->json(['message' => 'Caste Category', 'data' => $castes], 200);
    }

    public function fetchProfile(Request $request){
        try{        
            $id = $request->user_id;
            
            if(empty($id)){
                return response()
                ->json(['message' => 'Provide User ID'], 401);
            }
            $user = Farmer::select('farmers.*','districts.district_name')->join('districts','farmers.district_id','=','districts.id')->where('user_id', $id)->first();
            if($user){
                    return response()
                ->json(['message' => 'User Information','media_url'=>'storage/images/' ,'data'=> $user], 200);
            }else{
                return response()
                ->json(['message' => 'Something Went Wrong'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function personalInfoUpdate(Request $request){
        try{
            $id = $request->user_id;
            $applicant_type_id = $request->applicant_type_id;
            $applicant_name = $request->applicant_name;
            $father_husband_name = $request->father_husband_name;
            $gender = $request->gender;
            $resident = $request->resident;
            $aadhar_no = $request->aadhar_no;
            $pan_no = $request->pan_no;
            $caste_category = $request->caste_category_id;
            $farmer_unique_id = '';
            if(!empty($id)){
                if($request->hasFile('avatar')){
                    $filename = time().$request->avatar->getClientOriginalName();
                    $request->avatar->storeAs('images',$filename,'public');
                    $farmer_profile = Farmer::where('user_id', $id)->update(['applicant_type_id' => $applicant_type_id,'name'=> $applicant_name, 'father_husband_name' => $father_husband_name, 'gender' => $gender, 'resident' => $resident, 'aadhar_number'=> $aadhar_no, 'pan_number'=> $pan_no,'caste_category_id'=> $caste_category,'avatar' => $filename]);
                }else{
                    $farmer_profile = Farmer::where('user_id', $id)->update(['applicant_type_id' => $applicant_type_id,'name'=> $applicant_name, 'father_husband_name' => $father_husband_name, 'gender' => $gender, 'resident' => $resident, 'aadhar_number'=> $aadhar_no, 'pan_number'=> $pan_no, 'caste_category_id'=> $caste_category]);
                }            
            
                if(!empty($farmer_profile)){
                    $user = Farmer::where('user_id', $id)->first();
                    if(!empty($user->farmer_unique_id)){ 
                        $farmer_unique_id = $user->farmer_unique_id;
                    }
                    return response()
                    ->json(['message' => 'Profile Updated Successfully','media_url'=>'storage/images/' ,'farmer_unique_id' => $farmer_unique_id,'data'=> $user], 200);
                }else{
                    return response()
                    ->json(['message' => 'Something Went Wrong'], 401);
                }
            }else{
                return response()
                    ->json(['message' => 'Please provide User ID'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
        
    }

    public function AddressUpdate(Request $request){
        try{
            $id = $request->user_id;
            $state = $request->state;
            $district_id = $request->district_id;
            $tehsil_id = $request->tehsil_id;
            $city_id = $request->city_id;
            $full_address = $request->full_address;
            $postal_code = $request->postal_code;
            $farmer_unique_id = '';
            if(!empty($district_id) && !empty($tehsil_id)){ 
                $district = District::findOrFail($district_id);
                $tehsil = Tehsil::findOrFail($tehsil_id);
                $district_two = substr($district->district_name, 0,2);
                $tehsil_two = substr($tehsil->tehsil_name, 0,2);
                $farmer_unique_id = 'PU'.$district_two.$tehsil_two;
            }
            if(!empty($id)){
                $farmer_profile = Farmer::where('user_id', $id)->update(['state'=> $state, 'district_id' => $district_id, 'tehsil_id' => $tehsil_id, 'city_id' => $city_id, 'full_address'=> $full_address, 'pin_code'=> $postal_code]);
            
            
                if(!empty($farmer_profile)){
                    $user = Farmer::where('user_id', $id)->first();
                    if(!empty($user->farmer_unique_id)){
                        if($user->farmer_unique_id == 'null') {
                            $farmer_un_id = Farmer::where('user_id', $id)->update(['farmer_unique_id'=> $farmer_unique_id]);
                        }else{
                        $farmer_unique_id = $user->farmer_unique_id;}
                    }
                    return response()
                    ->json(['message' => 'Address Updated Successfully', 'farmer_unique_id' => $farmer_unique_id,'data'=> $user], 200);
                }else{
                    return response()
                    ->json(['message' => 'Something Went Wrong'], 401);
                }
            }else{
                return response()
                    ->json(['message' => 'Please provide User ID'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function profileUpdate(Request $request){
        try{
            $id = $request->user_id;
            $applicant_type_id = $request->applicant_type_id;
            $applicant_name = $request->applicant_name;
            $father_husband_name = $request->father_husband_name;
            $gender = $request->gender;
            $resident = $request->resident;
            $aadhar_no = $request->aadhar_no;
            $pan_no = $request->pan_no;
            $caste_category = $request->caste_category_id;
            $state = $request->state;
            $district_id = $request->district_id;
            $tehsil_id = $request->tehsil_id;
            $city_id = $request->city_id;
            $full_address = $request->full_address;
            $postal_code = $request->postal_code;
            $farmer_unique_id = '';
            Log::debug(json_encode($request));
            if(!empty($district_id) && !empty($tehsil_id)){ 
                $district = District::findOrFail($district_id);
                $tehsil = Tehsil::findOrFail($tehsil_id);
                $district_two = substr($district->district_name, 0,2);
                $tehsil_two = substr($tehsil->tehsil_name, 0,2);
                $farmer_unique_id = 'PU'.$district_two.$tehsil_two;
            }
            if(!empty($id)){
                if($request->hasFile('avatar')){
                    $filename = time().$request->avatar->getClientOriginalName();
                    $request->avatar->storeAs('images',$filename,'public');
                    $farmer_profile = Farmer::where('user_id', $id)->update(['applicant_type_id' => $applicant_type_id,'name'=> $applicant_name, 'father_husband_name' => $father_husband_name, 'gender' => $gender, 'resident' => $resident, 'aadhar_number'=> $aadhar_no, 'pan_number'=> $pan_no, 'caste_category_id'=> $caste_category, 'state'=> $state, 'district_id' => $district_id, 'tehsil_id' => $tehsil_id, 'city_id' => $city_id, 'full_address'=> $full_address, 'pin_code'=> $postal_code, 'avatar' => $filename]);
                }else{
                    $farmer_profile = Farmer::where('user_id', $id)->update(['applicant_type_id' => $applicant_type_id,'name'=> $applicant_name, 'father_husband_name' => $father_husband_name, 'gender' => $gender, 'resident' => $resident, 'aadhar_number'=> $aadhar_no, 'pan_number'=> $pan_no, 'caste_category_id'=> $caste_category, 'state'=> $state, 'district_id' => $district_id, 'tehsil_id' => $tehsil_id, 'city_id' => $city_id, 'full_address'=> $full_address, 'pin_code'=> $postal_code]);
                }            
            
                if(!empty($farmer_profile)){
                    $user = Farmer::select('farmers.*','districts.district_name')->join('districts','farmers.district_id','=','districts.id')->where('user_id', $id)->first();
                    if(empty($user->farmer_unique_id)){ 
                        $unique_id= $farmer_unique_id.str_pad($user->id, 6, '0', STR_PAD_LEFT);
                        $farmer_unique_id = strtoupper($unique_id);
                        $farmer_id = Farmer::where('user_id', $id)->update(['farmer_unique_id' => $farmer_unique_id]);
                    }else{
                        if($user->farmer_unique_id == 'null') {
                                $unique_id= $farmer_unique_id.str_pad($user->id, 6, '0', STR_PAD_LEFT);
                                $farmer_unique_id = strtoupper($unique_id);
                                $farmer_id = Farmer::where('user_id', $id)->update(['farmer_unique_id' => $farmer_unique_id]);
                        }else{
                            $farmer_unique_id = $user->farmer_unique_id;
                        }
                    }
                    return response()
                    ->json(['message' => 'Profile Updated Successfully', 'media_url'=>'storage/images/', 'farmer_unique_id' => $farmer_unique_id,'data'=> $user], 200);
                }else{
                    return response()
                    ->json(['message' => 'Something Went Wrong'], 401);
                }
            }else{
                return response()
                    ->json(['message' => 'Please provide User ID'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function languageUpdate(Request $request){
        try{
            $id = $request->user_id;        
            $language = $request->language;
            if(!empty($id)){
                $farmer_profile = Farmer::where('user_id', $id)->update(['language' => $language]);
            
                if(!empty($farmer_profile)){
                    return response()
                    ->json(['message' => 'Language Updated Successfully'], 200);
                }else{
                    return response()
                    ->json(['message' => 'Something Went Wrong'], 401);
                }
            }else{
                return response()
                    ->json(['message' => 'Please provide User ID'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Something Went Wrong!'], 401);
        }
    }

    public function fetchSchemes(Request $request){
        // try{
            $schemes_data = $this->fetchAllSchemes();  

            return response()
            ->json(['message' => 'Schemes/ Scheme Category / Component Type/ Component/ Sub Component', 'media_url' => 'storage/scheme-images/','data' => $schemes_data], 200);
        // }catch (\Exception $e) {
        //     return response()
        //             ->json(['message' => 'Data not processed!'], 401);
        // }
    }

    public function fetchSubSchemes(){
        $all_govts = GovtScheme::all();        

        $all_schemes = [];
        if(!empty($all_govts)){
            foreach($all_govts as $gkey => $all_govt){
                $all_schemes[$gkey]['govt_scheme_cat_id'] = $all_govt->id;
                $all_schemes[$gkey]['govt_scheme_cat_name'] = $all_govt->govt_name;
                $scheme_categories = SchemeCategory::where('govt_scheme_id', $all_govt->id)->get();
                foreach($scheme_categories as $key => $scheme_cat){
                    $all_schemes[$gkey]['cat'][$key]['scheme_cat_id'] = $scheme_cat->id;
                    $all_schemes[$gkey]['cat'][$key]['scheme_cat_name'] = $scheme_cat->category_name;
                    $scheme_subcategories = SchemeSubCategory::where('scheme_category_id', $scheme_cat->id)->get();
                    if(!empty($scheme_subcategories)){
                        foreach($scheme_subcategories as $subkey => $scheme_subcategory){
                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_id'] = $scheme_subcategory->id;
                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_name'] = $scheme_subcategory->subcategory_name;

                            $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->get();
                            if(!empty($schemes)){
                                foreach($schemes as $ckey => $scheme){
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['subsidy'] = $scheme->subsidy;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['terms'] = json_decode($scheme->terms);
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                    $all_videos = [];
                                    if(!empty($scheme->videos)){
                                        $videos = json_decode($scheme->videos);
                                        $video_titles = json_decode($scheme->videos_title);
                                        
                                        foreach($videos as $jsv => $video){
                                            $all_videos[$jsv]['video'] = $video;
                                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                        }
                                    
                                    }
                                    $all_sector = [];
                                    if(!empty($scheme->sector)){
                                        $sectors = json_decode($scheme->sector);
                                        $sector_description = json_decode($scheme->sector_description);
                                        
                                        foreach($sectors as $jsd => $sector){
                                            $all_sector[$jsd]['sector'] = $sector;
                                            $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                        }
                                    
                                    }
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['videos'] = $all_videos;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sectors'] = $all_sector;
                                }
                            }
                        }
                    }
                }
            }
        }
        return $all_schemes;
    }

    public function fetchMarketRate(Request $request){
        if(!empty($request->commodity) && !empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->get();
        }elseif(!empty($request->commodity) && !empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->get();
        }elseif(!empty($request->commodity) && empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('market',$request->market)
                            ->get();
        }elseif(empty($request->commodity) && !empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->get();
        }
        elseif(!empty($request->commodity) && empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->get();
        }elseif(empty($request->commodity) && !empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->get();
        }elseif(empty($request->commodity) && empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('market',$request->market)
                            ->get();
        }else{
            $marketPrice = MarketPrice::select("*")
                            ->get();
        }
        
        return response()
            ->json(['message' => 'Market Prices', 'data' => $marketPrice], 200);
    }

    public function fetchCommodity(){
        $marketPrice = MarketPrice::select('commodity')->distinct()->get();
        // return response()
        //     ->json(['message' => 'Market Commodities', 'data' => $marketPrice], 200);
        return $marketPrice;
    }

    public function fetchMarketDistrict(){
        $marketPrice = MarketPrice::select('district')->distinct()->get();
        // return response()
        //     ->json(['message' => 'Market Districts', 'data' => $marketPrice], 200);
        return $marketPrice;
    }

    public function fetchMarket(Request $request){
        $marketPrice = MarketPrice::select('market')->distinct()->get();
        return response()
            ->json(['message' => 'District/Commodity/Market', 'data' => ['district'=> $this->fetchMarketDistrict(), 'commodity'=> $this->fetchCommodity(),'market'=>$marketPrice]], 200);
    }

    public function fetchFeaturedScheme(Request $request){
        $all_schemes=[];
        $all = Scheme::where('is_featured','1')->get();
        if(!empty($all)){
            foreach($all as $ckey => $scheme){
                $all_schemes[$ckey]['scheme_id'] = $scheme->id;
                $all_schemes[$ckey]['scheme_name'] = $scheme->scheme_name;
                $all_schemes[$ckey]['cost_norms'] = $scheme->cost_norms;
                $all_schemes[$ckey]['terms'] = json_decode($scheme->terms);
                $all_schemes[$ckey]['detailed_description'] = $scheme->detailed_description;
                $all_videos = [];
                if(!empty($scheme->videos)){
                    $videos = json_decode($scheme->videos);
                    $video_titles = json_decode($scheme->videos_title);
                    
                    foreach($videos as $jsv => $video){
                        $all_videos[$jsv]['video'] = $video;
                        $all_videos[$jsv]['title'] = $video_titles[$jsv];
                    }
                
                }
                $all_sector = [];
                if(!empty($scheme->sector)){
                    $sectors = json_decode($scheme->sector);
                    $sector_description = json_decode($scheme->sector_description);
                    
                    foreach($sectors as $jsd => $sector){
                        $all_sector[$jsd]['sector'] = $sector;
                        $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                    }
                
                }
                $all_schemes[$ckey]['non_project_based'] = $scheme->non_project_based;
                $all_schemes[$ckey]['private_sector'] = $scheme->private_sector;
                $all_schemes[$ckey]['public_sector'] = $scheme->public_sector;
                $all_schemes[$ckey]['public_range'] = $scheme->public_range;
                $all_schemes[$ckey]['private_range'] = $scheme->private_range;
                $all_schemes[$ckey]['year'] = $scheme->year;
                $all_schemes[$ckey]['is_featured'] = $scheme->is_featured;
                $all_schemes[$ckey]['status'] = $scheme->status;
                $all_schemes[$ckey]['units'] = $scheme->units;
                $all_schemes[$ckey]['videos'] = $all_videos;
                $all_schemes[$ckey]['scheme_image'] = $scheme->scheme_image;
                $all_schemes[$ckey]['sectors'] = $all_sector;
            }
            // scheme
        }
        // endif scheme
        return response()
            ->json(['message' => 'Featured Scheme', 'data' => $all_schemes], 200);
    }

    public function fetchVideos(Request $request){
        $video = YoutubeVideo::all();
        return response()
            ->json(['message' => 'Fetch Latest Videos', 'data' => $video], 200);
    }

    public function fetchAllSchemes(){
        $all_govts = GovtScheme::all();        

        $all_schemes = [];
        if(!empty($all_govts)){
            // govt scheme
            foreach($all_govts as $gkey => $all_govt){
                $all_schemes[$gkey]['govt_scheme_cat_id'] = $all_govt->id;
                $all_schemes[$gkey]['govt_scheme_cat_name'] = $all_govt->govt_name;
                // scheme category
                $scheme_categories = SchemeCategory::where('govt_scheme_id', $all_govt->id)->get();
                foreach($scheme_categories as $key => $scheme_cat){
                    $all_schemes[$gkey]['cat'][$key]['scheme_cat_id'] = $scheme_cat->id;
                    $all_schemes[$gkey]['cat'][$key]['scheme_cat_name'] = $scheme_cat->category_name;
                    // scheme sub category  or component type
                    $scheme_subcategories = SchemeSubCategory::where('scheme_category_id', $scheme_cat->id)->get();
                    if(!empty($scheme_subcategories)){
                        foreach($scheme_subcategories as $subkey => $scheme_subcategory){
                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_id'] = $scheme_subcategory->id;
                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_name'] = $scheme_subcategory->subcategory_name;
                            // component 
                            $scheme_components = Component::where('scheme_sub_category_id', $scheme_subcategory->id)->get();
                            
                            if(!empty($scheme_components)){
                                foreach($scheme_components as $cokey => $scheme_component){
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['component_id'] = $scheme_component->id;
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['component_name'] = $scheme_component->component_name;
                                    // sub component
                                    $scheme_subcomponents = SubComponent::where('component_id', $scheme_component->id)->get();
                                    if(!empty($scheme_subcomponents)){
                                        foreach($scheme_subcomponents as $sckey => $scheme_subcomponent){
                                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['sub_component_id'] = $scheme_subcomponent->id;
                                            $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['sub_component_name'] = $scheme_subcomponent->sub_component_name;
                                            // scheme
                                            $schemes = Scheme::where('sub_component_id', $scheme_subcomponent->id)->get();
                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['terms'] = json_decode($scheme->terms);
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                                    $all_videos = [];
                                                    if(!empty($scheme->videos)){
                                                        $videos = json_decode($scheme->videos);
                                                        $video_titles = json_decode($scheme->videos_title);
                                                        
                                                        foreach($videos as $jsv => $video){
                                                            $all_videos[$jsv]['video'] = $video;
                                                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                                        }
                                                    
                                                    }
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['year'] = $scheme->year;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['status'] = $scheme->status;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['units'] = $scheme->units;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['videos'] = $all_videos;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['sectors'] = $all_sector;
                                                }
                                                // scheme
                                            }
                                            // end scheme
                                            $schemes = Scheme::where('component_id', $scheme_component->id)->where('sub_component_id', null)->get();
                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['terms'] = json_decode($scheme->terms);
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                                    $all_videos = [];
                                                    if(!empty($scheme->videos)){
                                                        $videos = json_decode($scheme->videos);
                                                        $video_titles = json_decode($scheme->videos_title);
                                                        
                                                        foreach($videos as $jsv => $video){
                                                            $all_videos[$jsv]['video'] = $video;
                                                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                                        }
                                                    
                                                    }
                                                    $all_sector = [];
                                                    if(!empty($scheme->sector)){
                                                        $sectors = json_decode($scheme->sector);
                                                        $sector_description = json_decode($scheme->sector_description);
                                                        
                                                        foreach($sectors as $jsd => $sector){
                                                            $all_sector[$jsd]['sector'] = $sector;
                                                            $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                                        }
                                                    
                                                    }
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['year'] = $scheme->year;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['status'] = $scheme->status;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['units'] = $scheme->units;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['videos'] = $all_videos;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sectors'] = $all_sector;
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                        }
                                        // endfor subcomponent
                                    }

                                    $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->where('component_id',null)->get();
                                        if(!empty($schemes)){
                                            foreach($schemes as $ckey => $scheme){
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['terms'] = json_decode($scheme->terms);
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                                $all_videos = [];
                                                if(!empty($scheme->videos)){
                                                    $videos = json_decode($scheme->videos);
                                                    $video_titles = json_decode($scheme->videos_title);
                                                    
                                                    foreach($videos as $jsv => $video){
                                                        $all_videos[$jsv]['video'] = $video;
                                                        $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                                    }
                                                
                                                }
                                                $all_sector = [];
                                                if(!empty($scheme->sector)){
                                                    $sectors = json_decode($scheme->sector);
                                                    $sector_description = json_decode($scheme->sector_description);
                                                    
                                                    foreach($sectors as $jsd => $sector){
                                                        $all_sector[$jsd]['sector'] = $sector;
                                                        $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                                    }
                                                
                                                }
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['year'] = $scheme->year;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['status'] = $scheme->status;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['units'] = $scheme->units;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['videos'] = $all_videos;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                                $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sectors'] = $all_sector;
                                            }
                                            // scheme
                                        }
                                        // endif scheme
                                }
                                // end for component
                            }
                            // else{
                            //     // scheme
                            //     $schemes = Scheme::where('category_id', $scheme_cat->id)->get();
                            //     if(!empty($schemes)){
                            //         foreach($schemes as $ckey => $scheme){
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['subsidy'] = $scheme->subsidy;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['terms'] = json_decode($scheme->terms);
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                            //             $all_videos = [];
                            //             if(!empty($scheme->videos)){
                            //                 $videos = json_decode($scheme->videos);
                            //                 $video_titles = json_decode($scheme->videos_title);
                                            
                            //                 foreach($videos as $jsv => $video){
                            //                     $all_videos[$jsv]['video'] = $video;
                            //                     $all_videos[$jsv]['title'] = $video_titles[$jsv];
                            //                 }
                                        
                            //             }
                            //             $all_sector = [];
                            //             if(!empty($scheme->sector)){
                            //                 $sectors = json_decode($scheme->sector);
                            //                 $sector_description = json_decode($scheme->sector_description);
                                            
                            //                 foreach($sectors as $jsd => $sector){
                            //                     $all_sector[$jsd]['sector'] = $sector;
                            //                     $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                            //                 }
                                        
                            //             }
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['videos'] = $all_videos;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                            //             $all_schemes[$gkey]['cat'][$key]['scheme'][$ckey]['sectors'] = $all_sector;
                            //         }
                            //         // scheme
                            //     }
                            //     // endif scheme
                            // }
                            // endif component
                        }
                        // sub scheme category or component type
                    }
                    // endif sub scheme category or component type
                }
                // scheme category
            }
            // govt scheme
        }

        return $all_schemes;
    }
}