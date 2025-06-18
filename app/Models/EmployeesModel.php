<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeesModel extends Model
{
    protected $connection = 'mysql_hrms';

    protected $table = 'view_fms_users';
}
