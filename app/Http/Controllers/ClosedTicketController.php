<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Ticket;
use App\Mail\TicketClosed;
use App\ClosedTicket;
use App\TicketUpdates;

class ClosedTicketController extends Controller
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
        if($request->input('status_id') == 5){
            $ticket = Ticket::find($id);
            if(!empty($ticket)){
                $userid = $ticket->user_id;
                $newticket = $ticket->replicate();
                unset($newticket['created_at'],$newticket['updated_at']);            
                $t = new ClosedTicket;
                $t->id = $ticket->id;
                $t->user_id = $ticket->user_id;
                $t->ticket_id = $ticket->ticket_id;
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
                $t->instruction = $ticket->instruction;
                $t->start_at = $ticket->start_at;
                $t->finish_at = $ticket->finish_at;
                $t->created_at = $ticket->created_at;
                $t->updated_at = $ticket->updated_at;

                $mail = new \stdClass();
                $mail->user = $ticket->user->name;            
                $mail->tech =  $ticket->assign->name;
                $mail->ticketnum = $ticket->id;
                $mail->url = $request->input('url');
                $emailuser = $ticket->user->email;
                $techid = $ticket->assigned_to;

                $t->save();
                if($t->save()){
                    Ticket::where('id',$id)->delete();
                    if($request->input('mod') == 'default'){
                        $tu = new TicketUpdates;
                        $tu->ticket_id = $id;
                        $tu->user_id = $techid;
                        $tu->message = "Ticket Closed.";
                        $tu->save(); 
                        return redirect('/notification/ticketclose/'.$userid.'/'.$mail->ticketnum);
                        /* Mail::to($emailuser)->send(new TicketClosed($mail));
                        return redirect('/it/ht')->with('success','Ticket Closed Successfully.'); */
                    }                
                }
            }
            else{
                return redirect()->back();
            }            
        }
        else{
            return back()->with('error','Ticket must be resolved first.');
        }     
    }
}
