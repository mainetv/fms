<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RsTypesModel extends Model
{
    protected $connection = 'mysql_comlib';

    protected $table = 'request_status_types';
}
