<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MarketPrice;
use Youtube;
use App\Models\YoutubeVideo;
use App\Models\AppliedScheme;
use App\Models\User;
use App\Models\Notification;

class CronController extends Controller
{
    public static function marketPrice(){
        $url = "https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070?api-key=579b464db66ec23bdd00000130f88bbd72284d907187f59550b17975&format=json&limit=7845";
        $response = Http::get($url);
        $contents = $response->getBody()->getContents();
        $data = json_decode($contents);

        if(!empty($data->records)){
            $records = $data->records;
            foreach($records as $record){
                if($record->state == "Punjab"){
                    $market_prices = MarketPrice::where('district', $record->district)->where('market',$record->market)->where('commodity',$record->commodity)->where('variety',$record->variety)->first();

                    $date = str_replace('/', '-', $record->arrival_date);
                    if(empty($market_prices)){
                        $market = MarketPrice::create(['state'=>$record->state, 'district'=>$record->district, 'market'=>$record->market, 'commodity'=>$record->commodity, 'variety'=>$record->variety, 'arrival_date'=>date('Y-m-d', strtotime($date)), 'min_price'=>$record->min_price, 'max_price'=>$record->max_price, 'modal_price'=>$record->modal_price]);
                    }else{
                        $market = MarketPrice::where('id', $market_prices->id)->update(['state'=>$record->state, 'district'=>$record->district, 'market'=>$record->market, 'commodity'=>$record->commodity, 'variety'=>$record->variety, 'arrival_date'=>date('Y-m-d', strtotime($date)), 'min_price'=>$record->min_price, 'max_price'=>$record->max_price, 'modal_price'=>$record->modal_price]);
                    }
                }
            }
        }
    }

    public static function latestVideos(){
        $views = Youtube::getVideoInfo('fUJ9y3VmiZA');
        $channels = Youtube::listChannelVideos('UCuVuHrghkZeJHQTjesosDJA', 10, "date");

        if(!empty($channels)){
            foreach($channels as $key=>$channel){
                $etag = $channel->etag;
                $video_id = $channel->id->videoId;
                $channel_id = $channel->snippet->channelId;
                
                $thumbnail = $channel->snippet->thumbnails->medium->url;
                $publish_time = $channel->snippet->publishTime;

                $find_video = YoutubeVideo::where('video_id',$video_id)->first();
                // print_r($channel);
                if($channel->id->kind == "youtube#video"){
                    if(empty($find_video)){
                        
                        if(date('Y-m-d',strtotime($publish_time)) <= date('Y-m-d')){
                            $views = Youtube::getVideoInfo($video_id);
                            $title = $views->snippet->title;
                            $description = $views->snippet->description;
                            $view_count = $views->statistics->viewCount;
                            
                            $create_video = YoutubeVideo::create([
                                'etag' => $etag,
                                'video_id' => $video_id,
                                'channel_id' => $channel_id,
                                'title' => $title,
                                'description' => $description,
                                'thumbnail' => $thumbnail,
                                'views' => $view_count,
                                'publish_time' => date('Y-m-d H:i:s',strtotime($publish_time))
                            ]);
                        }
                    }else{
                            $views = Youtube::getVideoInfo($video_id);
                            $title = $views->snippet->title;
                            $description = $views->snippet->description;
                            $view_count = $views->statistics->viewCount;
                            
                            $create_video = YoutubeVideo::where('video_id', $video_id)->update([
                                'etag' => $etag,
                                'video_id' => $video_id,
                                'channel_id' => $channel_id,
                                'title' => $title,
                                'description' => $description,
                                'thumbnail' => $thumbnail,
                                'views' => $view_count,
                                'publish_time' => date('Y-m-d H:i:s',strtotime($publish_time))
                            ]);
                    }
                }
            }
        }

        $channel2s = Youtube::listChannelVideos('UCnjxYF8TSTdBDf27ULeDR7Q', 10, "date");

        if(!empty($channel2s)){
            foreach($channel2s as $key2=>$channel){
                $etag = $channel->etag;
                $video_id = $channel->id->videoId;
                $channel_id = $channel->snippet->channelId;
                $title = $channel->snippet->title;
                $description = $channel->snippet->description;
                $thumbnail = $channel->snippet->thumbnails->medium->url;
                $publish_time = $channel->snippet->publishTime;

                $find_video = YoutubeVideo::where('video_id',$video_id)->first();
                if($channel->id->kind == "youtube#video"){
                    if(empty($find_video)){
                        
                        if(date('Y-m-d',strtotime($publish_time)) <= date('Y-m-d')){
                            $views = Youtube::getVideoInfo($video_id);
                            $title = $views->snippet->title;
                            $description = $views->snippet->description;
                            $view_count = $views->statistics->viewCount;
                            
                            $create_video = YoutubeVideo::create([
                                'etag' => $etag,
                                'video_id' => $video_id,
                                'channel_id' => $channel_id,
                                'title' => $title,
                                'description' => $description,
                                'thumbnail' => $thumbnail,
                                'views' => $view_count,
                                'publish_time' => date('Y-m-d H:i:s',strtotime($publish_time))
                            ]);
                        }
                    }else{
                            $views = Youtube::getVideoInfo($video_id);
                            $title = $views->snippet->title;
                            $description = $views->snippet->description;
                            $view_count = $views->statistics->viewCount;
                            $create_video = YoutubeVideo::where('video_id', $video_id)->update([
                                'etag' => $etag,
                                'video_id' => $video_id,
                                'channel_id' => $channel_id,
                                'title' => $title,
                                'description' => $description,
                                'thumbnail' => $thumbnail,
                                'views' => $view_count,
                                'publish_time' => date('Y-m-d H:i:s',strtotime($publish_time))
                            ]);
                    }
                }
            }
        }
        
    }
    public static function getAllMoveSchemes(){
        $farmers = AppliedScheme::select('applied_schemes.*','applied_schemes.tehsil_id as a_tehsil', 'applied_schemes.district_id as a_district','applied_schemes.status as applied_status','applied_schemes.id as apply_id','farmers.*', 'farmers.id as ffarmer_id','schemes.*','schemes.id as sscheme_id','cities.city_name','districts.district_name','tehsils.tehsil_name', 'applicant_types.applicant_type_name', 'caste_categories.caste_name', 'users.status','applied_schemes.created_at as acreated_at','applied_schemes.updated_at as aupdated_at')
        ->join('farmers','farmers.id','=','applied_schemes.farmer_id')
        ->join('schemes','schemes.id','=','applied_schemes.scheme_id')
        ->join('cities','farmers.city_id','=','cities.id')
        ->join('users','farmers.user_id','=','users.id')
        ->join('districts','farmers.district_id','=','districts.id')
        ->join('tehsils','farmers.tehsil_id','=','tehsils.id')
        ->join('applicant_types','farmers.applicant_type_id','=','applicant_types.id')
        ->join('caste_categories','farmers.caste_category_id','=','caste_categories.id')
        ->get();
        if(!empty($farmers)){
            foreach($farmers as $key => $farmer){
                if($farmer->stage == 'Tehsil' && empty($farmer->tehsil_updated) && ($farmer->applied_status == "In Progress")){

                    $date1= date('Y-m-d',strtotime($farmer->aupdated_at.'+7 day'));
                    $date2= date('Y-m-d');
                    $date11 = date_create($date1);
                    $date22 = date_create($date2);

                    $dateDifference = date_diff($date11, $date22)->format('%d');
                    if(empty($dateDifference) && $farmer->stage == "Tehsil"){
                        $user = new User;
                        $districtInfo =$user->officerdistrict($farmer->a_district);
                        $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                            'stage' => 'District',
                            'tehsil_updated' => date('Y-m-d H:i:s'),
                            'status' => 'Auto Approved',
                            'district_status' => 'In Progress',
                            'approved_district' => $districtInfo->officer_id,
                            'attempts' => 0
                        ]);
                        Notification::create([
                            'user_id' => $districtInfo->user_id,
                            'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                        ]);
                    }
                }
                if($farmer->stage == 'Tehsil' && !empty($farmer->tehsil_updated) && ($farmer->applied_status == "Resubmit") && (!empty($farmer->attempts))){
                    if($farmer->attempts < 3){
                        $date1= date('Y-m-d',strtotime($farmer->district_updated.'+7 day'));
                        $date2= date('Y-m-d');
                        $date11 = date_create($date1);
                        $date22 = date_create($date2);

                        $dateDifference = date_diff($date11, $date22)->format('%d');
                        if(empty($dateDifference) && $farmer->stage == "Tehsil"){
                            $user = new User;
                            $districtInfo =$user->officerdistrict($farmer->a_district);
                            $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                                'stage' => 'District',
                                'tehsil_updated' => date('Y-m-d H:i:s'),
                                'status' => 'Auto Approved',
                                'district_status' => 'In Progress',
                                'approved_district' => $districtInfo->officer_id,
                                'attempts' => 0
                            ]);
                            Notification::create([
                                'user_id' => 1,
                                'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                            ]);
                            Notification::create([
                                'user_id' => $districtInfo->user_id,
                                'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                            ]);
                        }
                    }else{
                        $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                            'stage' => 'State',
                            'tehsil_updated' => date('Y-m-d H:i:s'),
                            'status' => 'Rejected',
                        ]);
                        $user = new User;
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Auto Rejected Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                        ]);
                        $stateInfo = $user->officerstate();
                        if(!empty($stateInfo)){
                            foreach($stateInfo as $state){
                                Notification::create([
                                    'user_id' => $state->user_id,
                                    'message'=>('Auto Rejected Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                                ]);
                            }
                        }
                        if($farmer->reattempts > 3){
                            $user_info = auth()->user()->farmer($farmer->farmer_id);
                            if(!empty($user_info)){
                                    $user_id = $user_info->id;
                                    $users = User::find($user_id);
                                    $users->update(['status' => 2]);
                            }
                        }
                    }
                }
                if($farmer->stage == 'Distict' && empty($farmer->district_updated) && ($farmer->applied_status == "In Progress")){

                    $date1= date('Y-m-d',strtotime($farmer->aupdated_at.'+7 day'));
                    $date2= date('Y-m-d');
                    $date11 = date_create($date1);
                    $date22 = date_create($date2);

                    $dateDifference = date_diff($date11, $date22)->format('%d');

                    if(empty($dateDifference) && $farmer->stage == "District"){
                        $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                            'stage' => 'State',
                            'district_updated' => date('Y-m-d H:i:s'),
                            'district_status' => 'Auto Approved',
                            'attempts' => 0
                        ]);
                        $user = new User;
                        $stateInfo =$user->officerstate();
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                        ]);
                        if(!empty($stateInfo)){
                            foreach($stateInfo as $state){
                                Notification::create([
                                    'user_id' => $state->user_id,
                                    'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                                ]);
                            }
                        }
                        
                    }
                }
                if($farmer->stage == 'District' && !empty($farmer->district_updated) && ($farmer->applied_status == "Resubmit") && (!empty($farmer->attempts))){
                    if($farmer->attempts < 3){
                        $date1= date('Y-m-d',strtotime($farmer->district_updated.'+7 day'));
                        $date2= date('Y-m-d');
                        $date11 = date_create($date1);
                        $date22 = date_create($date2);

                        $dateDifference = date_diff($date11, $date22)->format('%d');
                        if(empty($dateDifference) && $farmer->stage == "District"){
                            $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                                'stage' => 'State',
                                'district_updated' => date('Y-m-d H:i:s'),
                                'district_status' => 'Auto Approved',
                                'attempts' => 0
                            ]);
                            Notification::create([
                                'user_id' => 1,
                                'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                            ]);
                            $user = new User;
                            $stateInfo =$user->officerstate();
                            if(!empty($stateInfo)){
                                foreach($stateInfo as $state){
                                    Notification::create([
                                        'user_id' => $state->user_id,
                                        'message'=>('Auto Approved Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                                    ]);
                                }
                            }
                        }
                    }else{
                        $applied_schemes = AppliedScheme::where('id', $farmer->apply_id)->update([
                            'stage' => 'State',
                            'district_updated' => date('Y-m-d H:i:s'),
                            'district_status' => 'Rejected',
                        ]);
                        if($farmer->reattempts > 3){
                            $user_info = auth()->user()->farmer($farmer->farmer_id);
                            if(!empty($user_info)){
                                    $user_id = $user_info->id;
                                    $users = User::find($user_id);
                                    $users->update(['status' => 2]);
                            }
                        }
                        $user = new User;
                        Notification::create([
                            'user_id' => 1,
                            'message'=>('Auto Rejected Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                        ]);
                        $stateInfo = $user->officerstate();
                        if(!empty($stateInfo)){
                            foreach($stateInfo as $state){
                                Notification::create([
                                    'user_id' => $state->user_id,
                                    'message'=>('Auto Rejected Application Received <a href="/view-applied-scheme?id='.$applied_schemes->id.'">Click to view</a>')
                                ]);
                            }
                        }
                    }
                }
            }
        }
        
    }
}
