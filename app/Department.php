<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $connection= 'mysql2';

    protected $table = 'dmc_division_code';
}
