<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ADAModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
        'ada_no', 
        'ada_date', 
        'fund_id', 
        'bank_account_id', 
        'check_no', 
        'total_ps_amount', 
        'total_mooe_amount', 
        'total_co_amount',  
        'signatory1', 
        'signatory1_position', 
        'signatory2', 
        'signatory2_position',
        'signatory3', 
        'signatory3_position', 
        'signatory4', 
        'signatory4_position',
        'signatory5', 
        'signatory5_position', 
        'date_transferred', 
        'is_active', 
        'is_deleted',
    ];
    protected $table = 'ada';
}
