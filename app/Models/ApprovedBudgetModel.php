<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ApprovedBudgetModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'reference_bp_id', 
		'division_id', 
		'year', 		
		'pap_id', 		
		'activity_id', 		
		'subactivity_id', 		
		'expense_account_id', 		
		'object_expenditure_id', 		
		'object_specific_id', 		
		'pooled_at_division_id', 		
		'annual_amount', 				
		'is_active', 
		'is_deleted'
	];
	protected $table = 'approved_budget';
}
