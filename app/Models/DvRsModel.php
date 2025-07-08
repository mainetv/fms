<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class DvRsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
        'dv_id', 
        'rs_id', 
        'amount', 
        'is_active', 
        'is_deleted', 
        ];
    protected $table = 'dv_rs';

    public function dv(): BelongsTo
    {
        return $this->belongsTo(DVModel::class, 'dv_id');
    }

    public function rs(): BelongsTo
    {
        return $this->belongsTo(RSModel::class, 'rs_id');
    }
}
