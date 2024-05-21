<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpObjectExpenditureModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
		'cp_id', 
		'cp_pap_id', 
		'cp_activity_id', 
		'cp_subactivity_id', 
		'cp_expense_account_id', 
		'object_expenditure_id', 
		'object_specific_id', 
      'jan_amount', 		
      'feb_amount', 		
      'mar_amount', 		
      'apr_amount', 		
      'may_amount', 		
      'jun_amount', 		
      'jul_amount', 		
      'aug_amount', 		
      'sep_amount', 		
      'oct_amount', 		
      'nov_amount', 		
      'dec_amount', 		
		'remarks', 
		'comments_by_division_direction', 
		'comments_by_fad_budget', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
	protected $table = 'cp_object_expenditure';
}
