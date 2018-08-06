<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;
use App\TicketUpdates;
use App\User;
use Auth;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {       
        return view('pages.dashboard');
    }
    
    // HOME
    public function viewdashtab()
    {       
        return view('tabs.home.dash');
    }

    public function viewroles()
    {   
        $users = User::all();
        return view('tabs.admin.role',compact('users'));
    }
    
    // IT Tabs
    public function adminlistticket(){
        $tickets = Ticket::orderBy('id','desc')->paginate(10);
        return view('tabs.it.al', compact('tickets'));
    }

    public function adminviewticket($id)
    {
        $tickets = Ticket::where('id',$id)->first();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.av', compact('tickets','updates','updatetext'));
    }

    public function listticket()
    {
        $tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.lt', compact('tickets'));
    }

    public function viewticket($id)
    {
        $tickets = Ticket::where('id',$id)->first();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.vt', compact('tickets','updates','updatetext'));
    }

    public function createticket()
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $priorities = Priority::orderBy('id')->get();
        return view('tabs.it.ct', compact('categories', 'priorities','departments'));
    }

    public function contact()
    {        
        return view('tabs.it.cu');
    }

}
