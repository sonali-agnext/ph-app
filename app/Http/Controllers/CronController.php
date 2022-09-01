<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MarketPrice;
use Youtube;
use App\Models\YoutubeVideo;

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
        dd($views);
        $channels = Youtube::listChannelVideos('UCuVuHrghkZeJHQTjesosDJA', 10, "date");

        if(!empty($channels)){
            foreach($channels as $key=>$channel){
                $etag = $channel->etag;
                $video_id = $channel->id->videoId;
                $channel_id = $channel->snippet->channelId;
                
                $thumbnail = $channel->snippet->thumbnails->medium->url;
                $publish_time = $channel->snippet->publishTime;

                $find_video = YoutubeVideo::where('video_id',$video_id)->first();
                if($channel->snippet->categoryId == 27){
                    if(empty($find_video)){
                        
                        if(date('Y-m-d',strtotime($publish_time)) == date('Y-m-d')){
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
                if($channel->snippet->categoryId == 27){
                    if(empty($find_video)){
                        
                        if(date('Y-m-d',strtotime($publish_time)) == date('Y-m-d')){
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
}
