<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ticket;
use App\Category;
use App\Priority;
use App\Department;
use App\TicketUpdates;
use App\User;
use App\Status;
use App\ClosedTicket;
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
        return view('tabs.home.dash');
    }    
    // HOME
    public function viewdashtab()
    {       
        return view('tabs.home.dash');
    }
    public function viewroles()
    {   
        $users = User::paginate(20);
        return view('tabs.admin.role',compact('users'));
    }
    public function searchuserview($id)
    {   
        /* $users = User::paginate(20); */
        $users = User::where('name','like','%'.$id.'%')->orWhere('email','like','%'.$id.'%')->paginate(20);
        return view('tabs.admin.role',compact('users'));
    }
    
    // IT Tabs
    public function adminlistticket(){
        /* $statuses = Status::orderBy('id')->get(); */
        $tickets = Ticket::sortable()->orderBy('id','desc')->paginate(10);
        return view('tabs.it.al', compact('tickets'));
    }
    public function adminviewticket($id)
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $users = User::where('tech',1)->get();
        $tickets = Ticket::where('id',$id)->first();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.av', compact('tickets','updates','users','updatetext','departments','categories'));
    }
    public function listticket()
    {
        $tickets = Ticket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.lt', compact('tickets'));
    }
    public function viewticket($id)
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $tickets = Ticket::where('id',$id)->first();
        $statuses = Status::orderBy('id')->get();
        $priorities = Priority::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.vt', compact('tickets','updates','updatetext','priorities','statuses','departments','categories'));
    }
    public function createticket()
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $priorities = Priority::orderBy('id')->get();
        return view('tabs.it.ct', compact('categories', 'priorities','departments'));
    }
    public function admincreateticket()
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $priorities = Priority::orderBy('id')->get();
        return view('tabs.it.ac', compact('categories', 'priorities','departments'));
    }
    public function contact()
    {        
        return view('tabs.it.cu');
    }
    public function adminqueue()
    {
        $tickets = Ticket::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10); 
        return view('tabs.it.aq',compact('tickets'));
    }    
    public function handledticket()
    {
        $tickets = Ticket::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10); 
        return view('tabs.it.ht',compact('tickets'));
    }
    public function viewhandledticket($id){
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $tickets = Ticket::where('id',$id)->first();        
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';        
        return view('tabs.it.htv', compact('tickets','updates','updatetext','priorities','statuses','departments','categories'));       
    }
    public function adminviewhandledticket($id){
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $tickets = Ticket::where('id',$id)->first();        
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ahtv', compact('tickets','updates','updatetext','priorities','statuses','departments','categories'));
    }
    public function closedticket(){
        $tickets = ClosedTicket::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.ctl',compact('tickets'));
    }
    public function adminclosedticket(){
        $tickets = ClosedTicket::orderBy('id','desc')->paginate(10);
        return view('tabs.it.actl',compact('tickets'));
    }   

    public function handledclosedticket(){
        $tickets = ClosedTicket::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.hct',compact('tickets'));
    }
    public function adminhandledclosedticket(){
        $tickets = ClosedTicket::where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.ahct',compact('tickets'));
    }
    public function handledclosedticketview($id){
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.hctv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function adminhandledclosedticketview($id){
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ahctv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function closedticketview($id){
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ctlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function adminclosedticketview($id){
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.actlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }

    // Search
    public function adminsearchticket($id)
    {
        $tickets = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'tickets.status_id')
                        ->select('tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('tickets.id','like','%'.$id.'%')                        
                        ->orWhere('tickets.ticket_id','like','%'.$id.'%')
                        ->orWhere('users.name','like','%'.$id.'%')
                        ->orWhere('priorities.name','like','%'.$id.'%')
                        ->orWhere('categories.name','like','%'.$id.'%')
                        ->orWhere('statuses.name','like','%'.$id.'%')
                        ->orWhere('tickets.subject','like','%'.$id.'%')
                        ->orderBy('tickets.id','desc')
                        ->paginate(10);
        /* return $tickets; */                                
        return view('tabs.it.al', compact('tickets'));
    }
    public function searchticket($id)
    {
        $tickets = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'tickets.status_id')
                        ->select('tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('user_id',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('tickets.id','like','%'.$id.'%')
                                ->orWhere('tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('tickets.subject','like','%'.$id.'%');
                        })
                        ->orderBy('tickets.id','desc')
                        ->paginate(10);                          
        return view('tabs.it.lt', compact('tickets'));
    }
    public function searchhandledticket($id){
        $tickets = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'tickets.status_id')
                        ->select('tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('assigned_to',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('tickets.id','like','%'.$id.'%')
                                ->orWhere('tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('tickets.id','desc')
                        ->paginate(10);
        /* $tickets = Ticket::where([['id','=',$id],['assigned_to','=', Auth::user()->id]])->orderBy('id','desc')->paginate(10); */   
        return view('tabs.it.ht',compact('tickets'));
    }

    public function searchhandledclosedticket($id){
        $tickets = ClosedTicket::join('users', 'users.id', '=', 'closed_tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'closed_tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'closed_tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'closed_tickets.status_id')
                        ->select('closed_tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('assigned_to',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('closed_tickets.id','like','%'.$id.'%')
                                ->orWhere('closed_tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('closed_tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('closed_tickets.id','desc')
                        ->paginate(10);
        return view('tabs.it.hct',compact('tickets'));
    }
    public function searchclosedticket($id){
        $tickets = ClosedTicket::join('users', 'users.id', '=', 'closed_tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'closed_tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'closed_tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'closed_tickets.status_id')
                        ->select('closed_tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('user_id',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('closed_tickets.id','like','%'.$id.'%')
                                ->orWhere('closed_tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('closed_tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('closed_tickets.id','desc')
                        ->paginate(10);        
        return view('tabs.it.ctl',compact('tickets'));
    }
    public function searchadminclosedticket($id){
        $tickets = ClosedTicket::join('users', 'users.id', '=', 'closed_tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'closed_tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'closed_tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'closed_tickets.status_id')
                        ->select('closed_tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('closed_tickets.id','like','%'.$id.'%')
                        ->orWhere('closed_tickets.ticket_id','like','%'.$id.'%')
                        ->orWhere('users.name','like','%'.$id.'%')
                        ->orWhere('priorities.name','like','%'.$id.'%')
                        ->orWhere('categories.name','like','%'.$id.'%')
                        ->orWhere('statuses.name','like','%'.$id.'%')
                        ->orWhere('closed_tickets.subject','like','%'.$id.'%')
                        ->orderBy('closed_tickets.id','desc')
                        ->paginate(10);
        return view('tabs.it.actl',compact('tickets'));
    }
    public function searchadminqueue($id)
    {
        $tickets = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'tickets.status_id')
                        ->select('tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('assigned_to',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('tickets.id','like','%'.$id.'%')
                                ->orWhere('tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('tickets.id','desc')
                        ->paginate(10);
        return view('tabs.it.aq',compact('tickets'));
    }
    public function searchadminhandledclosedticket($id){
        $tickets = ClosedTicket::join('users', 'users.id', '=', 'closed_tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'closed_tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'closed_tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'closed_tickets.status_id')
                        ->select('closed_tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where('assigned_to',Auth::user()->id)
                        ->where(function ($query) use($id) {
                            $query->where('closed_tickets.id','like','%'.$id.'%')
                                ->orWhere('closed_tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('closed_tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('closed_tickets.id','desc')
                        ->paginate(10);
        return view('tabs.it.ahct',compact('tickets'));
    }
}
