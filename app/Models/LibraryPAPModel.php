<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryPAPModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [		 
		'pap_code', 
		'pap', 
		'description', 
		'parent_id', 		 
		'request_status_type_id', 
		'division_id',
		'default_all',
		'remarks', 
		'tags', 
		'is_active', 
		'is_deleted'
	];
	protected $table = 'library_pap';

	public function parentPap() : BelongsTo
	{
		return $this->belongsTo(LibraryPAPModel::class, 'parent_id');
	} 
}
