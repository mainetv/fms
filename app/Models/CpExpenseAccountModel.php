<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpExpenseAccountModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
		'cp_id', 
		'cp_pap_id', 	 
		'cp_activity_id', 
		'cp_subactivity_id', 
		'expense_account_id',         
		'remarks', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
    protected $table = 'cp_expense_account';
}
