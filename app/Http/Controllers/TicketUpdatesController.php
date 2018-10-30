<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TicketUpdates;
use App\Ticket;
use App\Custom\NotificationFunctions;
class TicketUpdatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
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
        NotificationFunctions::ticketupdate($request->input('ticket_id'));
        return redirect()->back()->with('success','Update Submitted Successfully.');
        /* return redirect('/notification/ticketupdate/'.$request->input('ticket_id')); */       
        /* return redirect('/it/vt/'.$request->input('ticket_id'))->with('success','Update Submitted Successfully.');  */     
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
