<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketAccepted;
use App\Notifications\PriorityChanged;
use App\Notifications\StatusChanged;
use App\Notifications\TicketClosed;
use App\Notifications\TicketCreated;
use App\Notifications\TicketDeclined;
use App\Notifications\TicketUpdated;
use App\Notifications\ReviewRequestCreated;
use App\Notifications\ReviewRequestAssigned;
use App\Notifications\ReviewRequestAccepted;
use App\Notifications\ReviewRequestPriorityChanged;
use App\Notifications\ReviewRequestStatusChanged;
use Auth;
use App\User;
use App\Ticket;

class NotificationController extends Controller
{    
    public function __construct()
    {
        $this->middleware('auth');
    }    
    public function markallread()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
    public function clearnotification()
    {
        Auth::user()->notifications()->delete();
        return redirect()->back();
    }
    public function markread($id,$mod,$tid)
    {
        Auth::user()->notifications->where('id',$id)->first()->markAsRead();
        if($mod == 'user'){
            return redirect(url('/it/vt/'.$tid));
        }
        else if($mod == 'assign_admin'){
            /* return redirect(url('/it/htv/'.$tid)); */
            return redirect(url('/it/vt/'.$tid));
        }
        else if($mod == 'create'){
            return redirect(url('/it/av/'.$tid));
        }        
        else if($mod == 'close'){
            return redirect(url('/it/ctlv/'.$tid));
        }
        else if($mod == 'request'){
            return redirect(url('/cr/crv/'.$tid));
        }
        else if($mod == 'decline'){
            /* return redirect(url('/it/vt/'.$tid)); */
            return redirect()->back();
        }

    }
    public function ticketcreate($tid,$mod)
    {
        $users = User::where('admin',1)->get();
        foreach ($users as $user) {
            if($user->email != 'krkim@primatechphils.com')
            {
                $user->notify(new TicketCreated($tid,$user->name));
            }            
        }
        if($mod == 'default'){
            return redirect('/it/ct')->with('success','Ticket Submitted Successfully.');
        }else if($mod == 'admin'){
            return redirect('/it/ac')->with('success','Ticket Submitted Successfully.');
        }
    }
    public function ticketassign($id,$tid,$tech)
    {
        $user = User::where('id',$id)->first();
        $tech = User::where('id',$tech)->first();
        $user->notify(new TicketAssigned($tid,$user->name,'user'));
        $tech->notify(new TicketAssigned($tid,$tech->name,'tech'));
        return redirect()->back()->with('success','Ticket Assigned Successfully.');
        /* return redirect('/it/av/'.$tid)->with('success','Ticket Assigned Successfully.'); */ 
    }
    public function ticketaccept($id,$tid,$tech)
    {
        $user = User::where('id',$id)->first();
        $user->notify(new TicketAccepted($tid,$user->name,$tech));
        return redirect()->back()->with('success','Ticket Accepted Successfully.');
        /* return redirect('/it/htv/'.$tid)->with('success','Ticket Accepted Successfully.'); */ 
    }
    public function ticketpriority($id,$tid,$prio)
    {
        $user = User::where('id',$id)->first();
        $user->notify(new PriorityChanged($tid,$user->name,$prio));
        return redirect()->back()->with('success','Priority Changed Successfully.');
        /* return redirect('/it/htv/'.$tid)->with('success','Priority Changed Successfully.'); */
    }
    public function ticketstatus($id,$tid,$stat)
    {
        $user = User::where('id',$id)->first();
        $user->notify(new StatusChanged($tid,$user->name,$stat));
        return redirect()->back()->with('success','Status Changed Successfully.');
        /* return redirect('/it/htv/'.$tid)->with('success','Status Changed Successfully.'); */
    }
    public function ticketclose($id,$tid)
    {
        $user = User::where('id',$id)->first();
        $user->notify(new TicketClosed($tid,$user->name));
        /* return redirect('/it/ht')->with('success','Ticket Closed Successfully.'); */
        return redirect()->back()->with('success','Ticket Closed Successfully.');
    }
    public function ticketdecline($id,$tid)
    {
        $user = User::where('id',$id)->first();
        $user->notify(new TicketDeclined($tid,$user->name));
        /* return redirect('/it/ht')->with('success','Ticket Closed Successfully.'); */
        return redirect()->back()->with('success','Ticket Declined Successfully.');
    }
    public function ticketupdate($id)
    {   
        $ticket = Ticket::find($id);
        if($ticket->user_id == Auth::user()->id)
        {
            if($ticket->assigned_to == '')
            {
                $users = User::where('admin',1)->get();
                foreach ($users as $user) {
                    $user->notify(new TicketUpdated($id,$user->name,$ticket->user->name));
                }
            }
            else
            {
                $user1 = User::find($ticket->assigned_to);
                $user1->notify(new TicketUpdated($id,$user1->name,$ticket->user->name));
            }
        }        
        else
        {
            $user2 = User::where('id',$ticket->user_id)->first();
            $user2->notify(new TicketUpdated($id,$user2->name,$ticket->assign->name));
        }        
        return redirect()->back()->with('success','Update Submitted Successfully.');
    }
    
    // CCTV Request

    public function requestcreate($tid){
        $users = User::where('admin',1)->get();
        foreach ($users as $user) {
            $user->notify(new ReviewRequestCreated($tid,$user->name));
        }
        return redirect()->back()->with('success','Request Submitted Successfully.');
        /* if($mod == 'default'){
            return redirect('/it/ct')->with('success','Ticket Submitted Successfully.');
        }else if($mod == 'admin'){
            return redirect('/it/ac')->with('success','Ticket Submitted Successfully.');
        } */
    }
    public function requestassign($id,$tid,$tech){
        $user = User::where('id',$id)->first();
        $tech = User::where('id',$tech)->first();
        $user->notify(new ReviewRequestAssigned($tid,$user->name,'user'));
        $tech->notify(new ReviewRequestAssigned($tid,$tech->name,'tech'));
        return redirect()->back()->with('success','Request Assigned Successfully.'); 
    }
    public function requestaccept($id,$tid,$tech){
        $user = User::where('id',$id)->first();
        $user->notify(new ReviewRequestAccepted($tid,$user->name,$tech));
        return redirect()->back()->with('success','Request Accepted Successfully.'); 
    }
    public function requestpriority($id,$tid,$prio){
        $user = User::where('id',$id)->first();
        $user->notify(new ReviewRequestPriorityChanged($tid,$user->name,$prio));
        return redirect()->back()->with('success','Request Priority Changed Successfully.');
    }
    public function requeststatus($id,$tid,$stat){
        $user = User::where('id',$id)->first();
        $user->notify(new ReviewRequestStatusChanged($tid,$user->name,$stat));
        return redirect()->back()->with('success','Request Status Changed Successfully.');
    }
}
