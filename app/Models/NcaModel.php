<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class NcaModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'fund_id',
        'year',
        'jan_nca',
        'feb_nca',
        'mar_nca',
        'apr_nca',
        'may_nca',
        'jun_nca',
        'jul_nca',
        'aug_nca',
        'sep_nca',
        'oct_nca',
        'nov_nca',
        'dec_nca',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'nca';
}
