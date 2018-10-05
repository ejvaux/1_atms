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
use App\CctvReview;

class DashboardController extends Controller
{   
    protected $departments;
    protected $categories;
    protected $statuses;
    protected $priorities;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->departments = Department::orderBy('name')->get();
        $this->categories = Category::orderBy('name')->get();
        $this->statuses = Status::orderBy('id')->get();
        $this->priorities = Priority::orderBy('id')->get();
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

    // USER
    public function userupdate($id)
    {
        $user = User::where('id',$id)->first();
        return view('auth.edit',compact('user'));
    }
    public function userchangepass()
    {       
        return view('auth.passwords.change');
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
        /* $statuses = $this->statuses; */
        $tickets = Ticket::sortable()->orderBy('id','desc')->paginate(10);
        $sorting = '1';
        return view('tabs.it.al', compact('tickets','sorting'));
    }
    public function adminviewticket($id)
    {        
        $departments = $this->departments;
        $categories = $this->categories;
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $users = User::where('tech',1)->get();
        $tickets = Ticket::where('id',$id)->first();
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.av', compact('tickets','updates','users','updatetext','departments','categories','priorities','statuses'));
    }
    public function listticket()
    {
        $tickets = Ticket::sortable()->where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);        
        $sorting = '1';
        return view('tabs.it.lt', compact('tickets','sorting'));
    }
    public function viewticket($id)
    {        
        $departments = $this->departments;
        $categories = $this->categories;        
        $statuses = $this->statuses;
        $priorities = $this->priorities;
        $tickets = Ticket::find($id);
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $users = User::where('tech',1)->get();
        $updatetext = '';
        return view('tabs.it.vt', compact('tickets','updates','updatetext','priorities','statuses','departments','categories','users'));
    }
    public function createticket()
    {        
        $departments = $this->departments;
        $categories = $this->categories;
        $priorities = $this->priorities;
        return view('tabs.it.ct', compact('categories', 'priorities','departments'));
    }
    public function admincreateticket()
    {        
        $departments = $this->departments;
        $categories = $this->categories;
        $priorities = $this->priorities;
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
        $tickets = Ticket::sortable()->where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10); 
        return view('tabs.it.ht',compact('tickets'));
    }
    public function viewhandledticket($id)
    {        
        $departments = $this->departments;
        $categories = $this->categories;
        $tickets = Ticket::where('id',$id)->first();        
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';        
        return view('tabs.it.htv', compact('tickets','updates','updatetext','priorities','statuses','departments','categories'));       
    }
    public function adminviewhandledticket($id)
    {        
        $departments = $this->departments;
        $categories = $this->categories;
        $tickets = Ticket::where('id',$id)->first();        
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ahtv', compact('tickets','updates','updatetext','priorities','statuses','departments','categories'));
    }
    public function closedticket()
    {
        $tickets = ClosedTicket::sortable()->where('user_id',Auth::user()->id)->orWhere('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.ctl',compact('tickets'));
    }
    public function adminclosedticket()
    {
        $tickets = ClosedTicket::sortable()->orderBy('id','desc')->paginate(10);
        return view('tabs.it.actl',compact('tickets'));
    }
    public function handledclosedticket()
    {
        $tickets = ClosedTicket::sortable()->where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.hct',compact('tickets'));
    }
    public function adminhandledclosedticket()
    {
        $tickets = ClosedTicket::sortable()->where('assigned_to',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        return view('tabs.it.ahct',compact('tickets'));
    }
    public function handledclosedticketview($id)
    {
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.hctv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function adminhandledclosedticketview($id)
    {
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ahctv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function closedticketview($id)
    {
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.ctlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function adminclosedticketview($id)
    {
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.actlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function declinedticket()
    {
        $tickets = DeclinedTicket::sortable()->orderBy('id','desc')->paginate(10);
        return view('tabs.it.dtl',compact('tickets'));
    }
    public function declinedticketview($id)
    {
        $tickets = DeclinedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        return view('tabs.it.dtv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    // Search
    public function adminsearchticket($id)
    {
        $tickets = Ticket::sortable()->join('users', 'users.id', '=', 'tickets.user_id')
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
        $tickets = Ticket::sortable()->join('users', 'users.id', '=', 'tickets.user_id')
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
    public function searchhandledticket($id)
    {
        $tickets = Ticket::sortable()->join('users', 'users.id', '=', 'tickets.user_id')
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
    public function searchhandledclosedticket($id)
    {
        $tickets = ClosedTicket::sortable()->join('users', 'users.id', '=', 'closed_tickets.user_id')
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
    public function searchclosedticket($id)
    {
        $tickets = ClosedTicket::sortable()->join('users', 'users.id', '=', 'closed_tickets.user_id')
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
    public function searchadminclosedticket($id)
    {
        $tickets = ClosedTicket::sortable()->join('users', 'users.id', '=', 'closed_tickets.user_id')
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
        $tickets = Ticket::sortable()->join('users', 'users.id', '=', 'tickets.user_id')
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
    public function searchadminhandledclosedticket($id)
    {
        $tickets = ClosedTicket::sortable()->join('users', 'users.id', '=', 'closed_tickets.user_id')
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
        $tickets = DeclinedTicket::sortable()->join('users', 'users.id', '=', 'declined_tickets.user_id')
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
    // Load List
    public function loadticketlist($id)
    {
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
    public function viewticketattach($id)
    {
        /* $images = json_decode(CctvReview::find($id)->pluck('attach')); */
        $img = Ticket::where('id',$id)->first();
        $images = json_decode($img->attach);
        return view('tabs.it.tda',compact('images'));
    }
    public function viewcticketattach($id)
    {
        /* $images = json_decode(CctvReview::find($id)->pluck('attach')); */
        $img = ClosedTicket::where('id',$id)->first();
        $images = json_decode($img->attach);
        return view('tabs.it.tda',compact('images'));
    }
    public function viewdticketattach($id)
    {
        /* $images = json_decode(CctvReview::find($id)->pluck('attach')); */
        $img = DeclinedTicket::where('id',$id)->first();
        $images = json_decode($img->attach);
        return view('tabs.it.tda',compact('images'));
    }
    public function testdb(Request $request)
    {        
        $rs = CctvReview::where('id',17)->first();
        $json = json_decode($rs->attach);
        return $json;
    }
}
