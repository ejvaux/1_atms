<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $table = 'dmc_division_code';
    protected $connection = 'mysql2';

    public function tickets()
    {
        return $this->hasMany('App\Ticket','id');
    }
}
