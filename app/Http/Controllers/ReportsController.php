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

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Reports
    public function ticketreportsToday()
    {
        // Tickets per day
        $newticket = Ticket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count() + ClosedTicket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Assigned Ticket
        $assignedticket = Ticket::where('assigned_to','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Completed Ticket
        $resolvedticket = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();
        $closedticket = ClosedTicket::count();
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count() + ClosedTicket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
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
        $resolvedtickets = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
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
        
        // Ticket by Tech        
        $ticketbytechchart = \Lava::DataTable();
        $ticketbytechdata = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $ticketbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbytechdata as $dat){
            $ticketbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('ticketbytech',$ticketbytechchart,[
            'title'=>'Tickets by Tech',
            'colors'=> array('#26C6DA'),
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            ]);                

        // Tickets by Department       
        $ticketbydeptchart = \Lava::DataTable();
        $ticketbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name");
        $ticketbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($ticketbydeptdata as $dat){
            $ticketbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbydept',$ticketbydeptchart,[
            'title'=>'Tickets by Department',
            'colors'=> array('#26C6DA'),
            ]);

        // Tickets by Category
        $ticketbycategorychart = \Lava::DataTable();
        $ticketbycategorydata = DB::select("SELECT count(`category_id`) as total, categories.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as ticket RIGHT OUTER JOIN categories ON categories.id = ticket.`category_id` GROUP BY categories.name");
        $ticketbycategorychart->addStringColumn('Category')
                        ->addNumberColumn('Total');

        foreach($ticketbycategorydata as $dat){
            $ticketbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('ticketbycategory',$ticketbycategorychart,[
            'title'=>'Tickets by Category',
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            $ticketbystatuschart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            ]);
        
        return view('tabs.it.reports.rptoday',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime','ticketbytech'));
    }
    public function ticketreportsweek()
    {
        // Tickets per day
        $newticket = Ticket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count() + ClosedTicket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Assigned Ticket
        $assignedticket = Ticket::where('assigned_to','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Completed Ticket
        $resolvedticket = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();
        $closedticket = ClosedTicket::count();
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count() + ClosedTicket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
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
        $resolvedtickets = Ticket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
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
        /* $deptdata = DB::select('SELECT count(tickets.department_id) as total, departments.name FROM `tickets` 
        RIGHT OUTER JOIN departments ON departments.id = tickets.department_id GROUP BY departments.name'); */
        $deptdata = DB::select('SELECT count(department_id) as total, departments.name FROM ( SELECT * FROM `tickets` UNION ALL SELECT * FROM `closed_tickets` ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name');
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
}
