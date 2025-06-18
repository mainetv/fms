<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RSModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'rs_type_id',
        'rs_no',
        'rs_date',
        'rs_date1',
        'division_id',
        'fund_id',
        'payee_id',
        'particulars',
        'total_rs_activity_amount',
        'total_rs_pap_amount',
        'showall',
        'signatory1',
        'signatory1_position',
        'signatory1b',
        'signatory1b_position',
        'signatory2',
        'signatory2_position',
        'signatory3',
        'signatory3_position',
        'signatory4',
        'signatory4_position',
        'signatory5',
        'signatory5_position',
        'is_locked',
        'is_active',
        'is_deleted',
        'locked_at',
        'cancelled_at',
    ];

    protected $table = 'request_status';
}
