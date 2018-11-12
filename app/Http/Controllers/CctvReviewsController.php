<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CctvReview;
use App\ReviewSerial;
use App\Custom\NotificationFunctions;
use App\Jobs\TicketUpdate;

class CctvReviewsController extends Controller
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
            'priority_id' => 'required',
            'department_id' => 'required',          
            'message' => 'required',     
            'report' => 'required|max:2048|mimes:doc,pdf,docx,zip',       
        ]);

        // Handle File Upload
        if($request->hasFile('report')) {
            // Get filename with extension            
            $filenameWithExt = $request->file('report')->getClientOriginalName();
            // Get just filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);            
            // Get just ext
            $extension = $request->file('report')->getClientOriginalExtension();
            //Filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;                       
            // Upload Image
            $path = $request->file('report')->storeAs('public/report', $fileNameToStore);
        }
        else {
            $fileNameToStore = null;
        }
        
        // Creating Request
        
        // Saving Serial
        $s = new ReviewSerial;
        $s->number =  $request->input('request_id');
        $s->save();

        // Getting ID of Serial
        $i = ReviewSerial::where('number',$request->input('request_id'))->first();

        // Inserting New Request
        $r = new CctvReview();
        $r->id = $i->id;
        $r->request_id = $request->input('request_id');
        $r->user_id = $request->input('user_id');
        $r->department_id = $request->input('department_id');
        $r->priority_id = $request->input('priority_id');
        $r->subject = $request->input('subject');
        $r->message = $request->input('message');
        $r->start_time = $request->input('start_time');
        $r->end_time = $request->input('end_time');
        $r->location = $request->input('location');
        $r->r_attach = $fileNameToStore;
        $r->save();

        // Old creating request logic, primary id - auto increment
        /* $r = new CctvReview();
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
        $s->save(); */

        // Sending Notifications
        $req = CctvReview::orderBy('id', 'desc')->first();
        NotificationFunctions::requestcreate($req->id);

        return redirect()->back()->with('success','Request Submitted Successfully.');        
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
        $request->validate([
            'attach.*' => 'image|mimes:jpeg,png,jpg,gif,svg,bmp|nullable|max:10000',
        ]);

        // Handle File Upload
        if($request->hasFile('attach')) {
            $filenameArray = array();
            foreach($request->attach as $file)
            {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $file->storeAs('public/requestfile', $fileNameToStore);
                array_push($filenameArray,$fileNameToStore);       
            }
            $filenameArray = json_encode($filenameArray);
        }
        else {
            $filenameArray = null;
        }
        $req = CctvReview::find($id);

        $req->attach = $filenameArray;
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
        if($request->input('root') != ""){ $req->root = $request->input('root');}
        if($request->input('action') != ""){ $req->action = $request->input('action');}
        if($request->input('result') != ""){ $req->result = $request->input('result');}
        if($request->input('recommend') != ""){ $req->recommend = $request->input('recommend');}
        if($request->input('approved') != ""){ $req->approved = $request->input('approved');}
        if($request->input('status_id') != ""){ $req->status_id = $request->input('status_id');
            if($request->input('status_id') == '5'){
                $req->finish_at = Date('Y-m-d H:i:s');
            };}

        $req_id = $req->id;
        $techid = $req->assigned_to;
        if($req->assigned_to != ""){ $techname = $req->assign->name;}
        $userid = $req->user_id;
        $prior = $req->priority->name;
        $stat = $req->status->name;

        $req->save();

        if($request->input('mod') == 'assign'){
            NotificationFunctions::requestassign($userid,$req_id,$techid);
            return redirect()->back()->with('success','Request Assigned Successfully.');
            /* return redirect('/notification/requestassign/'.$userid.'/'.$req_id.'/'.$techid)->with('success','Request Assigned Successfully.'); */                      
        }
        elseif($request->input('mod') == 'accept'){
            NotificationFunctions::requestaccept($userid,$req_id,$techname);
            return redirect()->back()->with('success','Request Accepted Successfully.');
            /* return redirect('/notification/requestaccept/'.$userid.'/'.$req_id.'/'.$techname)->with('success','Request Accepted Successfully'); */            
        }
        elseif($request->input('mod') == 'priority'){
            NotificationFunctions::requestpriority($userid,$req_id,$prior);
            return redirect()->back()->with('success','Request Priority Changed Successfully.');
            /* return redirect('/notification/requestpriority/'.$userid.'/'.$req_id.'/'.$prior); */           
        }
        elseif($request->input('mod') == 'escalate'){
            NotificationFunctions::requeststatus($userid,$req_id,$stat);
            return redirect()->back()->with('success','Request Status Changed Successfully.');            
            /* return redirect('/notification/requeststatus/'.$userid.'/'.$req_id.'/'.$stat); */            
        }
        elseif($request->input('mod') == 'approve'){
            NotificationFunctions::requestapprove($req_id,$userid);
            return redirect()->back()->with('success','Request Approved Successfully.');            
            /* return redirect('/notification/requeststatus/'.$userid.'/'.$req_id.'/'.$stat); */            
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
    public function addimage(Request $request, $id)
    {
        $request->validate([
            'attach.*' => 'image|mimes:jpeg,png,jpg,gif,svg|required|max:10000',
        ]);
        $req = CctvReview::where('id',$id)->first();
        // Handle File Upload
        if($request->hasFile('attach')) {
            $filenameArray = json_decode($req->attach);
            foreach($request->attach as $file)
            {
                $filenameWithExt = $file->getClientOriginalName();
                $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
                $extension = $file->getClientOriginalExtension();
                $fileNameToStore = $filename.'_'.time().'.'.$extension;
                $file->storeAs('public/requestfile', $fileNameToStore);
                array_push($filenameArray,$fileNameToStore);       
            }
        }
        else {
            $filenameArray = null;
        }        
        $req->attach = json_encode($filenameArray);
        $req->save();
        return redirect()->back()->with('success','Image/s uploaded successfully');
    }
}
