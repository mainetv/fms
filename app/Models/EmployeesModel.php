<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class EmployeesModel extends Model
{
    protected $connection = 'mysql_hrms';
    protected $table = 'view_fms_users';
}
