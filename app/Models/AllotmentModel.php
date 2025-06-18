<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class AllotmentModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'division_id',
        'year',
        'rs_type_id',
        'allotment_fund_id',
        'pap_id',
        'activity_id',
        'subactivity_id',
        'expense_account_id',
        'object_expenditure_id',
        'object_specific_id',
        'pooled_at_division_id',
        'q1_allotment',
        'q2_allotment',
        'q3_allotment',
        'q4_allotment',
        'q1_nca',
        'q2_nca',
        'q3_nca',
        'q4_nca',
        'q1_adjustment',
        'q2_adjustment',
        'q3_adjustment',
        'q4_adjustment',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'allotment';

    public function division(): BelongsTo
    {
        return $this->belongsTo(DivisionsModel::class, 'division_id');
    }

    public function rsType(): BelongsTo
    {
        return $this->belongsTo(RsTypesModel::class, 'rs_type_id');
    }

    public function allotmentFund(): BelongsTo
    {
        return $this->belongsTo(AllotmentFundModel::class, 'allotment_fund_id');
    }

    public function pap(): BelongsTo
    {
        return $this->belongsTo(LibraryPAPModel::class, 'pap_id');
    }

    public function activity(): BelongsTo
    {
        return $this->belongsTo(LibraryActivityModel::class, 'activity_id');
    }

    public function subactivity(): BelongsTo
    {
        return $this->belongsTo(LibrarySubactivityModel::class, 'subactivity_id');
    }

    public function expenseAccount(): BelongsTo
    {
        return $this->belongsTo(LibraryExpenseAccountModel::class, 'expense_account_id');
    }

    public function objectExpenditure(): BelongsTo
    {
        return $this->belongsTo(LibraryObjectExpenditureModel::class, 'object_expenditure_id');
    }

    public function objectSpecific(): BelongsTo
    {
        return $this->belongsTo(LibraryObjectSpecificModel::class, 'object_specific_id');
    }

    public function pooledDivision(): BelongsTo
    {
        return $this->belongsTo(DivisionsModel::class, 'pooled_at_division_id');
    }

    public function adjustments(): HasMany
    {
        return $this->hasMany(AdjustmentModel::class);
    }
}
