<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FarmerBankDetail extends Model
{
    public $timestamps = true;
    protected $fillable = [
        'farmer_id', 'bank_name', 'branch_name','ifsc_code', 'account_no', 'account_name', 'bank_branch_address', 'upload_cancel_check','upload_passbook', 'passbook_no'
    ];
}
