<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class QopCommentsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [
        'qop_id', 
        'comment_by', 
        'is_resolved', 
        'is_active', 
        'is_deleted'
      ];
    protected $table = 'qop_comments';
}
