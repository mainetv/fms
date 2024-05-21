<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryObjectExpenditureModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'object_expenditure', 
		'account_code', 
		'description', 
		'expense_account_id', 
		'allotment_class_id', 
		'is_continuing', 
		'request_status_type_id', 
		'remarks', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
    protected $table = 'library_object_expenditure';
}
