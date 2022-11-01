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
use App\Models\FarmerBankDetail;
use App\Models\FarmerLandDetail;
use App\Models\AppliedScheme;
use App\Models\Notification;

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
                if($userFound->status == 1){
                    return response()
                    ->json(['message' => 'Mobile Number Already Exists!'], 401);
                }elseif($userFound->status == 2){
                    return response()
                    ->json(['message' => 'Your account is blocked. Please contact to administrator!'], 401);
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
                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
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
                                    // $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sectors'] = $all_sector;
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
        $min_price='';
        $max_price='';
        $modal_price='';
        if(!empty($request->commodity) && !empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('modal_price');
        }elseif(!empty($request->commodity) && !empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('district',$request->district)
                            ->sum('modal_price');
        }elseif(!empty($request->commodity) && empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('market',$request->market)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('market',$request->market)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('market',$request->market)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->where('market',$request->market)
                            ->sum('modal_price');
        }elseif(empty($request->commodity) && !empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->where('market',$request->market)
                            ->sum('modal_price');
        }
        elseif(!empty($request->commodity) && empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('commodity',$request->commodity)
                            ->sum('modal_price');
        }elseif(empty($request->commodity) && !empty($request->district) && empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('district',$request->district)
                            ->sum('modal_price');
        }elseif(empty($request->commodity) && empty($request->district) && !empty($request->market)){
            $marketPrice = MarketPrice::select("*")
                            ->where('market',$request->market)
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->where('market',$request->market)
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->where('market',$request->market)
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->where('market',$request->market)
                            ->sum('modal_price');
        }else{
            $marketPrice = MarketPrice::select("*")
                            ->get();
            $min_price = MarketPrice::select("*")
                            ->sum('min_price');
            $max_price = MarketPrice::select("*")
                            ->sum('max_price');
            $modal_price = MarketPrice::select("*")
                            ->sum('modal_price');
        }
        
        return response()
            ->json(['message' => 'Market Prices', 'total_min_price' => $min_price,'total_max_price' => $max_price,'total_modal_price' => $modal_price,'data' => $marketPrice], 200);
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
        $schemes = Scheme::where('is_featured','1')->get();
        
        if(!empty($schemes)){
            foreach($schemes as $key=>$scheme){
                $terms=[];
                if(!empty(json_decode($scheme['terms']))){
                    foreach(json_decode($scheme['terms']) as $keys => $req){
                        $terms[$keys]['terms'] = $req;
                    }
                }
                $schemes[$key]['terms']=$terms;
                $all_videos = [];
                if(!empty($scheme->videos)){
                    $videos = json_decode($scheme['videos']);
                    $video_titles = json_decode($scheme['videos_title']);
                    
                    foreach($videos as $jsv => $video){
                        $all_videos[$jsv]['video'] = $video;
                        $all_videos[$jsv]['title'] = $video_titles[$jsv];
                    }                
                }
                $schemes[$key]['video'] = $all_videos;
            }
            // scheme
            return response()
                        ->json(['message' => 'Fetch Featured Scheme Successfully','media_url'=>'storage/scheme-images/' ,'doc_url'=>'storage/scheme-doc/','schemes'=> $schemes], 200);
        }
    }

    public function fetchVideos(Request $request){
        $video = YoutubeVideo::all();
        return response()
            ->json(['message' => 'Fetch Latest Videos', 'data' => $video], 200);
    }

    public function searchVideos(Request $request){
        if(!empty($request->keyword)){
            $video = YoutubeVideo::where('title', 'LIKE', '%'.$request->keyword.'%')->get();
            return response()
                ->json(['message' => 'Fetch Latest Videos', 'data' => $video], 200);
        }else{
            return response()
                ->json(['message' => 'Fetch Latest Videos', 'data' => ''], 200);
        }
        
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
                        // $scheme_subcategories = SchemeSubCategory::where('scheme_category_id', $scheme_cat->id)->get();
                        // if(!empty($scheme_subcategories)){
                        //     foreach($scheme_subcategories as $subkey => $scheme_subcategory){
                        //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_id'] = $scheme_subcategory->id;
                        //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['subscheme_name'] = $scheme_subcategory->subcategory_name;
                                // $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->whereNull('sub_component_id')->where('year', '2020-21')->orWhere('year', '2021-22')->get();
                                // if(!empty($schemes)){
                                //     foreach($schemes as $ckey => $scheme){
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                //         $all_videos = [];
                                //         if(!empty($scheme->videos)){
                                //             $videos = json_decode($scheme->videos);
                                //             $video_titles = json_decode($scheme->videos_title);
                                            
                                //             foreach($videos as $jsv => $video){
                                //                 $all_videos[$jsv]['video'] = $video;
                                //                 $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                //             }
                                        
                                //         }
                                //         $all_sector = [];
                                //         if(!empty($scheme->sector)){
                                //             $sectors = json_decode($scheme->sector);
                                //             $sector_description = json_decode($scheme->sector_description);
                                            
                                //             foreach($sectors as $jsd => $sector){
                                //                 $all_sector[$jsd]['sector'] = $sector;
                                //                 $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                //             }
                                        
                                //         }
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['year'] = $scheme->year;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['status'] = $scheme->status;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['units'] = $scheme->units;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['videos'] = $all_videos;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                //     }
                                //     // scheme
                                // }
                                // endif scheme
                                // component 
                                // $scheme_components = Component::where('scheme_sub_category_id', $scheme_subcategory->id)->get();
                                
                                // if(!empty($scheme_components)){
                                //     foreach($scheme_components as $cokey => $scheme_component){
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['component_id'] = $scheme_component->id;
                                //         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['component_name'] = $scheme_component->component_name;
                                //         // sub component
                                //         $scheme_subcomponents = SubComponent::where('component_id', $scheme_component->id)->get();
                                //         if(!empty($scheme_subcomponents)){
                                //             foreach($scheme_subcomponents as $sckey => $scheme_subcomponent){
                                //                 $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['sub_component_id'] = $scheme_subcomponent->id;
                                //                 $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['sub_component_name'] = $scheme_subcomponent->sub_component_name;
                                //                 // scheme
                                //                 $schemes = Scheme::where('sub_component_id', $scheme_subcomponent->id)->where('year', '2020-21')->orWhere('year', '2021-22')->get();
                                //                 if(!empty($schemes)){
                                //                     foreach($schemes as $ckey => $scheme){
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                //                         $all_videos = [];
                                //                         if(!empty($scheme->videos)){
                                //                             $videos = json_decode($scheme->videos);
                                //                             $video_titles = json_decode($scheme->videos_title);
                                                            
                                //                             foreach($videos as $jsv => $video){
                                //                                 $all_videos[$jsv]['video'] = $video;
                                //                                 $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                //                             }
                                                        
                                //                         }
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['year'] = $scheme->year;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['status'] = $scheme->status;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['units'] = $scheme->units;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['videos'] = $all_videos;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                //                     }
                                //                     // scheme
                                //                 }
                                //                 // end scheme
                                //                 $schemes = Scheme::where('component_id', $scheme_component->id)->whereNull('sub_component_id')->where('year', '2020-21')->orWhere('year', '2021-22')->get();
                                //                 if(!empty($schemes)){
                                //                     foreach($schemes as $ckey => $scheme){
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                //                         $all_videos = [];
                                //                         if(!empty($scheme->videos)){
                                //                             $videos = json_decode($scheme->videos);
                                //                             $video_titles = json_decode($scheme->videos_title);
                                                            
                                //                             foreach($videos as $jsv => $video){
                                //                                 $all_videos[$jsv]['video'] = $video;
                                //                                 $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                //                             }
                                                        
                                //                         }
                                //                         $all_sector = [];
                                //                         if(!empty($scheme->sector)){
                                //                             $sectors = json_decode($scheme->sector);
                                //                             $sector_description = json_decode($scheme->sector_description);
                                                            
                                //                             foreach($sectors as $jsd => $sector){
                                //                                 $all_sector[$jsd]['sector'] = $sector;
                                //                                 $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                //                             }
                                                        
                                //                         }
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['year'] = $scheme->year;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['status'] = $scheme->status;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['units'] = $scheme->units;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['videos'] = $all_videos;
                                //                         $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                //                     }
                                //                     // scheme
                                //                 }
                                //                 // endif scheme
                                //             }
                                //             // endfor subcomponent
                                //         }
    
                                //         $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->where('year', '2020-21')->orWhere('year', '2021-22')->get();
                                //             if(!empty($schemes)){
                                //                 foreach($schemes as $ckey => $scheme){
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                //                     $all_videos = [];
                                //                     if(!empty($scheme->videos)){
                                //                         $videos = json_decode($scheme->videos);
                                //                         $video_titles = json_decode($scheme->videos_title);
                                                        
                                //                         foreach($videos as $jsv => $video){
                                //                             $all_videos[$jsv]['video'] = $video;
                                //                             $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                //                         }
                                                    
                                //                     }
                                //                     $all_sector = [];
                                //                     if(!empty($scheme->sector)){
                                //                         $sectors = json_decode($scheme->sector);
                                //                         $sector_description = json_decode($scheme->sector_description);
                                                        
                                //                         foreach($sectors as $jsd => $sector){
                                //                             $all_sector[$jsd]['sector'] = $sector;
                                //                             $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                //                         }
                                                    
                                //                     }
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['year'] = $scheme->year;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['status'] = $scheme->status;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['units'] = $scheme->units;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['videos'] = $all_videos;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                //                 }
                                //                 // scheme
                                //             }
                                //             // endif scheme
                                //             $schemes = Scheme::where('component_id',$scheme_component->id)->whereNull('sub_component_id')->where('year', '2020-21')->orWhere('year', '2021-22')->get();

                                //             if(!empty($schemes)){
                                //                 foreach($schemes as $ckey => $scheme){
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_name'] = $scheme->scheme_name;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['cost_norms'] = $scheme->cost_norms;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['terms'] = (object)json_decode($scheme->terms);
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['detailed_description'] = $scheme->detailed_description;
                                //                     $all_videos = [];
                                //                     if(!empty($scheme->videos)){
                                //                         $videos = json_decode($scheme->videos);
                                //                         $video_titles = json_decode($scheme->videos_title);
                                                        
                                //                         foreach($videos as $jsv => $video){
                                //                             $all_videos[$jsv]['video'] = $video;
                                //                             $all_videos[$jsv]['title'] = $video_titles[$jsv];
                                //                         }
                                                    
                                //                     }
                                //                     $all_sector = [];
                                //                     if(!empty($scheme->sector)){
                                //                         $sectors = json_decode($scheme->sector);
                                //                         $sector_description = json_decode($scheme->sector_description);
                                                        
                                //                         foreach($sectors as $jsd => $sector){
                                //                             $all_sector[$jsd]['sector'] = $sector;
                                //                             $all_sector[$jsd]['sector_description'] = $sector_description[$jsd];
                                //                         }
                                                    
                                //                     }
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['non_project_based'] = $scheme->non_project_based;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_sector'] = $scheme->private_sector;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_sector'] = $scheme->public_sector;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['public_range'] = $scheme->public_range;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['private_range'] = $scheme->private_range;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['year'] = $scheme->year;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['is_featured'] = $scheme->is_featured;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['status'] = $scheme->status;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['units'] = $scheme->units;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['videos'] = $all_videos;
                                //                     $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_image'] = $scheme->scheme_image;
                                //                 }
                                //                 // scheme
                                //             }
                                //             // endif scheme
                                //     }
                                    
                                    
                                //     // end for component
                                // }
                               
                                
                                // endif component
                        //     }
                        //     // sub scheme category or component type
                        // }
                        // endif sub scheme category or component type
                    }
                    // scheme category
                }
            // govt scheme
        }

        return $all_schemes;
    }


    public function fetchFarmerLand(Request $request){
        $bank_details = FarmerLandDetail::where('farmer_id', $request->farmer_id)->get();
        return response()->json(['message' => 'Land Detail','media_url'=>'storage/land-images/' ,'data'=> $bank_details], 200);
    }

    public function deleteFarmerLand(Request $request){
        $bank_details = FarmerLandDetail::where('id', $request->land_id)->delete();
        return response()->json(['message' => 'Land Detail Deleted'], 200);
    }

    public function fetchFarmerBank(Request $request){
        $bank_details = FarmerBankDetail::where('farmer_id', $request->farmer_id)->first();
        return response()->json(['message' => 'Bank Detail','media_url'=>'storage/bank-images/' ,'data'=> $bank_details], 200);
    }

    public function saveFarmerLand(Request $request){
        $land_id = $request->land_id;
        $farmer_id = $request->farmer_id;
        $total_land_area = $request->total_land_area; 
        $state = $request->state;
        $district_id = $request->district_id; 
        $tehsil_id = $request->tehsil_id; 
        $city_id = $request->city_id; 
        $pin_code = $request->pin_code; 
        $land_address = $request->land_address; 
        $area_information = $request->area_information;
        $upload_fard = $request->upload_fard; 
        $pattedar_no = $request->pattedar_no; 
        $upload_pattedar = $request->upload_pattedar; 
        $khewat_no = $request->khewat_no; 
        $khatauni_no = $request->khatauni_no; 
        $khasra_no = $request->khasra_no;
        
        if(!empty($total_land_area)){
            foreach($total_land_area as $key => $land){
                if(empty($land_id[$key])){
                    if(!empty($request->file('upload_fard')[$key]) && !empty($request->file('upload_pattedar')[$key])){
                    if($request->file('upload_fard')[$key] && $request->file('upload_pattedar')[$key]){
                        $upload_fard_name = time().$request->file('upload_fard')[$key]->getClientOriginalName();
                        $request->file('upload_fard')[$key]->storeAs('land-images',$upload_fard_name,'public');
                        $upload_pattedar_name = time().$request->file('upload_pattedar')[$key]->getClientOriginalName();
                        $request->file('upload_pattedar')[$key]->storeAs('land-images',$upload_pattedar_name,'public');
                        $land_detail = FarmerLandDetail::create([
                            'farmer_id' => $farmer_id,
                            'total_land_area' => $total_land_area[$key], 
                            'state' => $state[$key], 
                            'district_id' => $district_id[$key], 
                            'tehsil_id' => $tehsil_id[$key], 
                            'city_id' => $city_id[$key], 
                            'pin_code' => $pin_code[$key], 
                            'land_address' =>  $land_address[$key], 
                            'area_information' => $area_information[$key], 
                            'upload_fard' => $upload_fard_name, 
                            'pattedar_no' => $pattedar_no[$key], 
                            'upload_pattedar' => $upload_pattedar_name, 
                            'khewat_no' => $khewat_no[$key], 
                            'khatauni_no' => $khatauni_no[$key], 
                            'khasra_no' => $khasra_no[$key]
                        ]);
                    }
                }else{
                    return response()
                        ->json(['message' => 'Provide Documents'], 401);
                }
            }else{
                    if(!empty($request->file('upload_fard')[$key]) && !empty($request->file('upload_pattedar')[$key])){
                    if($request->file('upload_fard')[$key] && $request->file('upload_pattedar')[$key]){
                        $upload_fard_name = time().$request->file('upload_fard')[$key]->getClientOriginalName();
                        $request->file('upload_fard')[$key]->storeAs('land-images',$upload_fard_name,'public');
                        $upload_pattedar_name = time().$request->file('upload_pattedar')[$key]->getClientOriginalName();
                        $request->file('upload_pattedar')[$key]->storeAs('land-images',$upload_pattedar_name,'public');
                        $land_detail = FarmerLandDetail::where('id', $land_id[$key])->update([
                            'farmer_id' => $farmer_id,
                            'total_land_area' => $total_land_area[$key], 
                            'state' => $state[$key], 
                            'district_id' => $district_id[$key], 
                            'tehsil_id' => $tehsil_id[$key], 
                            'city_id' => $city_id[$key], 
                            'pin_code' => $pin_code[$key], 
                            'land_address' =>  $land_address[$key], 
                            'area_information' => $area_information[$key], 
                            'upload_fard' => $upload_fard_name, 
                            'pattedar_no' => $pattedar_no[$key], 
                            'upload_pattedar' => $upload_pattedar_name, 
                            'khewat_no' => $khewat_no[$key], 
                            'khatauni_no' => $khatauni_no[$key], 
                            'khasra_no' => $khasra_no[$key]
                        ]);
                        
                    }}else{
                        $land_detail = FarmerLandDetail::where('id', $land_id[$key])->update([
                            'farmer_id' => $farmer_id,
                            'total_land_area' => $total_land_area[$key], 
                            'state' => $state[$key], 
                            'district_id' => $district_id[$key], 
                            'tehsil_id' => $tehsil_id[$key], 
                            'city_id' => $city_id[$key], 
                            'pin_code' => $pin_code[$key], 
                            'land_address' =>  $land_address[$key], 
                            'area_information' => $area_information[$key], 
                            'pattedar_no' => $pattedar_no[$key],  
                            'khewat_no' => $khewat_no[$key], 
                            'khatauni_no' => $khatauni_no[$key], 
                            'khasra_no' => $khasra_no[$key]
                        ]);
                        
                    }
                }
            }
            return response()
                        ->json(['message' => 'Land Detail added Successfully','media_url'=>'storage/land-images/'], 200);
            
        }
    }

    public function saveFarmerBank(Request $request){
        try{
            $farmer_id = $request->farmer_id;
            $bank_name = $request->bank_name;
            $branch_name = $request->branch_name;
            $account_no = $request->account_no;
            $account_name = $request->account_name;
            $bank_branch_address = $request->bank_branch_address;
            $upload_cancel_check = $request->upload_cancel_check;
            $passbook_no = $request->passbook_no;
            $ifsc_code = $request->ifsc_code;
            $bank_details = FarmerBankDetail::where('farmer_id', $farmer_id)->first();
            if(empty($bank_details)){
                if($request->hasFile('upload_cancel_check') && $request->hasFile('upload_passbook')){
                    $upload_cancel_name = time().$request->upload_cancel_check->getClientOriginalName();
                    $request->upload_cancel_check->storeAs('bank-images',$upload_cancel_name,'public');
                    $upload_passbook_name = time().$request->upload_passbook->getClientOriginalName();
                    $request->upload_passbook->storeAs('bank-images',$upload_cancel_name,'public');
                    $details=FarmerBankDetail::create([
                        'farmer_id' => $farmer_id, 
                        'bank_name' => $bank_name, 
                        'branch_name' => $branch_name, 
                        'account_no' => $account_no, 
                        'account_name' => $account_name, 
                        'bank_branch_address' => $bank_branch_address, 
                        'upload_cancel_check' => $upload_cancel_name, 
                        'upload_passbook' => $upload_passbook_name,
                        'passbook_no' => $passbook_no,
                        'ifsc_code' => $ifsc_code
                    ]);

                    if($details){
                        $bank_user = FarmerBankDetail::where('id', $details->id)->first();
                        return response()
                            ->json(['message' => 'Bank Detail created Successfully','media_url'=>'storage/bank-images/' ,'data'=> $bank_user], 200);
                    }else{
                        return response()
                            ->json(['message' => 'Something Went Wrong!'], 401);
                    }
                }else{
                    return response()
                        ->json(['message' => 'Provide Documents'], 401);
                }

            }else{
                if($request->hasFile('upload_cancel_check') && $request->hasFile('upload_passbook')){
                    $upload_cancel_name = time().$request->upload_cancel_check->getClientOriginalName();
                    $request->upload_cancel_check->storeAs('bank-images',$upload_cancel_name,'public');
                    $upload_passbook_name = time().$request->upload_passbook->getClientOriginalName();
                    $request->upload_passbook->storeAs('bank-images',$upload_passbook_name,'public');
                    $details=FarmerBankDetail::where('id',$bank_details->id)->update([
                        'farmer_id' => $farmer_id, 
                        'bank_name' => $bank_name, 
                        'branch_name' => $branch_name, 
                        'account_no' => $account_no, 
                        'account_name' => $account_name, 
                        'bank_branch_address' => $bank_branch_address, 
                        'upload_cancel_check' => $upload_cancel_name, 
                        'upload_passbook' => $upload_passbook_name,
                        'passbook_no' => $passbook_no,
                        'ifsc_code' => $ifsc_code
                    ]);
                    if($details){
                        $bank_user = FarmerBankDetail::where('id', $bank_details->id)->first();
                        return response()
                            ->json(['message' => 'Bank Detail updated Successfully','media_url'=>'storage/bank-images/' ,'data'=> $bank_user], 200);
                    }else{
                        return response()
                            ->json(['message' => 'Something Went Wrong!'], 401);
                    }
                }
            else{
                $details=FarmerBankDetail::where('id',$bank_details->id)->update([
                    'farmer_id' => $farmer_id, 
                    'bank_name' => $bank_name, 
                    'branch_name' => $branch_name, 
                    'account_no' => $account_no, 
                    'account_name' => $account_name, 
                    'bank_branch_address' => $bank_branch_address,  
                    'passbook_no' => $passbook_no,
                    'ifsc_code' => $ifsc_code
                ]);
                if($details){
                    $bank_user = FarmerBankDetail::where('id', $bank_details->id)->first();
                    return response()
                        ->json(['message' => 'Bank Detail updated Successfully','media_url'=>'storage/bank-images/' ,'data'=> $bank_user], 200);
                }else{
                    return response()
                        ->json(['message' => 'Something Went Wrong!'], 401);
                }
            }
        }}catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function appliedScheme(Request $request){
        try{
            $farmer_id = $request->farmer_id;
            $scheme_id = $request->scheme_id;
            $land_applied = $request->land_applied;
            $land_address_id = $request->land_address_id;
            $project_note = $request->project_note;
            $technical_datasheet = $request->technical_datasheet;
            $bank_sanction = $request->bank_sanction;
            $quotation_solar = $request->quotation_solar;
            $site_plan = $request->site_plan;
            $partnership_deep = $request->partnership_deep;
            $pan_aadhar = $request->pan_aadhar;
            $location_plan = $request->location_plan;
            $land_documents = $request->land_documents;
            $self_declaration = $request->self_declaration;
            $other_documents = $request->other_documents;
            $public_private = $request->public_private;

            if(!empty($farmer_id) && !empty($scheme_id) && !empty($land_address_id)){
                $project_note_name ='';
                $technical_datasheet_name ='';
                $bank_sanction_name ='';
                $quotation_solar_name ='';
                $site_plan_name ='';
                $partnership_deep_name ='';
                $pan_aadhar_name ='';
                $location_plan_name ='';
                $land_documents_name ='';
                $self_declaration_name ='';
                $other_documents_names =[];
                if($request->hasFile('project_note')){
                    $project_note_name = time().$request->project_note->getClientOriginalName();
                    $request->project_note->storeAs('scheme-documents/'.date('Y'),$project_note_name,'public');
                }
                if($request->hasFile('technical_datasheet')){
                    $technical_datasheet_name = time().$request->technical_datasheet->getClientOriginalName();
                    $request->technical_datasheet->storeAs('scheme-documents/'.date('Y'),$technical_datasheet_name,'public');
                }
                if($request->hasFile('bank_sanction')){
                    $bank_sanction_name = time().$request->bank_sanction->getClientOriginalName();
                    $request->bank_sanction->storeAs('scheme-documents/'.date('Y'),$bank_sanction_name,'public');
                }
                if($request->hasFile('quotation_solar')){
                    $quotation_solar_name = time().$request->quotation_solar->getClientOriginalName();
                    $request->quotation_solar->storeAs('scheme-documents/'.date('Y'),$quotation_solar_name,'public');
                }
                if($request->hasFile('site_plan')){
                    $site_plan_name = time().$request->site_plan->getClientOriginalName();
                    $request->site_plan->storeAs('scheme-documents/'.date('Y'),$site_plan_name,'public');
                }
                if($request->hasFile('partnership_deep')){
                    $partnership_deep_name = time().$request->partnership_deep->getClientOriginalName();
                    $request->partnership_deep->storeAs('scheme-documents/'.date('Y'),$partnership_deep_name,'public');
                }
                if($request->hasFile('pan_aadhar')){
                    $pan_aadhar_name = time().$request->pan_aadhar->getClientOriginalName();
                    $request->pan_aadhar->storeAs('scheme-documents/'.date('Y'),$pan_aadhar_name,'public');
                }
                if($request->hasFile('location_plan')){
                    $location_plan_name = time().$request->location_plan->getClientOriginalName();
                    $request->location_plan->storeAs('scheme-documents/'.date('Y'),$location_plan_name,'public');
                }
                if($request->hasFile('land_documents')){
                    $location_plan_name = time().$request->land_documents->getClientOriginalName();
                    $request->land_documents->storeAs('scheme-documents/'.date('Y'),$location_plan_name,'public');
                }
                if($request->hasFile('self_declaration')){
                    $self_declaration_name = time().$request->self_declaration->getClientOriginalName();
                    $request->self_declaration->storeAs('scheme-documents/'.date('Y'),$self_declaration_name,'public');
                }
                if(!empty($request->other_documents)){
                    if(count($request->other_documents)>0){
                        foreach($request->other_documents as $key => $file)
                        { 
                            $other_documents_name = time().$file->getClientOriginalName();
                            $other_documents_names[$key] = $other_documents_name;
                            $file->storeAs('scheme-documents/'.date('Y'),$other_documents_name,'public');
                        }
                    }
                }
                $bank_details = FarmerLandDetail::where('farmer_id', $farmer_id)->where('id', $land_address_id)->first();

                $check_apply_scheme = AppliedScheme::where('farmer_id', $farmer_id)
                    ->where('land_address_id', $land_address_id)
                    ->where('scheme_id', $scheme_id)
                    ->first();
                
                if(empty($check_apply_scheme) && empty($request->reject)){            
                    $applied_schemes = AppliedScheme::create([
                        'farmer_id' => $farmer_id,
                        'scheme_id' => $scheme_id,
                        'land_applied' => $land_applied,
                        'land_address_id' => $land_address_id,
                        'project_note' => $project_note_name,
                        'technical_datasheet' => $technical_datasheet_name,
                        'bank_sanction' => $bank_sanction_name,
                        'quotation_solar' => $quotation_solar_name,
                        'site_plan' => $site_plan_name,
                        'partnership_deep' => $partnership_deep_name,
                        'pan_aadhar' => $pan_aadhar_name,
                        'location_plan' => $location_plan_name,
                        'land_documents' => $land_documents_name,
                        'self_declaration' => $self_declaration_name,
                        'other_documents' => json_encode($other_documents_names),
                        'state' => $bank_details->state, 
                        'district_id' => $bank_details->district_id, 
                        'tehsil_id' => $bank_details->tehsil_id,
                        'public_private' => $public_private,
                        'reattempts'=>1         
                    ]);
                
                    if($applied_schemes){
                        $submit = AppliedScheme::where('id', $applied_schemes->id)->update([
                            'application_number' => 'PHSCHM000'.$applied_schemes->id
                        ]);
                        $user_id = User::farmer($farmer_id);
                        Notification::create([
                            'user_id' => $user_id->id,
                            'message'=>('New Application Received <a href="'.url('/view-applied-scheme',['id'=>$applied_schemes->id]).'">Click to view</a>')
                        ]);
                        return response()
                                ->json(['message' => 'Scheme Applied','document_url'=>'storage/scheme-documents/'.date('Y').'/' ,'application_id'=> 'PHSCHM'.str_pad($applied_schemes->id,6, "0", STR_PAD_LEFT)], 200);
                    }
                }else{
                    if(!empty($request->reject)){
                        $applied_schemes = AppliedScheme::where('id', $check_apply_scheme->id)->update([
                            'project_note' => $project_note_name,
                            'technical_datasheet' => $technical_datasheet_name,
                            'bank_sanction' => $bank_sanction_name,
                            'quotation_solar' => $quotation_solar_name,
                            'site_plan' => $site_plan_name,
                            'partnership_deep' => $partnership_deep_name,
                            'pan_aadhar' => $pan_aadhar_name,
                            'location_plan' => $location_plan_name,
                            'land_documents' => $land_documents_name,
                            'self_declaration' => $self_declaration_name,
                            'other_documents' => json_encode($other_documents_names),
                            'state' => $bank_details->state, 
                            'district_id' => $bank_details->district_id, 
                            'tehsil_id' => $bank_details->tehsil_id,
                            'public_private' => $public_private,
                            'reattempts' => ($check_apply_scheme->reattempts+1)     
                        ]);
                        $user_id = User::farmer($farmer_id);
                        Notification::create([
                            'user_id' => $user_id->id,
                            'message'=>('Resubmitted Application Received <a href="'.url('/view-applied-scheme',['id'=>$applied_schemes->id]).'">Click to view</a>')
                        ]);
                        return response()
                                ->json(['message' => 'Resubmitted Scheme Successfully','document_url'=>'storage/scheme-documents/'.date('Y').'/' ], 200);
                    }else{
                        return response()
                                ->json(['message' => 'Already Scheme Applied','document_url'=>'storage/scheme-documents/'.date('Y').'/' ], 200);
                    }
                }

            }else{
                return response()
                        ->json(['message' => 'Please provide Farmer ID, Scheme ID, Land Address ID'], 401);
            }
        }catch (\Exception $e) {
            return response()
                    ->json(['message' => 'Data not processed!'], 401);
        }
    }

    public function fetchSchemeStatus(Request $request){
        $fetchapp = AppliedScheme::select('applied_schemes.*','applied_schemes.status as tehsil_status','applied_schemes.created_at as acreated_at','applied_schemes.updated_at as aupdated_at','schemes.*','farmer_land_details.*','districts.district_name', 'tehsils.tehsil_name')
            ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
            ->join('districts','districts.id','=','applied_schemes.district_id')
            ->join('farmer_land_details','farmer_land_details.id','=','applied_schemes.land_address_id')
            ->join('tehsils','tehsils.id','=','applied_schemes.tehsil_id')
            ->where('applied_schemes.farmer_id', $request->farmer_id)
            ->get();
        return response()
                    ->json(['message' => 'Fetch all applied schemes', 'data' => $fetchapp], 200);
    }

    public function fetchCategorySchemes(Request $request){
        if(!empty($request->component_id) && !empty($request->subcomponent_id)){
            $schemes = Scheme::where('scheme_subcategory_id', $request->id)->where('component_id',$request->component_id)->where('sub_component_id',$request->subcomponent_id)->where('year', '2020-21')->orWhere('year', '2022-23')->paginate();
            if(!empty($schemes)){
                foreach($schemes as $key=>$scheme){
                    $terms=[];
                    if(!empty(json_decode($scheme['terms']))){
                        foreach(json_decode($scheme['terms']) as $keys => $req){
                            $terms[$keys]['terms'] = $req;
                        }
                    }
                    $schemes[$key]['terms']=$terms;
                    $all_videos = [];
                    if(!empty($scheme->videos)){
                        $videos = json_decode($scheme['videos']);
                        $video_titles = json_decode($scheme['videos_title']);
                        
                        foreach($videos as $jsv => $video){
                            $all_videos[$jsv]['video'] = $video;
                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                        }                
                    }
                    $schemes[$key]['video'] = $all_videos;
                }
                // scheme
                return response()
                            ->json(['message' => 'Fetched Scheme Successfully','media_url'=>'storage/scheme-images/' ,'doc_url'=>'storage/scheme-doc/','schemes'=> $schemes], 200);
            }
        }elseif(!empty($request->component_id) && empty($request->subcomponent_id)){
            $schemes = Scheme::where('scheme_subcategory_id', $request->id)->where('component_id',$request->component_id)->where('year', '2020-21')->orWhere('year', '2021-22')->paginate();
            if(!empty($schemes)){
                foreach($schemes as $key=>$scheme){
                    $terms=[];
                    if(!empty(json_decode($scheme['terms']))){
                        foreach(json_decode($scheme['terms']) as $keys => $req){
                            $terms[$keys]['terms'] = $req;
                        }
                    }
                    $schemes[$key]['terms']=$terms;
                    $all_videos = [];
                    if(!empty($scheme->videos)){
                        $videos = json_decode($scheme['videos']);
                        $video_titles = json_decode($scheme['videos_title']);
                        
                        foreach($videos as $jsv => $video){
                            $all_videos[$jsv]['video'] = $video;
                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                        }                
                    }
                    $schemes[$key]['video'] = $all_videos;
                }
                // scheme
                return response()
                            ->json(['message' => 'Fetched Scheme Successfully','media_url'=>'storage/scheme-images/' ,'doc_url'=>'storage/scheme-doc/','schemes'=> $schemes], 200);
            }
        }elseif(empty($request->component_id) && !empty($request->subcomponent_id)){
            $schemes = Scheme::where('scheme_subcategory_id', $request->id)->where('sub_component_id',$request->subcomponent_id)->where('year', '2020-21')->orWhere('year', '2022-23')->paginate();
            if(!empty($schemes)){
                foreach($schemes as $key=>$scheme){
                    $terms=[];
                    if(!empty(json_decode($scheme['terms']))){
                        foreach(json_decode($scheme['terms']) as $keys => $req){
                            $terms[$keys]['terms'] = $req;
                        }
                    }
                    $schemes[$key]['terms']=$terms;
                    $all_videos = [];
                    if(!empty($scheme->videos)){
                        $videos = json_decode($scheme['videos']);
                        $video_titles = json_decode($scheme['videos_title']);
                        
                        foreach($videos as $jsv => $video){
                            $all_videos[$jsv]['video'] = $video;
                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                        }                
                    }
                    $schemes[$key]['video'] = $all_videos;
                }
                // scheme
                return response()
                            ->json(['message' => 'Fetched Scheme Successfully','media_url'=>'storage/scheme-images/' ,'doc_url'=>'storage/scheme-doc/','schemes'=> $schemes], 200);
            }
        }else{
            $schemes = Scheme::where('scheme_subcategory_id', $request->id)->where('year', '2021-22')->paginate();

            if(!empty($schemes)){
                foreach($schemes as $key=>$scheme){
                    $terms=[];
                    if(!empty(json_decode($scheme['terms']))){
                        foreach(json_decode($scheme['terms']) as $keys => $req){
                            $terms[$keys]['terms'] = $req;
                        }
                    }
                    $schemes[$key]['terms']=$terms;
                    $all_videos = [];
                    if(!empty($scheme->videos)){
                        $videos = json_decode($scheme['videos']);
                        $video_titles = json_decode($scheme['videos_title']);
                        
                        foreach($videos as $jsv => $video){
                            $all_videos[$jsv]['video'] = $video;
                            $all_videos[$jsv]['title'] = $video_titles[$jsv];
                        }                
                    }
                    $schemes[$key]['video'] = $all_videos;
                }
                // scheme
                return response()
                            ->json(['message' => 'Fetched Scheme Successfully','media_url'=>'storage/scheme-images/','doc_url'=>'storage/scheme-doc/','schemes'=> $schemes], 200);
            }else{
                return response()
                            ->json(['message' => 'Fetched Scheme Successfully','media_url'=>'storage/scheme-images/','doc_url'=>'storage/scheme-doc/','schemes'=> ''], 200);
            }
        }        
    }

    public function fetchComponentType(Request $request){
        $scheme_subcategories = SchemeSubCategory::where('scheme_category_id', $request->id)->paginate();
        return response()
                            ->json(['message' => 'Fetched Component Type Successfully' ,'component_types'=>$scheme_subcategories], 200);
    }

    public function fetchComponentList(Request $request){
        $components = Component::select('id as component_id','component_name')->where('scheme_sub_category_id', $request->id)->get();
        $subcomponents = [];
        if(!empty($components)){
            foreach($components as $key=> $component){
                $components[$key]['sub_component'] = SubComponent::select('id as sub_component_id','sub_component_name')->where('component_id', $component->component_id)->get();
            }
        }

        return response()->json(['message' => 'Fetch Component and Sub components' ,'components'=>$components], 200);
    }

}