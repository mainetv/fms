<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BpForm4BModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [
        'division_id', 
        'year', 
        'tier', 
        'fiscal_year', 
        'description', 
        'area_sqm', 
        'location', 
        'amount', 
        'num_years_completion', 
        'date_started', 
        'total_cost', 
        'justification', 
        'remarks', 
        'is_active', 
        'is_deleted'
    ];
    protected $table = 'bp_form4b';
}
