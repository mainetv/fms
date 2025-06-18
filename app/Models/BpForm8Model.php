<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BpForm8Model extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'division_id',
        'year',
        'fiscal_year',
        'name',
        'proposed_date',
        'destination',
        'amount',
        'purpose_travel',
        'remarks',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'bp_form8';
}
