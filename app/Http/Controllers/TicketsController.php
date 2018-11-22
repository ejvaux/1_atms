<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TicketAssigned;
use App\Mail\TicketAccepted;
use App\Mail\PriorityChanged;
use App\Mail\StatusChanged;
use Auth;
use App\Notifications\TicketCreated;
use App\User;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;
use App\TicketUpdates;
use App\Serial;
use App\Custom\NotificationFunctions;
use App\Custom\CustomFunctions;
use App\Jobs\TicketUpdate;
use App\Exports\TicketsExport;
use Maatwebsite\Excel\Facades\Excel;
class TicketsController extends Controller
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
            'subject' => 'required',
            'priority' => 'required',
            'category' => 'required', 
            'department' => 'required',          
            'message' => 'required',
            'attachedfile.*' => 'image|mimes:jpeg,png,jpg,gif,svg,bmp|nullable|max:10000',
        ]);
        try{
            /* // Handle File Upload
            if($request->hasFile('attachedfile')) {
                // Get filename with extension            
                $filenameWithExt = $request->file('attachedfile')->getClientOriginalName();
                // Get just filename
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
                // Get just ext
                $extension = $request->file('attachedfile')->getClientOriginalExtension();
                //Filename to store
                $fileNameToStore = $filename.'_'.time().'.'.$extension;                       
                // Upload Image
                $path = $request->file('attachedfile')->storeAs('public/attachedfile', $fileNameToStore);
            }
            else {
                $fileNameToStore = null;
            } */

            // Handle File Upload
            if($request->hasFile('attachedfile')) {
                $filenameArray = array();
                foreach($request->attachedfile as $file)
                {
                    $filenameWithExt = $file->getClientOriginalName();
                    $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                    $extension = $file->getClientOriginalExtension();
                    $fileNameToStore = $filename.'_'.time().'.'.$extension;
                    $file->storeAs('public/attachedfile', $fileNameToStore);
                    array_push($filenameArray,$fileNameToStore);       
                }
                $filenameArray = json_encode($filenameArray);
            }
            else {
                $filenameArray = null;
            }

            // Create Ticket --------

            // Saving Serial
            $s = new Serial;
            $s->number =  CustomFunctions::generateTicketNumber();
            $tic_id = $s->number;
            $s->save();

            // Getting ID of serial
            $i = Serial::where('number',$tic_id)->first();

            // Insert New Ticket
            $t = new Ticket;
            $t->id = $i->id;
            $t->ticket_id = $request->input('ticket_id');
            $t->user_id = $request->input('userid');
            $t->department_id = $request->input('department');
            $t->category_id = $request->input('category');
            $t->priority_id = $request->input('priority');
            $t->subject = $request->input('subject');
            $t->message = $request->input('message');
            $t->attach = $filenameArray;    
            $t->save();

            // Old creating ticket logic, primary id - auto increment
            /* $t = new Ticket;
            $t->ticket_id = $request->input('ticket_id');
            $t->user_id = $request->input('userid');
            $t->department_id = $request->input('department');
            $t->category_id = $request->input('category');
            $t->priority_id = $request->input('priority');
            $t->subject = $request->input('subject');
            $t->message = $request->input('message');
            $t->attach = $filenameArray;    
            $t->save();
            $s = new Serial;
            $s->number =  $request->input('ticket_id');
            $s->save(); */

            // Sending Notifications
            $ticket = Ticket::orderBy('created_at', 'desc')->first();
            NotificationFunctions::ticketcreate($ticket->id);
            return redirect()->back()->with('success','Ticket Submitted Successfully.');
        }
        catch(\Exception $exception){
            /* $err = $exception->errorInfo[1];
            if($err == 1062){
                $er = "Duplicate Ticket!";
            } */
            return redirect()->back()->with('error','Database Error! '. $exception);
            /* return redirect()->back()->with('error','Database Error! ' .  $er); */            
            /* return redirect()->back(); */
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
        return Ticket::where('id',$id)->get();
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
        $request->validate([
            'assigned_to' => 'nullable|integer',
            'start_at' => 'nullable|date',
            'status_id' => 'nullable|integer',
            'priority_id' => 'nullable|integer',
            'root' => 'nullable',
            'action' => 'nullable',
            'result' => 'nullable',
            'recommend' => 'nullable',
        ]);
               
        $ticket = Ticket::find($id);
        $user = $ticket->user_id;

        if($request->input('department_id') != ""){ $ticket->department_id = $request->input('department_id');}
        if($request->input('category_id') != ""){ $ticket->category_id = $request->input('category_id');}
        if($request->input('subject') != ""){ $ticket->subject = $request->input('subject');}
        if($request->input('message') != ""){ $ticket->message = $request->input('message');}

        if($request->input('assigned_to') != ""){ $ticket->assigned_to = $request->input('assigned_to');}
        if($request->input('start_at') != ""){ $ticket->start_at = $request->input('start_at');}
        if($request->input('status_id') != ""){ $ticket->status_id = $request->input('status_id');}
        if($request->input('priority_id') != ""){ $ticket->priority_id = $request->input('priority_id');}
        if($request->input('root') != ""){ $ticket->root = $request->input('root');}
        if($request->input('action') != ""){ $ticket->action = $request->input('action');}
        if($request->input('result') != ""){ $ticket->result = $request->input('result');}
        if($request->input('recommend') != ""){ $ticket->recommend = $request->input('recommend');}
        if($request->input('instruction') != ""){ $ticket->instruction = $request->input('instruction');}

        $mail = new \stdClass();        
        $mail->priority = $ticket->priority->name;
        $mail->user = $ticket->user->name;            
        $mail->tech = ((is_null($ticket->assigned_to)) ? '' : $ticket->assign->name);
        $mail->ticketnum = $ticket->id;
        $mail->assigner = $request->input('assigner');
        $mail->url = $request->input('url');
        $mail->status = $ticket->status->name;
        $email = ((is_null($ticket->assigned_to)) ? '' :  $ticket->assign->email);
        $emailuser = $ticket->user->email;
        $techid = $ticket->assigned_to;
        $userid = $ticket->user_id;

        $ticket->save();
        if($request->input('mod') == 'assign'){
            /* $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = User::where('name',$request->input('assigner'))->first()->id;
            $tu->message = "Assigned ticket to " . $mail->tech . ".";
            $tu->save(); */
            $this->dispatch(new TicketUpdate($id,User::where('name',$request->input('assigner'))->first()->id,"Assigned ticket to " . $mail->tech . "."));
            NotificationFunctions::ticketassign($userid,$request->input('ticket_id'),$techid);
            return redirect()->back()->with('success','Ticket Accepted Successfully.');
            /* return redirect('/notification/ticketassign/'.$userid.'/'.$request->input('ticket_id').'/'.$techid); */
            /* Mail::to($email)->send(new TicketAssigned($mail)); */            
            /* return redirect('/it/av/'.$id)->with('success','Ticket Assigned Successfully.'); */            
        }
        elseif($request->input('mod') == 'accept'){
            /* $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = $techid;
            $tu->message = "Ticket Accepted.";
            $tu->save(); */
            $this->dispatch( (new TicketUpdate($id,$techid,"Ticket Accepted.")) );
            NotificationFunctions::ticketaccept($userid,$mail->ticketnum,$mail->tech);
            /* return redirect('/notification/ticketaccept/'.$userid.'/'.$mail->ticketnum.'/'.$mail->tech); */
            /* Mail::to($emailuser)->send(new TicketAccepted($mail)); */         
            return redirect()->back()->with('success','Ticket Accepted Successfully.');
        }
        elseif($request->input('mod') == 'priority'){
            /* $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = $techid;
            $tu->message = "Changed priority to " . $mail->priority . ".";
            $tu->save(); */
            $this->dispatch( (new TicketUpdate($id,$techid,"Changed priority to " . $mail->priority . ".")) );
            NotificationFunctions::ticketpriority($userid,$mail->ticketnum,$mail->priority);
            /* return redirect('/notification/ticketpriority/'.$userid.'/'.$mail->ticketnum.'/'.$mail->priority); */
            /* Mail::to($emailuser)->send(new PriorityChanged($mail)); */          
            return redirect()->back()->with('success','Priority Changed Successfully.');
        }        
        elseif($request->input('mod') == 'escalate'){
            /* $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = $techid;
            $tu->message = "Changed status to " . $mail->status . ".";
            $tu->save(); */
            $ticket = Ticket::find($id);
            if($ticket->status_id == 5){
                if($ticket->finish_at == null){
                    $ticket->finish_at = Date('Y-m-d H:i:s');
                } 
            }                       
            $ticket->save();
            $this->dispatch( (new TicketUpdate($id,$techid,"Changed status to " . $mail->status . ".")) );
            NotificationFunctions::ticketstatus($userid,$mail->ticketnum,$mail->status);
            /* return redirect('/notification/ticketstatus/'.$userid.'/'.$mail->ticketnum.'/'.$mail->status); */
            /* Mail::to($emailuser)->send(new StatusChanged($mail)); */
            return redirect()->back()->with('success','Status Changed Successfully.');
        }
        elseif($request->input('mod') == 'detail'){
            /* $tu = new TicketUpdates;
            $tu->ticket_id = $id;
            $tu->user_id = $techid;
            $tu->message = "Added/Edited ticket details.";
            $tu->save(); */
            $this->dispatch( (new TicketUpdate($id,$techid,"Added/Edited ticket details.")) );
            return redirect()->back()->with('success','Details Saved Successfully.');
            /* return redirect('/it/htv/'.$id)->with('success','Details Saved Successfully.'); */
        }
        elseif($request->input('mod') == 'editTicket'){
            if(Auth::user()->admin == 1){
                return redirect('/it/av/'.$id)->with('success','Ticket Information Saved Successfully.');
            }
            else{
                return redirect('/it/vt/'.$id)->with('success','Ticket Information Saved Successfully.');
            }                           
        }
        elseif($request->input('mod') == 'instruct'){
            return redirect()->back()->with('success','Ticket Information Saved Successfully.');                          
        }   
    }     

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Ticket::where('id',$id)->delete();
        return redirect()->back()->with('success','Ticket cancelled Successfully.');    
    }
    public function export(Request $request)
    {
        return
            (new TicketsExport(
                $request->input('user_id'),
                $request->input('department_id'),
                $request->input('category_id'),
                $request->input('priority_id'),
                $request->input('status_id'),
                $request->input('assigned_to'),
                $request->input('created_from'),
                $request->input('created_to')
                ))->download('Ticket List '.Date('Y-m-d H:i:s').'.xlsx');
    }
}
