<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RSActivityModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
        'allotment_id', 
        'rs_id', 
        'amount',         
        'is_active',         
        'is_deleted',         
    ];
    protected $table = 'rs_activity';
}
