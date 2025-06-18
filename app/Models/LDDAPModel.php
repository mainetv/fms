<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LDDAPModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'ada_id',
        'lddap_no',
        'lddap_date',
        'payment_mode_id',
        'fund_id',
        'nca_no',
        'bank_account_id',
        'check_no',
        'acic_no',
        'total_lddap_gross_amount',
        'total_lddap_net_amount',
        'signatory1',
        'signatory1_position',
        'signatory2',
        'signatory2_position',
        'signatory3',
        'signatory3_position',
        'signatory4',
        'signatory4_position',
        'signatory5',
        'signatory5_position',
        'date_transferred',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'lddap';
}
