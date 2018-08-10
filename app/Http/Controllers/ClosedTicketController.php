<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\ClosedTicket;

class ClosedTicketController extends Controller
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
        // Create Closed Ticket
        $t = new ClosedTicket;
        $t->id = $request->input('id');
        $t->user_id = $request->input('user_id');
        $t->department_id = $request->input('department_id');
        $t->category_id = $request->input('category_id');
        $t->priority_id = $request->input('priority_id');
        $t->status_id = $request->input('status_id');
        $t->subject = $request->input('subject');
        $t->message = $request->input('message');
        $t->assigned_to = $request->input('assigned_to');
        $t->root = $request->input('root');
        $t->action = $request->input('action');
        $t->result = $request->input('result');
        $t->recommend = $request->input('recommend');
        $t->start_at = $request->input('start_at');
        $t->finish_at = $request->input('finish_at');
        $t->save();
        if($request->input('mod') == 'default'){
            return redirect('/it/ct')->with('success','Ticket Submitted Successfully.');           
        }
        elseif($request->input('mod') == 'escalate'){            
            return redirect('/it/ct')->with('success','Ticket Escalated Successfully.');
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

    public function transferticket(Request $request,$id)
    {
        $ticket = Ticket::find($id);
        $newticket = $ticket->replicate();
        unset($newticket['created_at'],$newticket['updated_at']);
        
        $t = new ClosedTicket;
        $t->id = $ticket->id;
        $t->user_id = $ticket->user_id;
        $t->department_id = $ticket->department_id;
        $t->category_id = $ticket->category_id;
        $t->priority_id = $ticket->priority_id;
        $t->status_id = 6;
        $t->subject = $ticket->subject;
        $t->message = $ticket->message;
        $t->assigned_to = $ticket->assigned_to;
        $t->root = $ticket->root;
        $t->action = $ticket->action;
        $t->result = $ticket->result;
        $t->recommend = $ticket->recommend;
        $t->start_at = $ticket->start_at;
        $t->finish_at = $ticket->finish_at;
        $t->save();
        if($t->save()){
            Ticket::where('id',$id)->delete();
            return 'success';
        }
        
    }
}
