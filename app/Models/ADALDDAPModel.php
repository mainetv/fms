<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ADALDDAPModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'ada_id',
        'lddap_id',
        'check_no',
        'ps_amount',
        'mooe_amount',
        'ps_amount',
        'co_amount',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'ada_lddap';
}
