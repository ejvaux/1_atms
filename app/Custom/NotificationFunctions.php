<?php

namespace App\Custom;

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

class NotificationFunctions
{   
    public static function ticketcreate($tid)
    {
        $users = User::where('admin',1)->get();
        foreach ($users as $user) {
            if($user->email != 'krkim@primatechphils.com')
            {
                $user->notify( (new TicketCreated($tid,$user->name))->delay(now()->addMinutes(1)) );
            }            
        }
    }

    public static function ticketaccept($id,$tid,$tech)
    {
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketAccepted($tid,$user->name,$tech))->delay(now()->addMinutes(1)) );        
    }

    public static function ticketassign($id,$tid,$tech)
    {
        $user = User::where('id',$id)->first();
        $tech = User::where('id',$tech)->first();
        $user->notify( (new TicketAssigned($tid,$user->name,'user'))->delay(now()->addMinutes(1)) );
        $tech->notify( (new TicketAssigned($tid,$tech->name,'tech',Auth::user()->name))->delay(now()->addMinutes(1)) );
        return redirect()->back()->with('success','Ticket Assigned Successfully.');
    }

    public static function ticketpriority($id,$tid,$prio)
    {
        $user = User::where('id',$id)->first();
        $user->notify( (new PriorityChanged($tid,$user->name,$prio))->delay(now()->addMinutes(1)) );        
    }

    public static function ticketstatus($id,$tid,$stat)
    {
        $user = User::where('id',$id)->first();
        $user->notify( (new StatusChanged($tid,$user->name,$stat))->delay(now()->addMinutes(1)) );
    }

    public static function ticketclose($id,$tid)
    {
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketClosed($tid,$user->name))->delay(now()->addMinutes(1)) );        
    }

    public static function ticketdecline($id,$tid)
    {
        $user = User::where('id',$id)->first();
        $user->notify( (new TicketDeclined($tid,$user->name))->delay(now()->addMinutes(1)) );        
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
                        $user->notify( (new TicketUpdated($id,$user->name,$ticket->user->name))->delay(now()->addMinutes(1)) );
                    }                    
                }                
            }
            else
            {
                $user1 = User::find($ticket->assigned_to);
                $user1->notify( (new TicketUpdated($id,$user1->name,$ticket->user->name))->delay(now()->addMinutes(1)) );
            }
        }        
        else
        {
            $user2 = User::where('id',$ticket->user_id)->first();
            $user2->notify( (new TicketUpdated($id,$user2->name,$ticket->assign->name))->delay(now()->addMinutes(1)) );
        }
    }
}