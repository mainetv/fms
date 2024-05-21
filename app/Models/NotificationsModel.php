<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NotificationsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'message', 		
		'record_id', 
		'module_id', 
		'link', 
		'month', 
		'year', 
		'date', 
		'division_id', 
		'division_id_from', 
		'division_id_to',
		'user_id_from', 
		'user_id_to', 
		'user_role_id_from', 
		'user_role_id_to', 
		'is_read', 
		'remarks', 
		'is_active', 
		'is_deleted'
	];
    protected $table = 'notifications';
}
