<?php

namespace App\Custom;

use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Ticket;
use App\DeclinedTicket;
use App\ClosedTicket;
use App\CctvReview;
use App\RejectedRequest;
use App\VehicleRequest;
use App\Events\triggerEvent;

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
use App\Notifications\ReviewRequestApproved;
use App\Notifications\ReviewRequestRejected;
use App\Notifications\QueueErrorReport;
use App\Notifications\CctvAttachmentsUploaded;
use App\Notifications\CctvAttachmentsAccessGranted;
use App\Notifications\CctvAttachmentsAccessRemoved;
use App\Notifications\hr\VehicleRequestApproval;
use App\Notifications\hr\VehicleRequestApproved;


class NotificationFunctions
{   
    // Realtime Notification
    public static function markread($id)
    {        
        foreach (Auth::user()->unReadNotifications as $rn) {
            if($rn->data['series'] == $id){
                $rn->markAsRead();
            }
        }
        event( (new triggerEvent('refresh')) );
    }

    // TICKET
    // ->delay(now()->addSeconds(30)
    public static function ticketcreate($tid)
    {
        $ticket = Ticket::where('id',$tid)->first();
        $users = User::where('admin',1)->get();
        foreach ($users as $user) {
            $user->notify( (new TicketCreated($ticket,$user)) );            
        }
    }

    public static function ticketaccept($id,$tid)
    {
        $ticket = Ticket::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketAccepted($ticket,$user)) );
    }

    public static function ticketassign($id,$tid,$tech)
    {
        $ticket = Ticket::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $tech = User::where('id',$tech)->first();
        $user->notify( (new TicketAssigned($ticket,$user,'user')) );
        $tech->notify( (new TicketAssigned($ticket,$tech,'tech',Auth::user()->name)) );
        return redirect()->back()->with('success','Ticket Assigned Successfully.');
    }

    public static function ticketpriority($id,$tid,$prio)
    {
        $ticket = Ticket::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $user->notify( (new PriorityChanged($ticket,$user,$prio)) );        
    }

    public static function ticketstatus($id,$tid,$stat)
    {
        $user = User::where('id',$id)->first();
        $ticket = Ticket::where('id',$tid)->first();
        $user->notify( (new StatusChanged($ticket,$user,$stat)) );
    }

    public static function ticketclose($id,$tid)
    {
        $ticket = ClosedTicket::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketClosed($ticket,$user)) );        
    }

    public static function ticketdecline($id,$tid)
    {
        $ticket = DeclinedTicket::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketDeclined($ticket,$user)) );        
    }

    public static function ticketupdate($id)
    {   
        $ticket = Ticket::find($id);
        if($ticket->user_id == Auth::user()->id)
        {
            if($ticket->assigned_to == '')
            {
                $users = User::where('admin',1)->get();
                foreach ($users as $user) {
                    if($user->email != 'krkim@primatechphils.com')
                    {
                        $user->notify( (new TicketUpdated($ticket,$user,$ticket->user->name)) );
                    }                    
                }                
            }
            else
            {
                $user1 = User::find($ticket->assigned_to);
                $user1->notify( (new TicketUpdated($ticket,$user1,$ticket->user->name)) );
            }
        }        
        else
        {
            $user2 = User::where('id',$ticket->user_id)->first();
            $user2->notify( (new TicketUpdated($ticket,$user2,$ticket->assign->name)) );
        }
    }

    // CCTV REVIEW
    public static function requestcreate($tid){
        $users = User::where('req_approver',1)->get();
        $review = CctvReview::where('id',$tid)->first();
        foreach ($users as $user) {
            $user->notify( (new ReviewRequestCreated($review,$user)) );
        }     
    }
    public static function requestrejected($tid,$id,$rson){
        $user = User::where('id',$id)->first();
        $request = RejectedRequest::where('id',$tid)->first();
        $user->notify( (new ReviewRequestRejected($request, $user)) );
       
    }
    public static function requestapprove($tid,$id){
        $users = User::where('admin',1)->get();
        $request = CctvReview::where('id',$tid)->first();
        foreach ($users as $user){
            $user->notify( (new ReviewRequestApproved($request,$user,'admin')) );
        }
        $user1 = User::where('id',$id)->first();
        $user1->notify( (new ReviewRequestApproved($request,$user,'user')) );
    }
    public static function requestassign($id,$tid,$tech){
        $request = CctvReview::where('id',$tid)->first();
        $user = User::where('id',$id)->first();
        $tech = User::where('id',$tech)->first();
        $user->notify( (new ReviewRequestAssigned($request,$user,'user')) );
        $tech->notify( (new ReviewRequestAssigned($request,$tech,'tech',Auth::user()->name)) );        
    }
    public static function requestaccept($id,$tid,$tech){
        $user = User::where('id',$id)->first();
        $request = CctvReview::where('id',$tid)->first();
        $user->notify( (new ReviewRequestAccepted($request,$user)) );        
    }
    public static function requestpriority($id,$tid,$prio){
        $user = User::where('id',$id)->first();
        $request = CctvReview::where('id',$tid)->first();
        $user->notify( (new ReviewRequestPriorityChanged($request,$user)) );        
    }
    public static function requeststatus($id,$tid,$stat){
        $user = User::where('id',$id)->first();
        $request = CctvReview::where('id',$tid)->first();
        $user->notify( (new ReviewRequestStatusChanged($request,$user)) );
    }
    public static function requestattachmentupload($rid){
        $users = User::where('req_approver',1)->get();
        $request = CctvReview::where('id',$rid)->first();
        foreach ($users as $user) {
            $user->notify( (new CctvAttachmentsUploaded($request,$user)) );
        }                
    }
    public static function requestallow($id,$rid){
        $user = User::where('id',$id)->first();
        $request = CctvReview::where('id',$rid)->first();
        $user->notify( (new CctvAttachmentsAccessGranted($request,$user)) );               
    }
    public static function requestdisallow($id,$rid){
        $user = User::where('id',$id)->first();
        $request = CctvReview::where('id',$rid)->first();
        $user->notify( (new CctvAttachmentsAccessRemoved($request,$user)) );               
    }

    // HR - Vehicle Request
    public static function approvevehiclerequest($id,$rid,$did){
        if($did == 0){
            $users = User::where('hrvr_approval_type',$id)->get();
        } 
        else{
            $users = User::where('hrvr_approval_type',$id)->where('hrvr_approval_dept',$did)->get();
        }        
        $vrequest = VehicleRequest::where('id',$rid)->first();
        foreach ($users as $user){
            $user->notify( (new VehicleRequestApproval($vrequest,$user)) );
        }                       
    }
    public static function vehiclerequestapproved($id,$rid){
        $user = User::where('id',$id)->first();
        $vrequest = VehicleRequest::where('id',$rid)->first();
        $user->notify( (new VehicleRequestApproved($vrequest,$user)) );                    
    }
}