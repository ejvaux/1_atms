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
use Carbon\Carbon;
use App\Charts\TicketsReport;
use DB;
use App\Custom\CustomFunctions;
use App\DeclinedTicket;

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
        $sorting = '1';
        return view('tabs.it.al', compact('tickets','sorting'));
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
        $tickets = Ticket::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);        
        $sorting = '1';
        return view('tabs.it.lt', compact('tickets','sorting'));
    }
    public function viewticket($id)
    {
        $departments = Department::orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        $tickets = Ticket::where('id',$id)->first();
        $statuses = Status::orderBy('id')->get();
        $priorities = Priority::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $users = User::where('tech',1)->get();
        $updatetext = '';
        return view('tabs.it.vt', compact('tickets','updates','updatetext','priorities','statuses','departments','categories','users'));
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
        $tickets = ClosedTicket::where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
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
    public function declinedticket(){
        $tickets = DeclinedTicket::orderBy('id','desc')->paginate(10);
        return view('tabs.it.dtl',compact('tickets'));
    }
    public function declinedticketview($id){
        $tickets = DeclinedTicket::where('id',$id)->first();   
        $priorities = Priority::orderBy('id')->get();
        $statuses = Status::orderBy('id')->get();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.dtv',compact('tickets','updates','updatetext','priorities','statuses'));
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
        $sorting = '1';                               
        return view('tabs.it.al', compact('tickets','sorting'));
    }
    public function searchticket($id)
    {
        $tickets = Ticket::join('users', 'users.id', '=', 'tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'tickets.status_id')
                        ->select('tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        ->where(function ($query) use($id) {
                            $query->where('user_id',Auth::user()->id)
                                ->orWhere('assigned_to',Auth::user()->id);
                        })                        
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
        $sorting = '1';                         
        return view('tabs.it.lt', compact('tickets','sorting'));
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
    public function searchdeclinedticket($id)
    {
        $tickets = DeclinedTicket::join('users', 'users.id', '=', 'declined_tickets.user_id')
                        ->join('priorities', 'priorities.id', '=', 'declined_tickets.priority_id')
                        ->join('categories', 'categories.id', '=', 'declined_tickets.category_id')
                        ->join('statuses', 'statuses.id', '=', 'declined_tickets.status_id')
                        ->select('declined_tickets.*','users.name as username','priorities.name as priority','categories.name as category','statuses.name as status')
                        /* ->where('assigned_to',Auth::user()->id) */
                        ->where(function ($query) use($id) {
                            $query->where('declined_tickets.id','like','%'.$id.'%')
                                ->orWhere('declined_tickets.ticket_id','like','%'.$id.'%')
                                ->orWhere('users.name','like','%'.$id.'%')
                                ->orWhere('priorities.name','like','%'.$id.'%')
                                ->orWhere('categories.name','like','%'.$id.'%')
                                ->orWhere('statuses.name','like','%'.$id.'%')
                                ->orWhere('declined_tickets.subject','like','%'.$id.'%');
                        })                        
                        ->orderBy('declined_tickets.id','desc')
                        ->paginate(10);
        return view('tabs.it.dtl',compact('tickets'));
    }

    // Reports
    public function ticketreports(){
        // Tickets per day
        $newticket = Ticket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->count();

        // Assigned Ticket
        $assignedticket = Ticket::where('assigned_to','!=',null)->count();

        // Completed Ticket
        $resolvedticket = Ticket::where('finish_at','!=',null)->count();
        $closedticket = ClosedTicket::count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->get();
        $rtime = 0;
        foreach($assigntickets as $assignticket){
            $start = Carbon::parse($assignticket->start_at);
            $created = Carbon::parse($assignticket->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assigntickets->count()){
            $trtime = $rtime / $assigntickets->count();
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $resolvedtickets = Ticket::where('finish_at','!=',null)->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->get();
        $crentime = 0;
        foreach($cresolvedtickets as $cresolveticket){
            $cstart = Carbon::parse($cresolveticket->start_at);
            $cfinish = Carbon::parse($cresolveticket->finish_at);
            $crentime += $cfinish->diffInMinutes($cstart);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }
        
        if($resolvedtickets->count() || $resolvedtickets->count()){
            $totalrentime = $rentime + $crentime;
            $ticketcount = $resolvedtickets->count() + $cresolvedtickets->count();
            $trentime = $totalrentime / $ticketcount;
            /* $trentime = $rentime / $resolvedtickets->count(); */
        }
        else{
            $trentime = 0;
        }
        $totalresolvedticket = $resolvedticket + $closedticket;
        
        // Total Ticket Chart
        $totalticketchart = new TicketsReport;
        $data = DB::select('SELECT DATE(created_at) as date, count(created_at) as total FROM `tickets` GROUP BY DAY(`created_at`)');
        foreach($data as $dat){
            $label[] = $dat->date;
            $dt[] = $dat->total;
        }        
        $totalticketchart->labels($label);
        $totalticketchart->dataset('Total Tickets', 'line', $dt);
        /* $totalticketchart->dataset('Total Tickets', 'pie', $dt)->options(['backgroundColor' => CustomFunctions::colorsets()]); */

        // Tickets by Department
        $deptdata = DB::select('SELECT count(tickets.department_id) as total, departments.name FROM `tickets` 
        RIGHT OUTER JOIN departments ON departments.id = tickets.department_id GROUP BY departments.name');
        foreach($deptdata as $dat){
            $deptlabel[] = $dat->name;
            $deptdt[] = $dat->total;
        }
        $ticketdepartmentchart = new TicketsReport;
        $ticketdepartmentchart->labels($deptlabel);
        $ticketdepartmentchart->dataset('Total Tickets', 'pie', $deptdt)->options(['backgroundColor' => CustomFunctions::colorsets()]);
        /* $chart->dataset('Total Tickets', 'doughnut', $dt)->options(['backgroundColor' => CustomFunctions::colorsets()]); */   
        return view('tabs.it.rp',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }
    // Load List
    public function loadticketlist($id){
        if(Auth::user()->admin == true){           
            if($id == '1'){
                $tickets = Ticket::sortable()->orderBy('id','desc')->paginate(10);
                $sorting = '1';
                return view('tabs.it.al',compact('tickets','sorting'));
            }
            else if($id == '2'){
                $tickets = Ticket::sortable()->where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                $sorting = '2';
                return view('tabs.it.al',compact('tickets','sorting'));
            }
        }
        else{
            if(Auth::user()->tech == true){
                if($id == '1'){
                    $tickets = Ticket::sortable()->where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                    $sorting = '1';
                    return view('tabs.it.lt',compact('tickets','sorting'));
                }
                else if($id == '2'){
                    $tickets = Ticket::sortable()->where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                    $sorting = '2';
                    return view('tabs.it.lt',compact('tickets','sorting'));
                }
                /* else if($id == '3'){
                    $tickets = ClosedTicket::sortable()->where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                    $sorting = '3';
                    return view('tabs.it.lt',compact('tickets','sorting'));
                } */
            }
            else{
                if($id == '1'){
                    $tickets = Ticket::sortable()->where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                }
                /* else if($id == '3'){
                    $tickets = ClosedTicket::sortable()->where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
                } */
            }                 
        }
        /* return view('inc.ticketlist',compact('tickets')); */
    }
    public function testdb(){
        return 
        /* DB::select('SELECT tickets.department_id, tickets.id, departments.id, departments.name FROM `tickets` LEFT OUTER JOIN departments ON departments.id = tickets.department_id UNION
        SELECT tickets.department_id, tickets.id, departments.id, departments.name FROM `tickets` RIGHT OUTER JOIN departments ON departments.id = tickets.department_id'); */
        /* DB::select('SELECT count(tickets.department_id) as total, departments.name FROM `tickets` 
        RIGHT OUTER JOIN departments ON departments.id = tickets.department_id GROUP BY departments.name'); */
        /* CustomFunctions::generateRequestNumber(); */
        /* DB::select('SELECT * FROM `cctv_reviews` WHERE `user_id` = '.Auth::user()->id.' OR `assigned_to` = '.Auth::user()->id); */
        ClosedTicket::where('user_id',Auth::user()->id)->orderBy('id','desc')->get();
    }
}
