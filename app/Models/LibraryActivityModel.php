<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibraryActivityModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'activity',
        'activity_code',
        'description',
        'is_continuing',
        'obligation_type',
        'remarks',
        'tags',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_activity';
}
