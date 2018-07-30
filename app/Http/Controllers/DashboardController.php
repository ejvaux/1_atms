<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;
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
    
    // IT Tabs
    public function listticket()
    {
        $tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.lt', compact('tickets'));
    }

    public function viewticket()
    {
        /* $tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.lt', compact('tickets')); */
        return view('tabs.it.vt');
    }

    public function createticket()
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('id')->get();
        $priorities = Priority::orderBy('id')->get();
        return view('tabs.it.ct', compact('categories', 'priorities','departments'));
    }

    public function contact()
    {        
        return view('tabs.it.cu');
    }

}
