<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;

class TicketsController extends Controller
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
            'subject' => 'required',
            'priority' => 'required',
            'category' => 'required', 
            'department' => 'required',          
            'message' => 'required',
        ]);

        // Create Ticket
        $t = new Ticket;
        $t->user_id = $request->input('userid');
        $t->department_id = $request->input('department');
        $t->category_id = $request->input('category');
        $t->priority_id = $request->input('priority');
        $t->subject = $request->input('subject');
        $t->message = $request->input('message');
        $t->save();
        if($request->input('mod') == 'default'){
            return redirect('/it/ct')->with('success','Ticket Submitted Successfully.');           
        }
        elseif($request->input('mod') == 'admin'){            
            return redirect('/it/ac')->with('success','Ticket Submitted Successfully.');
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
        if($request->input('assigned_to') != ""){ $ticket->assigned_to = $request->input('assigned_to');}
        if($request->input('start_at') != ""){ $ticket->start_at = $request->input('start_at');}
        if($request->input('status_id') != ""){ $ticket->status_id = $request->input('status_id');}
        if($request->input('priority_id') != ""){ $ticket->priority_id = $request->input('priority_id');}
        if($request->input('root') != ""){ $ticket->root = $request->input('root');}
        if($request->input('action') != ""){ $ticket->action = $request->input('action');}
        if($request->input('result') != ""){ $ticket->result = $request->input('result');}
        if($request->input('recommend') != ""){ $ticket->recommend = $request->input('recommend');}
        $ticket->save();
        if($request->input('mod') == 'assign'){
            return redirect('/it/av/'.$id)->with('success','Ticket Assigned Successfully.');            
        }
        elseif($request->input('mod') == 'accept'){            
            return redirect('/it/htv/'.$id)->with('success','Ticket Accepted Successfully.');
        }
        elseif($request->input('mod') == 'priority'){            
            return redirect('/it/htv/'.$id)->with('success','Priority Changed Successfully.');
        }
        elseif($request->input('mod') == 'status'){            
            session()->flash('success', 'Status Changed Successfully.');
            return '/1_atms/public/it/htv/'.$id;
        }
        elseif($request->input('mod') == 'escalate'){
            $ticket = Ticket::find($id);
            if($ticket->status_id == 5){
                if($ticket->finish_at == null){
                    $ticket->finish_at = Date('Y-m-d H:i:s');
                } 
            }                       
            $ticket->save();
            return redirect('/it/htv/'.$id)->with('success','Status Changed Successfully.');
        }
        elseif($request->input('mod') == 'detail'){            
            return redirect('/it/htv/'.$id)->with('success','Details Saved Successfully.');
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
        //
    }

    /* public function customUpdate(Request $request, $id, $mod)
    {
        $request->validate([
            'assigned_to' => 'nullable|integer',
            'start_at' => 'nullable|date',
            'status_id' => 'nullable|integer',
        ]);        
        $ticket = Ticket::find($id);
        if($request->input('assigned_to') != ""){ $ticket->assigned_to = $request->input('assigned_to');}
        if($request->input('start_at') != ""){ $ticket->start_at = $request->input('start_at');}
        if($request->input('status_id') != ""){ $ticket->status_id = $request->input('status_id');}
        $ticket->save();
        return $mod;
        if($mod == 'assign'){
            return redirect('/it/av/'.$id)->with('success','Ticket Assigned Successfully.');            
        }
        elseif($mod == 'accept'){            
            return redirect('/it/av/'.$id)->with('success','Ticket Accepted Successfully.');
        }          
    } */
}
