<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id',
        'avatar'
    ];
}