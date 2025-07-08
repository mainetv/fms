<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class ChartAccount extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;
    public $fillable = [
        'level_id',
        'parent_id',
        'name',
        'uacs',
        'subobject_code', 
        'is_active', 
    ];

    protected $table = 'chart_accounts';

    public function children()
    {
        return $this->hasMany(ChartAccount::class, 'parent_id')->with('children');
    }

}
