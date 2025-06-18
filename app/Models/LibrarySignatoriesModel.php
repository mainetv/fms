<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class LibrarySignatoriesModel extends Model implements Auditable
{
    use HasFactory;
    use \OwenIt\Auditing\Auditable;

    public $fillable = [
        'user_id',
        'module',
        'form',
        'tags',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'library_signatories';
}
