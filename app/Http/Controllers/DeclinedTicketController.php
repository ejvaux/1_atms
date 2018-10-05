<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DeclinedTicket;
use Auth;
use App\Ticket;
use App\TicketUpdates;

class DeclinedTicketController extends Controller
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
        //
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
    public function transferticket(Request $request,$id)
    {        
        $ticket = Ticket::find($id);
        $userid = $ticket->user_id;
        /* $newticket = $ticket->replicate();
        unset($newticket['created_at'],$newticket['updated_at']);   */          
        $t = new DeclinedTicket;
        $t->id = $ticket->id;
        $t->user_id = $ticket->user_id;
        $t->ticket_id = $ticket->ticket_id;
        $t->department_id = $ticket->department_id;
        $t->category_id = $ticket->category_id;
        $t->priority_id = $ticket->priority_id;
        $t->status_id = 7;
        $t->subject = $ticket->subject;
        $t->message = $ticket->message;
        $t->assigned_to = $ticket->assigned_to;
        $t->root = $ticket->root;
        $t->action = $ticket->action;
        $t->result = $ticket->result;
        $t->recommend = $ticket->recommend;
        $t->instruction = $ticket->instruction;
        $t->start_at = $ticket->start_at;
        $t->finish_at = $ticket->finish_at;
        $t->attach = $ticket->attach;
        $t->created_at = $ticket->created_at;
        $t->updated_at = $ticket->updated_at;
        if($request->input('reason') != ""){ $t->reason = $request->input('reason');}

        $mail = new \stdClass();
        $mail->user = $ticket->user->name;   
        $mail->ticketnum = $ticket->id;
        $mail->url = $request->input('url');
        $emailuser = $ticket->user->email;
        $techid = $ticket->assigned_to;

        $t->save();
        if($t->save()){
            Ticket::where('id',$id)->delete();
            $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = Auth::user()->id;
            $tu->message = "Ticket Declined.";
            $tu->save(); 
            return redirect('/notification/ticketdecline/'.$userid.'/'.$mail->ticketnum);               
        }           
    }
}
