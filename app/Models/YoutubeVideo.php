<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YoutubeVideo extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'video_id', 'etag', 'channel_id', 'title', 'description', 'thumbnail', 'views','publish_time'
    ];
}
