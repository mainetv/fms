<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class ExpenditureCommentsModel extends Model implements Auditable
{
    use HasFactory;
   use \OwenIt\Auditing\Auditable;
    public $fillable = [
        'expenditure_id', 
        'comment_by_division_director', 
        'comment_by_fad_budget', 
        'by_director_is_resolved', 
        'by_fad_budget_is_resolved', 
        'is_active', 
        'is_deleted'
      ];
      protected $table = 'expenditure_comments';
}
