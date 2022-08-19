<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPrice extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'state', 'district', 'market', 'commodity', 'variety', 'arrival_date', 'min_price', 'max_price', 'modal_price'
    ];
}