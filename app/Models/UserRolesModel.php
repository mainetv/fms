<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class UserRolesModel extends Model implements Auditable
{
    use HasFactory;
    use HasPermissions;
    use HasRoles;
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'guard_name',
        'username',
        'is_active',
        'is_deleted',
    ];

    protected $table = 'user_roles';
}
