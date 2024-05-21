<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ChecksModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
        'dv_id', 
        'check_date', 
        'check_no', 
        'acic_id',   
        'fund_id',           
        'bank_account_id',           
        'date_released', 
        'is_active', 
        'is_deleted',
    ];
    protected $table = 'checks';
}
