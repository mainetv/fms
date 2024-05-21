<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DvTransactionTypeModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
        'dv_id', 
        'dv_transaction_type_id', 
        'is_active', 
        'is_deleted', 
    ];
    protected $table = 'dv_transaction_type';
}
