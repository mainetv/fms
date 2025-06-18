<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class DvRsNetModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'dv_no',
        'dv_id',
        'rs_id',
        'gross_amount',
        'tax_one',
        'tax_two',
        'tax_twob',
        'tax_three',
        'tax_four',
        'tax_five',
        'tax_six',
        'wtax',
        'other_tax',
        'liquidated_damages',
        'other_deductions',
        'net_amount',
        'allotment_class_id',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'dv_rs_net';
}
