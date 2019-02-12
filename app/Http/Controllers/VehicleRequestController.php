<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Custom\NotificationFunctions;
use App\Custom\CustomFunctions;
use App\VehicleSerials;
use App\VehicleRequest;

class VehicleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'requested_date' => 'required',
            'departure_time' => 'required',
            'arrival_time' => 'required', 
            'user' => 'required',          
            'position' => 'required',
            'purpose' => 'required',
        ]);

        /* 
        *
        *   Create Vehicle Request
        *
        */

        // Generate and Save serial
        $vr_serial = CustomFunctions::generateVehicleRequestNumber();
        $s = new VehicleSerials;
        $s->number =  $vr_serial;
        $s->save();

        // Get serial number
        $i = VehicleSerials::where('number',$vr_serial)->first();

        // Insert New Vehicle Request
        $t = new VehicleRequest;
        $t->id = $i->id;
        $t->vehicle_request_serial = $i->number;
        $t->user = $request->input('user');
        $t->position = $request->input('position');
        $t->purpose = $request->input('purpose');
        $t->requested_date = $request->input('requested_date');
        $t->departure_time = $request->input('departure_time');
        $t->arrival_time = $request->input('arrival_time');
        $t->department_id = $request->input('department_id');
        $t->created_by = $request->input('created_by');
        $t->approval_id = 1;        
        $t->save();

        // Sending Notifications
        /* $vrequest = VehicleRequest::where('vehicle_request_serial', $i->id)->first(); */
        NotificationFunctions::approvevehiclerequest(1,$i->id,$request->input('department_id'));
        return redirect()->back()->with('success','Vehicle Request Submitted Successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $vr = VehicleRequest::find($id);

        if($request->input('user') != ""){ $vr->user = $request->input('user');}
        if($request->input('position') != ""){ $vr->position = $request->input('position');}
        if($request->input('purpose') != ""){ $vr->purpose = $request->input('purpose');}
        if($request->input('requested_date') != ""){ $vr->requested_date = $request->input('requested_date');}
        if($request->input('departure_time') != ""){ $vr->departure_time = $request->input('departure_time');}
        if($request->input('arrival_time') != ""){ $vr->arrival_time = $request->input('arrival_time');}
        if($request->input('department_id') != ""){ $vr->department_id = $request->input('department_id');}
        
        if($request->input('driver') != ""){ $vr->driver = $request->input('driver');}
        if($request->input('vehicle_id') != ""){ $vr->vehicle_id = $request->input('vehicle_id');}
        if($request->input('remarks') != ""){ $vr->remarks = $request->input('remarks');}

        if($request->input('approval_id') != ""){ $vr->approval_id = $request->input('approval_id');}

        $vr->save();
        return redirect()->back()->with('success','Vehicle Request Updated Successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
