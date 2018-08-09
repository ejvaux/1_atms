<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketUpdates;

class TicketUpdatesController extends Controller
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
            'ticket_id' => 'required',
            'user_id' => 'required',
            'message' => 'required',
        ]);

        // Create ticket update
        $tu = new TicketUpdates;
        $tu->ticket_id = $request->input('ticket_id');
        $tu->user_id = $request->input('user_id');
        $tu->message = $request->input('message');
        $tu->save();
        if($request->input('mod') == 'default'){
            return redirect('/it/vt/'.$request->input('ticket_id'))->with('success','Comment Submitted Successfully.');           
        }
        elseif($request->input('mod') == 'admin'){            
            /* return redirect('/it/ac')->with('success','Ticket Submitted Successfully.'); */
        }

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
        //
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
