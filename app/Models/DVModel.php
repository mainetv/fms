<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DVModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'fais_id',
        'lddap_id',
        'check_id',
        'dv_no',
        'dv_date',
        'dv_date1',
        'division_id',
        'fund_id',
        'payee_id',
        'particulars',
        'total_dv_gross_amount',
        'total_dv_net_amount',
        'signatory1',
        'signatory1_position',
        'signatory2',
        'signatory2_position',
        'tax_type_id',
        'pay_type_id',
        'date_out',
        'out_to',
        'received_from',
        'date_returned',
        'po_no',
        'po_date',
        'invoice_no',
        'invoice_date',
        'jobcon_no',
        'jobcon_date',
        'or_no',
        'or_date',
        'cod_no',
        'cancelled_at',
        'locked_at',
        'is_locked',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'disbursement_vouchers';
}
