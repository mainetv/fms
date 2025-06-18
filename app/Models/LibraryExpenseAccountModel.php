<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryExpenseAccountModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'expense_account',
        'description',
        'activity_id',
        'is_continuing',
        'request_status_type_id',
        'tags',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_expense_account';
}
