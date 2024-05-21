<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AdjustmentModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		
		'allotment_id', 
		'adjustment_type_id', 		
		'date', 		
		'reference_no', 		
		'q1_adjustment', 		
		'q2_adjustment', 		
		'q3_adjustment', 		
		'q4_adjustment', 	
		'remarks',				
		'is_active', 
		'is_deleted'
	];
    protected $table = 'adjustment';
}
