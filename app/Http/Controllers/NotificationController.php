<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\TicketAssigned;
use App\Notifications\TicketAccepted;
use App\Notifications\PriorityChanged;
use App\Notifications\StatusChanged;
use App\Notifications\TicketClosed;
use App\Notifications\TicketCreated;
use Auth;

class NotificationController extends Controller
{    
    public function markallread(){
        Auth::user()->unreadNotifications->markAsRead();
        return redirect()->back();
    }
    public function clearnotification(){
        Auth::user()->notifications()->delete();
        return redirect()->back();
    }
    public function markread($id,$mod,$tid){
        Auth::user()->notifications->where('id',$id)->first()->markAsRead();
        if($mod == 'user'){
            return redirect(url('/it/vt/'.$tid));
        }
        else if($mod == 'assign_admin'){
            return redirect(url('/it/htv/'.$tid));
        }
        else if($mod == 'create'){
            return redirect(url('/it/av/'.$tid));
        }        
        else if($mod == 'close'){
            return redirect(url('/it/ctlv/'.$tid));
        }
    }
    public function ticketcreate($tid,$mod){
        
    }
    public function ticketassign($id,$tid,$tech){
        
    }
    public function ticketaccept($id,$tid,$tech){
        
    }
    public function ticketpriority($id,$tid,$prio){
        
    }
    public function ticketstatus($id,$tid,$stat){
        
    }
    public function ticketclose($id,$tid){
        
    }    
}
