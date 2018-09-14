<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CctvReview;
use App\ReviewSerial;

class CctvReviewsController extends Controller
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
            'priority_id' => 'required',
            'department_id' => 'required',          
            'message' => 'required',            
        ]);

        $r = new CctvReview();
        $r->request_id = $request->input('request_id');
        $r->user_id = $request->input('user_id');
        $r->department_id = $request->input('department_id');
        $r->priority_id = $request->input('priority_id');
        $r->subject = $request->input('subject');
        $r->message = $request->input('message');
        $r->start_time = $request->input('start_time');
        $r->end_time = $request->input('end_time');
        $r->location = $request->input('location');
        $r->save();
        $s = new ReviewSerial;
        $s->number =  $request->input('request_id');
        $s->save();
        $req = CctvReview::orderBy('id', 'desc')->first();
        return redirect('/notification/requestcreate/'.$req->id)->with('success','Request Submitted Successfully.');
        
        /* if($request->input('mod') == 'default'){
            return redirect('/notification/requestcreate/'.$ticket->id.'/default');
            return redirect()->back()->with('success','Request Submitted Successfully.');           
        } */
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
        $req = CctvReview::find($id);        

        if($request->input('department_id') != ""){ $req->department_id = $request->input('department_id');}
        if($request->input('subject') != ""){ $req->subject = $request->input('subject');}
        if($request->input('message') != ""){ $req->message = $request->input('message');}
        if($request->input('start_time') != ""){ $req->start_time = $request->input('start_time');}
        if($request->input('end_time') != ""){ $req->end_time = $request->input('end_time');}
        if($request->input('location') != ""){ $req->location = $request->input('location');}
        if($request->input('assigned_to') != ""){ $req->assigned_to = $request->input('assigned_to');}
        if($request->input('status_id') != ""){ $req->status_id = $request->input('status_id');}
        if($request->input('start_at') != ""){ $req->start_at = $request->input('start_at');}
        if($request->input('priority_id') != ""){ $req->priority_id = $request->input('priority_id');}
        if($request->input('status_id') != ""){ $req->status_id = $request->input('status_id');
            if($request->input('status_id') == '5'){
                $req->finish_at = Date('Y-m-d H:i:s');
            };}

        $req_id = $req->id;
        $techid = $req->assigned_to;
        $techname = $req->assign->name;
        $userid = $req->user_id;
        $prior = $req->priority->name;
        $stat = $req->status->name;

        $req->save();

        if($request->input('mod') == 'assign'){            
            return redirect('/notification/requestassign/'.$userid.'/'.$req_id.'/'.$techid)->with('success','Request Assigned Successfully.');                      
        }
        elseif($request->input('mod') == 'accept'){            
            return redirect('/notification/requestaccept/'.$userid.'/'.$req_id.'/'.$techname)->with('success','Request Accepted Successfully');            
        }
        elseif($request->input('mod') == 'priority'){            
            return redirect('/notification/requestpriority/'.$userid.'/'.$req_id.'/'.$prior);           
        }
        elseif($request->input('mod') == 'escalate'){            
            return redirect('/notification/requeststatus/'.$userid.'/'.$req_id.'/'.$stat);            
        }
        else{
            return redirect()->back()->with('success','CCTV Review Request updated successfully');
        }

        /* return redirect()->back()->with('success','CCTV Review Request updated successfully'); */
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        CctvReview::where('id',$id)->delete();
        return redirect()->back()->with('success','Request cancelled Successfully.');   
    }
}
