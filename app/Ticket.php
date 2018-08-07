<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }

    public function priority()
    {
        return $this->belongsTo('App\Priority','priority_id');
    }
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }
    public function status()
    {
        return $this->belongsTo('App\Status','status_id');
    }
    public function assign()
    {
        return $this->belongsTo('App\User','assigned_to');
    }
}
