<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function send(Request $request){
        $title = $request->input('title');
        $content = $request->input('content');

        Mail::send('mail.send', ['title' => $title, 'content' => $content], function ($message)
        {

            $message->from('noreply@primatechphils.com', 'Ticket System');

            $message->to('edmund.mati@primatechphils.com');

        });

        return response()->json(['message' => 'Request completed']);
    }
    public function sendassign(Request $request){
        $tech = $request->input('tech');
        $ticketnum = $request->input('ticketnum');
        $assigner = $request->input('assigner');
        $email = $request->input('useremail');

        Mail::send('mail.ticket_assign', ['tech' => $tech, 'ticketnum' => $ticketnum, 'assigner' => $assigner], function ($message)
        {
            $message->to($email);
        });
    }
}
