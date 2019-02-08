<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Kyslik\ColumnSortable\Sortable;

class VehicleRequest extends Model
{
    use Sortable;

    protected $fillable = [''];

    public $sortable = ['id','requested_date'];

    public function createdBy()
    {
        return $this->belongsTo('App\User','created_by');
    }
    public function vehicle()
    {
        return $this->belongsTo('App\Vehicle','vehicle_id');
    }
    public function department()
    {
        return $this->belongsTo('App\Department','department_id');
    }
    public function approval()
    {
        return $this->belongsTo('App\VehicleApprovalType','approval_id');
    }
}
