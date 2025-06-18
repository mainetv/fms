<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BudgetProposalsModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'division_id',
        'year',
        'pap_id',
        'activity_id',
        'subactivity_id',
        'expense_account_id',
        'object_expenditure_id',
        'object_specific_id',
        'pooled_at_division_id',
        'fy1_amount',
        'fy2_amount',
        'fy3_amount',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'budget_proposals';
}
