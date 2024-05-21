<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AllotmentModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		
		'division_id', 
		'year', 		
		'rs_type_id', 		
		'allotment_fund_id', 		
		'pap_id', 		
		'activity_id', 		
		'subactivity_id', 		
		'expense_account_id', 		
		'object_expenditure_id', 		
		'object_specific_id', 		
		'pooled_at_division_id', 		
		'q1_allotment',		
		'q2_allotment',		
		'q3_allotment',		
		'q4_allotment',		
		'q1_nca',		
		'q2_nca',		
		'q3_nca',		
		'q4_nca',		
		'q1_adjustment',		
		'q2_adjustment',		
		'q3_adjustment',		
		'q4_adjustment',		
		'is_active', 
		'is_deleted'
	];
    protected $table = 'allotment';
}
