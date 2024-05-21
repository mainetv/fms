<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryPayeesModel extends Model implements Auditable
{
   use HasFactory;
   use \OwenIt\Auditing\Auditable;
   use \OwenIt\Auditing\Auditable;

   public $fillable = [		 
      'parent_id', 
      'payee_type_id', 
      'organization_type_id', 
      'payee', 
      'previously_named', 
      'organization_name', 
      'organization_acronym', 
      'title', 
      'last_name', 
      'first_name', 
      'middle_initial', 
      'suffix', 
      'tin', 
      'bank_id', 
      'bank_branch', 
      'bank_account_name', 
      'bank_account_name1', 
      'bank_account_name2', 
      'bank_account_no', 
      'address', 
      'office_address', 
      'email_address', 
      'contact_no', 
      'is_verified', 
      'is_active', 
      'is_deleted'
	];
	protected $table = 'library_payees';
}
