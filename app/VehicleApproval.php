<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VehicleApproval extends Model
{
    public function vehiclerequest()
    {
        return $this->belongsTo('App\VehicleRequest','vehicle_request_id');
    }
    public function approval()
    {
        return $this->belongsTo('App\VehicleApprovalType','approval_id');
    }
    public function approver()
    {
        return $this->belongsTo('App\User','approver_id');
    }
}
