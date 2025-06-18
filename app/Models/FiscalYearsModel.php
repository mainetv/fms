<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class FiscalYearsModel extends Model implements Auditable
{
    use HasFactory;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'year',
        'fiscal_year1',
        'fiscal_year2',
        'fiscal_year3',
        'open_date_from',
        'open_date_to',
        'filename',
        'is_locked',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'fiscal_year';
}
