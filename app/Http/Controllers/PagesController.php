<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\NotificationTask;
use App\Events\triggerEvent;
use Auth;

class PagesController extends Controller
{  
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index(){
        return view('pages.index');
    }

    public function event()
    {
        event(new NotificationTask(Auth::user(),'TEST'));
    }
}