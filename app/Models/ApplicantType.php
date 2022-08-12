<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantType extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'applicant_type_name'
    ];
}
