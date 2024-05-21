<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RsPapModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
        'allotment_id', 
        'rs_id', 
        'amount',              
        'notice_adjustment_no',         
        'notice_adjustment_date',         
        'is_active',         
        'is_deleted',         
    ];
    protected $table = 'rs_pap';
}
