<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\RejectedRequest;
use App\CctvReview;
use App\Custom\NotificationFunctions;
use Auth;

class RejectedRequestController extends Controller
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

    public function reject(Request $request,$id)
    {
        // Initialize Variables
        $req = CctvReview::where('id',$id)->first();
        $rreq = new RejectedRequest;

        // Copying Request to Reject Request table
        $rreq->id = $req->id;
        $rreq->request_id = $req->request_id;
        $rreq->user_id = $req->user_id;
        $rreq->department_id = $req->department_id;
        $rreq->priority_id = $req->priority_id;
        $rreq->status_id = 7;
        $rreq->subject = $req->subject;
        $rreq->message = $req->message;
        $rreq->start_time = $req->start_time;
        $rreq->end_time = $req->end_time;
        $rreq->location = $req->location;
        $rreq->assigned_to = $req->assigned_to;
        $rreq->root = $req->root;
        $rreq->action = $req->action;
        $rreq->result = $req->result;
        $rreq->recommend = $req->recommend;
        $rreq->start_at = $req->start_at;
        $rreq->finish_at = $req->finish_at;
        $rreq->attach = $req->attach;
        /* $rreq->approved = $req->approved; */
        $rreq->approver_id = Auth::user()->id;
        $rreq->approved_at = date('Y-m-d H:i:s');
        $rreq->reason = $request->input('reason');
        $rreq->created_at = $req->created_at;
        $rreq->updated_at = $req->updated_at;
        $rreq->save();
        
        // Deleting Request from Cctv Reviews table
        CctvReview::where('id',$id)->delete();

        NotificationFunctions::requestrejected($req->id,$req->user_id,$request->input('reason'));
        return redirect()->back()->with('success','Ticket rejected Successfully.');
    }
}