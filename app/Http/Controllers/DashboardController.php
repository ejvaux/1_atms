<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Division;
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
        return view('tabs.h_dash');
    }
    
    // IT Tabs
    public function viewticket()
    {
        $tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it_vt', compact('tickets'));
    }

    public function createticket()
    {
        $ticket_id = Ticket::select('id')->orderBy('id','desc')->first();
        if(!$ticket_id){
            $ticket_id = 1;
        }
        else{
            $ticket_id->id++;
        }
        $divisions = Division::select('DIVISION_ID','DIVISION_NAME')->orderBy('DIVISION_NAME')->get();
        $categories = Category::orderBy('id')->get();
        $priorities = Priority::orderBy('id')->get();
        /* return view('pages.dashboard', compact('categories', 'priorities','divisions','ticket_id')); */
        return view('tabs.it_ct', compact('categories', 'priorities','divisions','ticket_id'));
    }

    public function contact()
    {        
        return view('tabs.it_cu');
    }

}
