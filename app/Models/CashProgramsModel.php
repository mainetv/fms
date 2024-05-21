<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CashProgramsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'reference_allotment_id', 
		'division_id', 
		'year', 		
		'pap_id', 		
		'activity_id', 		
		'subactivity_id', 		
		'expense_account_id', 		
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
		'is_active', 
		'is_deleted'
	];
	protected $table = 'monthly_cash_programs';
}
