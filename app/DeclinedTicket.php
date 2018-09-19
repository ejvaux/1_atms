<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class DeclinedTicket extends Model
{
    public $sortable = ['id', 'user_id', 'department_id','category_id','priority_id','status_id','subject','assigned_to','start_at','finish_at', 'created_at', 'updated_at'];

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
