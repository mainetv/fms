<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RsTypesModel extends Model
{
    protected $connection = 'mysql_comlib';
    protected $table = 'request_status_types';
}
