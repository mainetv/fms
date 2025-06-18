<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibrarySubactivityModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'subactivity',
        'description',
        'activity_id',
        'division_id',
        'remarks',
        'tags',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_subactivity';
}
