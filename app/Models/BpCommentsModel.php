<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class BpCommentsModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'id',
        'division_id',
        'year',
        'budget_proposal_id',
        'comment',
        'comment_by',
        'comment_by_user_id',
        'is_resolved',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'bp_comments';
}
