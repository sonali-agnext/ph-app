<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'message', 'read_status'
    ];
}