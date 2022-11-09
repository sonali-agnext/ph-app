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
use App\Models\TargetDistrict;
use App\Models\TargetBlock;
use Illuminate\Support\Facades\Validator;

class SubsidyController extends Controller
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

    //parent scheme category
    public static function manageStateSubsidy(Request $request){
        $scheme_category = SchemeCategory::all();
        $all_govts = GovtScheme::all();        

        $all_schemes = [];
        if($request->year){
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
                                $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->whereNull('sub_component_id')->where('year', $request->year)->get();
                                if(!empty($schemes)){
                                    foreach($schemes as $ckey => $scheme){
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                    }
                                    // scheme
                                }
                                // endif scheme
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
                                                $schemes = Scheme::where('sub_component_id', $scheme_subcomponent->id)->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // end scheme
                                                $schemes = Scheme::where('component_id', $scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // endif scheme
                                            }
                                            // endfor subcomponent
                                        }
    
                                        $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->where('year', $request->year)->get();
                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                            $schemes = Scheme::where('component_id',$scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();

                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                    }
                                    
                                    
                                    // end for component
                                }
                               
                                
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
        }

        $govt_schemes = GovtScheme::all();
        $components = Component::all();
        $subcomponents = SubComponent::where('status',"1")->get();

        return view('admin.targetset.edit',['year'=>$request->year,'subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes, 'scheme_subcategory' => $all_schemes]);
    }

    //parent scheme category
    public static function manageDistrictSubsidy(Request $request){
        $scheme_category = SchemeCategory::all();
        $all_govts = GovtScheme::all();        

        $all_schemes = [];
        if($request->year){
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
                                $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->whereNull('sub_component_id')->where('year', $request->year)->get();
                                if(!empty($schemes)){
                                    foreach($schemes as $ckey => $scheme){
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                    }
                                    // scheme
                                }
                                // endif scheme
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
                                                $schemes = Scheme::where('sub_component_id', $scheme_subcomponent->id)->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // end scheme
                                                $schemes = Scheme::where('component_id', $scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // endif scheme
                                            }
                                            // endfor subcomponent
                                        }
    
                                        $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->where('year', $request->year)->get();
                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                            $schemes = Scheme::where('component_id',$scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();

                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                    }
                                    
                                    
                                    // end for component
                                }
                               
                                
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
        }

        $govt_schemes = GovtScheme::all();
        $components = Component::all();
        $subcomponents = SubComponent::where('status',"1")->get();
        $districts = District::all();
        $user= new User;
        $sdistrict= $user->officer();

        return view('admin.targetset.districtedit',['districts'=>$districts,'sdistrict'=>(auth()->user()->role_id==3) ? $request->district_id : ($sdistrict->assigned_district),'year'=>$request->year,'subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes, 'scheme_subcategory' => $all_schemes]);
    }

    public static function updateStateSubsidy(Request $request){
        // $targets = TargetState::where('id',)->update();
        $all_targets = $request->target_id;
        $all_private_targets = $request->private_target_id;
        $all_remarks = $request->remarks;
        $all_private_remarks = $request->private_remarks;
        $all_physical_target = $request->physical_target;
        $all_private_physical_target=$request->private_physical_target;
        
        foreach($all_targets as $key=> $target){
            $privatetargets = TargetState::where('id',$all_private_targets[$key])->update(['private_physical_target'=> $all_private_physical_target[$key],'private_remarks' => $all_private_remarks[$key]]);
        }

        foreach($all_private_targets as $key=> $target){
            $privatetargets = TargetState::where('id',$all_private_targets[$key])->update(['private_physical_target'=> $all_private_physical_target[$key],'private_remarks' => $all_private_remarks[$key]]);
        }

        return redirect()->route('manage-subsidy-state')->with('success','Schemes updated successfully!');
        
    }

    public static function updateDistrictSubsidy(Request $request){

        // $targets = TargetState::where('id',)->update();
        $all_targets = $request->target_id;
        $all_private_targets = $request->private_target_id;
        $all_district_targets = $request->target_district_id;
        $all_private_target_district_ids = $request->private_target_district_id;
        $all_remarks = $request->district_remarks;
        $all_private_remarks = $request->district_private_remarks;
        $all_private_gen_targets = $request->private_gen_target;
        $all_private_sc_targets = $request->private_sc_target;
        $all_private_st_targets = $request->private_st_target;
        $all_private_women_targets = $request->private_women_target;
        $all_gen_targets = $request->gen_target;
        $all_sc_targets = $request->sc_target;
        $all_st_targets = $request->st_target;
        $all_women_targets = $request->women_target;
        $year = $request->year;
        $district = $request->district_id;
        
        foreach($all_targets as $key=> $target){ 
            $targets = TargetDistrict::where('district_id',$district)->where('target_state_id',$target)->first();           
            if(empty($all_district_targets[$key]) && empty($targets)){                
                $targets = TargetDistrict::create([
                    'district_id' => $district, 
                    'target_state_id' => $target, 
                    'assigned_physical_target'=> ((float)$all_gen_targets[$key]+(float)$all_sc_targets[$key]+(float)$all_st_targets[$key]+(float)$all_women_targets[$key]), 
                    'district_remarks'=>$all_remarks[$key],
                    'district_year' => $year,
                    'gen_target' => $all_gen_targets[$key],
                    'sc_target' => $all_sc_targets[$key],
                    'st_target' => $all_st_targets[$key],
                    'women_target' => $all_women_targets[$key]
                ]);
            }else{
                $targets = TargetDistrict::where('id', $targets->id)->update([
                    'district_id' => $district, 
                    'target_state_id' => $target, 
                    'assigned_physical_target'=> ((float)$all_gen_targets[$key]+(float)$all_sc_targets[$key]+(float)$all_st_targets[$key]+(float)$all_women_targets[$key]), 
                    'district_remarks'=>$all_remarks[$key],
                    'district_year' => $year,
                    'gen_target' => $all_gen_targets[$key],
                    'sc_target' => $all_sc_targets[$key],
                    'st_target' => $all_st_targets[$key],
                    'women_target' => $all_women_targets[$key]
                ]);
            }
        }

        foreach($all_private_targets as $key=> $target){ 
            $targets = TargetDistrict::where('district_id',$district)->where('target_state_id',$target)->first();           
            if(empty($all_district_targets[$key]) && empty($targets)){                
                $targets = TargetDistrict::create([
                    'district_id' => $district, 
                    'target_state_id' => $target, 
                    'assigned_private_physical_target'=> ((float)$all_private_gen_targets[$key]+(float)$all_private_sc_targets[$key]+(float)$all_private_st_targets[$key]+(float)$all_private_women_targets[$key]), 
                    'district_private_remarks'=>$all_private_remarks[$key],
                    'district_year' => $year,
                    'private_gen_target' => $all_private_gen_targets[$key],
                    'private_sc_target' => $all_private_sc_targets[$key],
                    'private_st_target' => $all_private_st_targets[$key],
                    'private_women_target' => $all_private_women_targets[$key]
                ]);
            }else{
                $targets = TargetDistrict::where('id', $targets->id)->update([
                    'district_id' => $district, 
                    'target_state_id' => $target, 
                    'assigned_private_physical_target'=> ((float)$all_private_gen_targets[$key]+(float)$all_private_sc_targets[$key]+(float)$all_private_st_targets[$key]+(float)$all_private_women_targets[$key]), 
                    'district_private_remarks'=>$all_private_remarks[$key],
                    'district_year' => $year,
                    'private_gen_target' => $all_private_gen_targets[$key],
                    'private_sc_target' => $all_private_sc_targets[$key],
                    'private_st_target' => $all_private_st_targets[$key],
                    'private_women_target' => $all_private_women_targets[$key]
                ]);
            }
        }

        return redirect()->route('manage-subsidy-district')->with('success','Schemes updated successfully!');
        
    }

    public static function manageBlockSubsidy(Request $request){
        $scheme_category = SchemeCategory::all();
        $all_govts = GovtScheme::all();        

        $all_schemes = [];
        if($request->year){
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
                                $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->whereNull('sub_component_id')->where('year', $request->year)->get();
                                if(!empty($schemes)){
                                    foreach($schemes as $ckey => $scheme){
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                    }
                                    // scheme
                                }
                                // endif scheme
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
                                                $schemes = Scheme::where('sub_component_id', $scheme_subcomponent->id)->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['subcomp'][$sckey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // end scheme
                                                $schemes = Scheme::where('component_id', $scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();
                                                if(!empty($schemes)){
                                                    foreach($schemes as $ckey => $scheme){
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                        $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                    }
                                                    // scheme
                                                }
                                                // endif scheme
                                            }
                                            // endfor subcomponent
                                        }
    
                                        $schemes = Scheme::where('scheme_subcategory_id', $scheme_subcategory->id)->whereNull('component_id')->where('year', $request->year)->get();
                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                            $schemes = Scheme::where('component_id',$scheme_component->id)->whereNull('sub_component_id')->where('year', $request->year)->get();

                                            if(!empty($schemes)){
                                                foreach($schemes as $ckey => $scheme){
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_id'] = $scheme->id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['scheme_subcategory_id'] = $scheme->scheme_subcategory_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['component_id'] = $scheme->component_id;
                                                    $all_schemes[$gkey]['cat'][$key]['sub_cat'][$subkey]['comp'][$cokey]['scheme'][$ckey]['sub_component_id'] = $scheme->sub_component_id;
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
                                                }
                                                // scheme
                                            }
                                            // endif scheme
                                    }
                                    
                                    
                                    // end for component
                                }
                               
                                
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
        }

        $govt_schemes = GovtScheme::all();
        $components = Component::all();
        $subcomponents = SubComponent::where('status',"1")->get();
        $districts = District::all();
        $user= new User;
        $sdistrict= $user->officer();
        $blocks= Tehsil::where('district_id',$sdistrict->assigned_district)->get();

        return view('admin.targetset.blockedit',['districts'=>$districts,'blocks'=>$blocks,'sblock'=>(auth()->user()->role_id==4) ? $request->block_id : ($sdistrict->assigned_tehsil),'sdistrict'=>$sdistrict->assigned_district,'year'=>$request->year,'subcomponents'=>$subcomponents,'components' => $components,'scheme_category'=>$scheme_category,'govt_schemes' => $govt_schemes, 'scheme_subcategory' => $all_schemes]);
    }

    public static function updateBlockSubsidy(Request $request){

        // $targets = TargetState::where('id',)->update();
        $all_targets = $request->target_id;
        $all_private_targets = $request->private_target_id;
        $all_district_targets = $request->target_district_id;
        $all_private_target_district_ids = $request->private_target_district_id;
        $all_remarks = $request->district_remarks;
        $all_private_remarks = $request->district_private_remarks;
        $all_private_gen_targets = $request->private_gen_target;
        $all_private_sc_targets = $request->private_sc_target;
        $all_private_st_targets = $request->private_st_target;
        $all_private_women_targets = $request->private_women_target;
        $all_gen_targets = $request->gen_target;
        $all_sc_targets = $request->sc_target;
        $all_st_targets = $request->st_target;
        $all_women_targets = $request->women_target;
        $year = $request->year;
        $district = $request->district_id;
        $block = $request->block_id;
        // dd($request->private_gen_target);
        
        // foreach($all_targets as $key=> $target){ 
        //     $targets = TargetBlock::where('district_id',$district)->where('tehsil_id',$block)->where('target_state_id',$target)->where('target_district_id',$all_district_targets[$key])->first();           
        //     if(empty($all_district_targets[$key]) && empty($targets)){                
        //         $targets = TargetBlock::create([
        //             'district_id'=> $district,
        //             'tehsil_id'=> $block, 
        //             'target_district_id'=>$all_district_targets[$key], 
        //             'target_state_id'=>$target, 
        //             'assigned_physical_target'=>((float)$all_gen_targets[$key]+(float)$all_sc_targets[$key]+(float)$all_st_targets[$key]+(float)$all_women_targets[$key]), 
        //             'district_remarks'=>$all_remarks[$key], 
        //             'district_year' => $year,                  
        //             'assigned_gen_target' => $all_gen_targets[$key],
        //             'assigned_sc_target' => $all_sc_targets[$key],
        //             'assigned_st_target' => $all_st_targets[$key],
        //             'assigned_women_target' => $all_women_targets[$key]
        //         ]);
        //     }else{
        //         $targets = TargetBlock::where('id', $targets->id)->update([
        //             'district_id'=> $district,
        //             'tehsil_id'=> $block, 
        //             'target_district_id'=>$all_district_targets[$key], 
        //             'target_state_id'=>$target, 
        //             'assigned_physical_target'=>((float)$all_gen_targets[$key]+(float)$all_sc_targets[$key]+(float)$all_st_targets[$key]+(float)$all_women_targets[$key]), 
        //             'district_remarks'=>$all_remarks[$key], 
        //             'district_year' => $year,
        //             'district_id' => $district,                     
        //             'assigned_gen_target' => $all_gen_targets[$key],
        //             'assigned_sc_target' => $all_sc_targets[$key],
        //             'assigned_st_target' => $all_st_targets[$key],
        //             'assigned_women_target' => $all_women_targets[$key]
        //         ]);
        //     }
        // }

        // foreach($all_private_targets as $key=> $target){ 
        //     $targets = TargetBlock::where('district_id',$district)->where('target_state_id',$target)->first();           
        //     if(empty($all_district_targets[$key]) && empty($targets)){                
        //         $targets = TargetBlock::create([
        //             'district_id'=> $district,
        //             'tehsil_id'=> $block, 
        //             'target_district_id'=>$all_district_targets[$key], 
        //             'target_state_id'=>$target,                     
        //             'assigned_private_physical_target'=>((float)$all_private_gen_targets[$key]+(float)$all_private_sc_targets[$key]+(float)$all_private_st_targets[$key]+(float)$all_private_women_targets[$key]),
        //             'district_private_remarks'=>$all_private_remarks[$key], 
        //             'district_year' => $year,
        //             'assigned_private_gen_target' => $all_private_gen_targets[$key], 
        //             'assigned_private_sc_target'=>$all_private_sc_targets[$key],
        //             'assigned_private_st_target'=> $all_private_st_targets[$key], 
        //             'assigned_private_women_target'=>$all_private_women_targets[$key],
        //             'district_id' => $district                    
        //         ]);
        //     }else{
        //         $targets = TargetBlock::where('id', $targets->id)->update([
        //             'district_id'=> $district,
        //             'tehsil_id'=> $block, 
        //             'target_district_id'=>$all_district_targets[$key], 
        //             'target_state_id'=>$target,                     
        //             'assigned_private_physical_target'=>((float)$all_private_gen_targets[$key]+(float)$all_private_sc_targets[$key]+(float)$all_private_st_targets[$key]+(float)$all_private_women_targets[$key]),
        //             'district_private_remarks'=>$all_private_remarks[$key], 
        //             'district_year' => $year,
        //             'assigned_private_gen_target' => $all_private_gen_targets[$key], 
        //             'assigned_private_sc_target'=>$all_private_sc_targets[$key],
        //             'assigned_private_st_target'=> $all_private_st_targets[$key], 
        //             'assigned_private_women_target'=>$all_private_women_targets[$key],
        //             'district_id' => $district
        //         ]);
        //     }
        // }

        return redirect()->route('manage-subsidy-block')->with('success','Schemes updated successfully!');
        
    }

}
