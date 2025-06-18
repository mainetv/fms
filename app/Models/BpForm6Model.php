<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BpForm6Model extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'division_id',
        'year',
        'tier',
        'fiscal_year',
        'description',
        'quantity',
        'unit_cost',
        'total_cost',
        'organizational_deployment',
        'justification',
        'remarks',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'bp_form6';
}
