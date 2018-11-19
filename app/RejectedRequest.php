<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class RejectedRequest extends Model
{
    use Sortable;

    protected $fillable = ['created_at','updated_at'];

    public $sortable = ['id', 'request_id', 'user_id', 'department_id','priority_id','status_id','subject','assigned_to','start_at','finish_at', 'created_at', 'updated_at'];

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
    public function status()
    {
        return $this->belongsTo('App\ReviewStatus','status_id');
    }
    public function locationname()
    {
        return $this->belongsTo('App\Location','location');
    }
    public function assign()
    {
        return $this->belongsTo('App\User','assigned_to');
    }
    public function approver()
    {
        return $this->belongsTo('App\User','approver_id');
    } 
}
