<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketUpdates extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id','id');
    }
}
