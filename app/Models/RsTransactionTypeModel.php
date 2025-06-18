<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RsTransactionTypeModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'rs_id',
        'rs_transaction_type_id',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'rs_transaction_type';
}
