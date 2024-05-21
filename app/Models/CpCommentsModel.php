<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class CpCommentsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [
        'id', 
        'cash_program_id',  
        'comment',  
        'comment_by', 
        'is_resolved', 
        'is_active', 
        'is_deleted'
      ];
    protected $table = 'cp_comments';
}
