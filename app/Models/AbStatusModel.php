<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class AbStatusModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
        'division_id', 
        'year', 
        'status_id', 
        'status_by_user_id',
        'status_by_user_role_id',
        'status_by_user_division_id',
        'date', 
        'is_active', 
        'is_deleted'
        ];
    protected $table = 'ab_status';
}
