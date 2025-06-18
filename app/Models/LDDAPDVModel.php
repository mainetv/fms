<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LDDAPDVModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'lddap_id',
        'dv_id',
        'order_no',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'lddap_dv';
}
