<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use OwenIt\Auditing\Contracts\Auditable;

class DvRsAccount extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [	
      'dv_rs_net_id',
      'chart_account_id', 
      'amount', 
      'is_active', 
      'is_deleted', 
      'deleted_at', 
   ];
    protected $table = 'dv_rs_accounts';

    public function dvRsNet(): BelongsTo
    {
        return $this->belongsTo(DvRsModel::class, 'dv_rs_net_id');
    }

    public function chartAccount(): BelongsTo
    {
        return $this->belongsTo(ChartAccount::class, 'chart_account_id');
    }
}
