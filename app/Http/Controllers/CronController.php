<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\MarketPrice;

class CronController extends Controller
{
    public function marketPrice(){
        $url = "https://api.data.gov.in/resource/9ef84268-d588-465a-a308-a864a43d0070?api-key=579b464db66ec23bdd00000130f88bbd72284d907187f59550b17975&format=json&limit=7845";
        $response = Http::get($url);
        $contents = $response->getBody()->getContents();
        $data = json_decode($contents);

        if(!empty($data->records)){
            $records = $data->records;
            foreach($records as $record){
                if($record->state == "Punjab"){
                    $market_prices = MarketPrice::where('district', $record->district)->where('market',$record->market)->where('market',$record->commodity)->where('market',$record->variety)->first();
 
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
}
