<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use OwenIt\Auditing\Contracts\Auditable;

class RsPapModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
        'allotment_id', 
        'rs_id', 
        'amount',              
        'notice_adjustment_no',         
        'notice_adjustment_date',         
        'is_active',         
        'is_deleted',         
    ];
    protected $table = 'rs_pap';

    public function allotment() : HasMany
	{
		return $this->hasMany(AllotmentModel::class, 'allotment_id');
	} 

	public function rs() : HasMany
	{
		return $this->hasMany(RSModel::class, 'rs_id');
	} 
}
