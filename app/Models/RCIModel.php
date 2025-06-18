<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RCIModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'rci_date',
        'rci_no',
        'fund_id',
        'bank_account_id',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'rci';
}
