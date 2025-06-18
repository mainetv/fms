<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryObjectExpenditureModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'object_expenditure',
        'account_code',
        'description',
        'expense_account_id',
        'allotment_class_id',
        'is_continuing',
        'request_status_type_id',
        'remarks',
        'tags',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_object_expenditure';

    public function expenseAccount(): BelongsTo
    {
        return $this->belongsTo(LibraryExpenseAccountModel::class, 'expense_account_id');
    }

    public function allotmentClass(): BelongsTo
    {
        return $this->belongsTo(AllotmentClass::class, 'allotment_class_id');
    }

    public function rsType(): BelongsTo
    {
        return $this->belongsTo(RsTypesModel::class, 'request_status_type_id');
    }
}
