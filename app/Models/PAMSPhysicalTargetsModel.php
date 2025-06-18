<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class PAMSPhysicalTargetsModel extends Model implements Auditable
{
    protected $connection = 'mysql_pams';

    protected $table = 'fms_consolidated_physical_targets';
}
