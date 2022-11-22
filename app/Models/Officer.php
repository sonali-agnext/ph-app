<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Officer extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'user_id', 'phone_number', 'designation', 'ihrm','avatar'
    ];
    public function assignedOfficer()
    {
        return $this->belongsTo('App\Models\AssignToOfficer', 'officer_id');
    }
}
