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
use App\Custom\NotificationFunctions;
use App\Events\triggerEvent;
use App\Location;
use App\ReviewStatus;
use Response;
use App\VehicleApprovalType;
use App\VehicleRequest;

class DashboardController extends Controller
{   
    protected $departments;
    protected $categories;
    protected $statuses;
    protected $priorities;
    protected $user_list;
    protected $user_tech;

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
        $this->user_list = User::all();
        $this->user_tech = User::where('tech',1)->get();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Handled Tickets
        $queuedticketh = Ticket::where('status_id',2)->where('assigned_to',Auth::user()->id)->count();
        $inprogressticketh = Ticket::where('status_id',3)->where('assigned_to',Auth::user()->id)->count();
        $pendingticketh = Ticket::where('status_id',4)->where('assigned_to',Auth::user()->id)->count();
        $resolvedticketh = Ticket::where('status_id',5)->where('assigned_to',Auth::user()->id)->count();
        $closedticketh = ClosedTicket::where('status_id',6)->where('assigned_to',Auth::user()->id)->count();

        // Handled CCTV Reviews
        $queuedrequesth = CctvReview::where('status_id',2)->where('assigned_to',Auth::user()->id)->count();
        $inprogressrequesth = CctvReview::where('status_id',3)->where('assigned_to',Auth::user()->id)->count();
        $pendingrequesth = CctvReview::where('status_id',4)->where('assigned_to',Auth::user()->id)->count();
        $donerequesth = CctvReview::where('status_id',5)->where('assigned_to',Auth::user()->id)->count();

        // Tickets
        $openticket = Ticket::where('status_id',1)->where('user_id',Auth::user()->id)->count();
        $queuedticket = Ticket::where('status_id',2)->where('user_id',Auth::user()->id)->count();
        $inprogressticket = Ticket::where('status_id',3)->where('user_id',Auth::user()->id)->count();
        $pendingticket = Ticket::where('status_id',4)->where('user_id',Auth::user()->id)->count();
        $resolvedticket = Ticket::where('status_id',5)->where('user_id',Auth::user()->id)->count();
        $closedticket = ClosedTicket::where('status_id',6)->where('user_id',Auth::user()->id)->count();

        // CCTV Reviews
        $forapprovalrequest = CctvReview::where('status_id',6)->where('user_id',Auth::user()->id)->count();
        $approvedrequest = CctvReview::where('status_id',1)->where('user_id',Auth::user()->id)->count();
        $queuedrequest = CctvReview::where('status_id',2)->where('user_id',Auth::user()->id)->count();
        $inprogressrequest = CctvReview::where('status_id',3)->where('user_id',Auth::user()->id)->count();
        $pendingrequest = CctvReview::where('status_id',4)->where('user_id',Auth::user()->id)->count();
        $donerequest = CctvReview::where('status_id',5)->where('user_id',Auth::user()->id)->count();

        return view('tabs.home.dash',compact('openticket','queuedticket','inprogressticket','pendingticket','resolvedticket','closedticket',
                                            'forapprovalrequest','approvedrequest','queuedrequest','inprogressrequest','pendingrequest','donerequest',
                                            /* 'openticketh', */'queuedticketh','inprogressticketh','pendingticketh','resolvedticketh','closedticketh',
                                            /* 'forapprovalrequesth','approvedrequesth', */'queuedrequesth','inprogressrequesth','pendingrequesth','donerequesth'));
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
        $hr_vr_approval_types = VehicleApprovalType::orderBy('id')->get();
        $departments = $this->departments;
        return view('tabs.admin.role',compact('users','hr_vr_approval_types','departments'));
    }
    public function searchuserview($id)
    {   
        /* $users = User::paginate(20); */
        $users = User::where('name','like','%'.$id.'%')->orWhere('email','like','%'.$id.'%')->paginate(20);
        $hr_vr_approval_types = VehicleApprovalType::orderBy('id')->get();
        $departments = $this->departments;
        return view('tabs.admin.role',compact('users','hr_vr_approval_types','departments'));
    }
    public function viewexporttab()
    {
        $user_list = $this->user_list;
        $user_tech = $this->user_tech;
        $departments =  $this->departments;
        $categories = $this->categories;
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $locations = Location::orderBy('name')->get();
        $r_statuses = ReviewStatus::orderBy('id')->get();
        return view('tabs.admin.export',compact('user_list','departments','categories','priorities','statuses','user_tech',
                                                'locations','r_statuses'));
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
        $ticket = Ticket::where('id',$id)->first();
        // mark as read notification
        if(!empty($ticket)){
            NotificationFunctions::markread($ticket->ticket_id);            
        }

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
        NotificationFunctions::markread($tickets->ticket_id);
        return view('tabs.it.ctlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function adminclosedticketview($id)
    {
        $tickets = ClosedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        $ticket = ClosedTicket::where('id',$id)->first();
        // mark as read notification
        if(!empty($ticket)){
            NotificationFunctions::markread($ticket->ticket_id);            
        }
        return view('tabs.it.actlv',compact('tickets','updates','updatetext','priorities','statuses'));
    }
    public function declinedticket()
    {
        if (Auth::user()->isadmin()) {
            $tickets = DeclinedTicket::sortable()->orderBy('id','desc')->paginate(10);
        } else {
            $tickets = DeclinedTicket::sortable()->where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(10);
        }
        
        /* $tickets = DeclinedTicket::sortable()->orderBy('id','desc')->paginate(10); */
        return view('tabs.it.dtl',compact('tickets'));
    }
    public function declinedticketview($id)
    {
        $tickets = DeclinedTicket::where('id',$id)->first();   
        $priorities = $this->priorities;
        $statuses = $this->statuses;
        $updates = TicketUpdates::where('ticket_id',$id)->get();
        $updatetext = '';
        $ticket = DeclinedTicket::where('id',$id)->first();
        // mark as read notification
        if(!empty($ticket)){
            NotificationFunctions::markread($ticket->ticket_id);            
        }
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
        return view('tabs.it.ctda',compact('images'));
    }
    public function viewdticketattach($id)
    {
        /* $images = json_decode(CctvReview::find($id)->pluck('attach')); */
        $img = DeclinedTicket::where('id',$id)->first();
        $images = json_decode($img->attach);
        return view('tabs.it.dtda',compact('images'));
    }
    public function getunreadnotif()
    {        
        /* return DB::table('notifications')->where('notifiable_id', Auth::user()->id)->where('read_at',null)->get(); */
        /* return json_encode(Auth::user()->unReadNotifications); */
        return Auth::user()->unReadNotifications;
    }
    
    public function testdb(Request $request)
    {
        $vrequests1 = VehicleRequest::where(function($query)
        {
            if (Auth::user()->hrvr_approval_type == 1 || Auth::user()->hrvr_approval_type == 2) {
                $query->where('approval_id',Auth::user()->hrvr_approval_type - 1)
                ->where('department_id',Auth::user()->hrvr_approval_dept);
            } elseif (Auth::user()->hrvr_approval_type == 3 || Auth::user()->hrvr_approval_type == 4) {
                $query->where('approval_id',Auth::user()->hrvr_approval_type - 1);
            }                                
        })->where('created_by','!=',Auth::user()->id);
        $vrequests2 = VehicleRequest::where('created_by',Auth::user()->id);
        return  $vrequests1->union($vrequests2)->paginate('10');
    }
}
