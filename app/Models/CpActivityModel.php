<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpActivityModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'cp_id', 
		'cp_pap_id', 
		'activity_id', 
		'remarks', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
	protected $table = 'cp_activity';
}
