<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppliedScheme extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'farmer_id', 
        'scheme_id', 
        'land_applied', 
        'land_address_id', 
        'project_note', 
        'technical_datasheet', 
        'bank_sanction', 
        'quotation_solar', 
        'site_plan', 
        'partnership_deep', 
        'pan_aadhar', 
        'location_plan', 
        'land_documents', 
        'self_declaration', 
        'other_documents', 
        'state', 
        'district_id', 
        'tehsil_id', 
        'status', 
        'reason', 
        'application_number',
        'applied_schemes',
        'district_updated',
        'tehsil_updated',
        'approved_tehsil',
        'approved_district',
        'public_private'
    ];
}
