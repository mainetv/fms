<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BpForm205Model extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'division_id',
        'year',
        'fiscal_year',
        'retirement_law_id',
        'emp_code',
        'position_id_at_retirement_date',
        'highest_monthly_salary',
        'sl_credits_earned',
        'vl_credits_earned',
        'leave_amount',
        'total_creditable_service',
        'num_gratuity_months',
        'gratuity_amount',
        'remarks',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'bp_form205';
}
