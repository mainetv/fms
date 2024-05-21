<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpPAPModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'cash_program_id', 
		'pap_id', 
		'remarks', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
	protected $table = 'cp_pap';
}
