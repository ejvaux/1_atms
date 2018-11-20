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

    /* 
    *
    *      TICKET
    *
    */
   
    // TODAY ----------------------
    public function ticketreportsToday()
    {
        // Tickets per day
        $newticket = Ticket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count() + ClosedTicket::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // In-progress Ticket
        $assignedticket = Ticket::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Completed Ticket
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
            $trtime = round($rtime / $assigntickets->count(), 2);
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
            $trentime = round($totalrentime / $ticketcount, 2);
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
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
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
            /* 'backgroundColor'   => '#F8F9F9', */
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
            /* 'backgroundColor'   => '#F8F9F9', */
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name ORDER BY statuses.id");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            if($dat->name != 'DECLINED'){
                $ticketbystatuschart->addRow([$dat->name,$dat->total]);
            }
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);
        
        return view('tabs.it.reports.rptoday',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime','ticketbytech'));
    }

    // WEEK

    public function ticketreportsweek()
    {
        // Total Tickets
        $newticket = Ticket::whereBetween('created_at', [now()->subDays(7), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Assigned Ticket
        $assignedticket = Ticket::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subDays(7), now()])->count() + 

        // Completed Ticket
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->get();
        $rtime = 0;
        foreach($assigntickets as $assignticket){
            $start = Carbon::parse($assignticket->start_at);
            $created = Carbon::parse($assignticket->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assigntickets->count()){
            $trtime = round($rtime / $assigntickets->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $resolvedtickets = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->get();
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
            $trentime = round($totalrentime / $ticketcount, 2);
            /* $trentime = $rentime / $resolvedtickets->count(); */
        }
        else{
            $trentime = 0;
        }
        
        // Tickets by Date
        $ticketbydaychart = \Lava::DataTable();
        $ticketbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets`  WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket GROUP BY DAY(`created_at`)");
        $ticketbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        /* $dateweek = now()->subDays(7);
        for($x = 0; $x <= 6; $x++){
            foreach($ticketbydaydata as $dat){
                if($dat->date == $dateweek){
                    $ticketbydaychart->addRow([$dat->date,$dat->total]);
                }              
            }
            $ticketbydaychart->addRow([$dateweek,0]);
            $dateweek = $dateweek->addDays(1);
        } */
        foreach($ticketbydaydata as $dat){            
            $ticketbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('ticketbyday',$ticketbydaychart,[
            'title'=>'Tickets by Day',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Tech        
        $ticketbytechchart = \Lava::DataTable();
        $ticketbytechdata = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $ticketbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbytechdata as $dat){
            $ticketbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('ticketbytech',$ticketbytechchart,[
            'title'=>'Tickets by Tech',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);                

        // Tickets by Department       
        $ticketbydeptchart = \Lava::DataTable();
        $ticketbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name");
        $ticketbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($ticketbydeptdata as $dat){
            $ticketbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbydept',$ticketbydeptchart,[
            'title'=>'Tickets by Department',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Tickets by Category
        $ticketbycategorychart = \Lava::DataTable();
        $ticketbycategorydata = DB::select("SELECT count(`category_id`) as total, categories.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN categories ON categories.id = ticket.`category_id` GROUP BY categories.name");
        $ticketbycategorychart->addStringColumn('Category')
                        ->addNumberColumn('Total');

        foreach($ticketbycategorydata as $dat){
            $ticketbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('ticketbycategory',$ticketbycategorychart,[
            'title'=>'Tickets by Category',
            /* 'backgroundColor'   => '#F8F9F9', */
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name ORDER BY statuses.id");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            if($dat->name != 'DECLINED'){
                $ticketbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);
        
        return view('tabs.it.reports.rpweek',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }

    // MONTH 

    public function ticketreportsmonth()
    {
        // Total Tickets
        $newticket = Ticket::whereBetween('created_at', [now()->subMonth(), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Assigned Ticket
        $assignedticket = Ticket::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subMonth(), now()])->count() + 

        // Completed Ticket
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->get();
        $rtime = 0;
        foreach($assigntickets as $assignticket){
            $start = Carbon::parse($assignticket->start_at);
            $created = Carbon::parse($assignticket->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assigntickets->count()){
            $trtime = round($rtime / $assigntickets->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $resolvedtickets = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->get();
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
            $trentime = round($totalrentime / $ticketcount, 2);
            /* $trentime = $rentime / $resolvedtickets->count(); */
        }
        else{
            $trentime = 0;
        }
        
        // Tickets by Date
        $ticketbydaychart = \Lava::DataTable();
        $ticketbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 MONTH) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets`  WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 MONTH) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket GROUP BY DAY(`created_at`)");
        $ticketbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        /* $dateweek = now()->subDays(7);
        for($x = 0; $x <= 6; $x++){
            foreach($ticketbydaydata as $dat){
                if($dat->date == $dateweek){
                    $ticketbydaychart->addRow([$dat->date,$dat->total]);
                }              
            }
            $ticketbydaychart->addRow([$dateweek,0]);
            $dateweek = $dateweek->addDays(1);
        } */
        foreach($ticketbydaydata as $dat){            
            $ticketbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('ticketbyday',$ticketbydaychart,[
            'title'=>'Tickets by Day',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Tech        
        $ticketbytechchart = \Lava::DataTable();
        $ticketbytechdata = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $ticketbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbytechdata as $dat){
            $ticketbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('ticketbytech',$ticketbytechchart,[
            'title'=>'Tickets by Tech',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);                

        // Tickets by Department       
        $ticketbydeptchart = \Lava::DataTable();
        $ticketbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name");
        $ticketbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($ticketbydeptdata as $dat){
            $ticketbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbydept',$ticketbydeptchart,[
            'title'=>'Tickets by Department',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Tickets by Category
        $ticketbycategorychart = \Lava::DataTable();
        $ticketbycategorydata = DB::select("SELECT count(`category_id`) as total, categories.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN categories ON categories.id = ticket.`category_id` GROUP BY categories.name");
        $ticketbycategorychart->addStringColumn('Category')
                        ->addNumberColumn('Total');

        foreach($ticketbycategorydata as $dat){
            $ticketbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('ticketbycategory',$ticketbycategorychart,[
            'title'=>'Tickets by Category',
            /* 'backgroundColor'   => '#F8F9F9', */
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name ORDER BY statuses.id");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            if($dat->name != 'DECLINED'){
                $ticketbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);
        
        return view('tabs.it.reports.rpmonth',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }

    // YEAR

    public function ticketreportsyear()
    {
        // Total Tickets
        $newticket = Ticket::whereBetween('created_at', [now()->subYear(), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subYear(), now()])->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->whereBetween('created_at', [now()->subYear(), now()])->count();

        // Assigned Ticket
        $assignedticket = Ticket::where(function ($query) {
                                        $query->where('status_id',2)
                                            ->orwhere('status_id',3)
                                            ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subYear(), now()])->count() + 

        // Completed Ticket
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->count() + ClosedTicket::whereBetween('created_at', [now()->subYear(), now()])->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->get();
        $rtime = 0;
        foreach($assigntickets as $assignticket){
            $start = Carbon::parse($assignticket->start_at);
            $created = Carbon::parse($assignticket->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assigntickets->count()){
            $trtime = round($rtime / $assigntickets->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $resolvedtickets = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->get();
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
            $trentime = round($totalrentime / $ticketcount, 2);
            /* $trentime = $rentime / $resolvedtickets->count(); */
        }
        else{
            $trentime = 0;
        }
        
        // Tickets by Date
        $ticketbydaychart = \Lava::DataTable();
        $ticketbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets`  WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket GROUP BY DAY(`created_at`)");
        $ticketbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        /* $dateweek = now()->subDays(7);
        for($x = 0; $x <= 6; $x++){
            foreach($ticketbydaydata as $dat){
                if($dat->date == $dateweek){
                    $ticketbydaychart->addRow([$dat->date,$dat->total]);
                }              
            }
            $ticketbydaychart->addRow([$dateweek,0]);
            $dateweek = $dateweek->addDays(1);
        } */
        foreach($ticketbydaydata as $dat){            
            $ticketbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('ticketbyday',$ticketbydaychart,[
            'title'=>'Tickets by Day',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Tech        
        $ticketbytechchart = \Lava::DataTable();
        $ticketbytechdata = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $ticketbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbytechdata as $dat){
            $ticketbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('ticketbytech',$ticketbytechchart,[
            'title'=>'Tickets by Tech',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);                

        // Tickets by Department       
        $ticketbydeptchart = \Lava::DataTable();
        $ticketbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name");
        $ticketbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($ticketbydeptdata as $dat){
            $ticketbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbydept',$ticketbydeptchart,[
            'title'=>'Tickets by Department',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Tickets by Category
        $ticketbycategorychart = \Lava::DataTable();
        $ticketbycategorydata = DB::select("SELECT count(`category_id`) as total, categories.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN categories ON categories.id = ticket.`category_id` GROUP BY categories.name");
        $ticketbycategorychart->addStringColumn('Category')
                        ->addNumberColumn('Total');

        foreach($ticketbycategorydata as $dat){
            $ticketbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('ticketbycategory',$ticketbycategorychart,[
            'title'=>'Tickets by Category',
            /* 'backgroundColor'   => '#F8F9F9', */
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name ORDER BY statuses.id");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            if($dat->name != 'DECLINED'){
                $ticketbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);
        
        return view('tabs.it.reports.rpyear',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }

    // RANGE

    public function ticketreportsrange(Request $request)
    {
        // Total Tickets
        $newticket = Ticket::whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count() + ClosedTicket::whereBetween('created_at', [$request->start_date, $request->end_date])->count();

        // Open Ticket
        $openticket = Ticket::where('status_id',1)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Assigned Ticket
        $assignedticket = Ticket::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count() + 

        // Completed Ticket
        $totalresolvedticket = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count() + ClosedTicket::whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Average response time
        $assigntickets = Ticket::where('start_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get();
        $rtime = 0;
        foreach($assigntickets as $assignticket){
            $start = Carbon::parse($assignticket->start_at);
            $created = Carbon::parse($assignticket->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assigntickets->count()){
            $trtime = round($rtime / $assigntickets->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $resolvedtickets = Ticket::where('finish_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
            /* $rentime += $resolvedticket->finish_at - $resolvedticket->start_at; */
        }

        $cresolvedtickets = ClosedTicket::where('finish_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get();
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
            $trentime = round($totalrentime / $ticketcount, 2);
            /* $trentime = $rentime / $resolvedtickets->count(); */
        }
        else{
            $trentime = 0;
        }
        
        // Tickets by Date
        $ticketbydaychart = \Lava::DataTable();
        /* $ticketbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets`  WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as ticket GROUP BY DAY(`created_at`)"); */
        $ticketbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets`  WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) ) as ticket GROUP BY DAY(`created_at`)");
        $ticketbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');        
        foreach($ticketbydaydata as $dat){            
            $ticketbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('ticketbyday',$ticketbydaychart,[
            'title'=>'Tickets by Day',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Tech        
        $ticketbytechchart = \Lava::DataTable();
        $ticketbytechdata = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $ticketbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbytechdata as $dat){
            $ticketbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('ticketbytech',$ticketbytechchart,[
            'title'=>'Tickets by Tech',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Ticket by Priority
        $ticketbyprioritychart = \Lava::DataTable();
        $ticketbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $ticketbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
                        /* ->addRow($loclabels,$locdt) */;
        foreach($ticketbyprioritydata as $dat){
            $ticketbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbypriority',$ticketbyprioritychart,[
            'title'=>'Tickets by Priority',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);                

        // Tickets by Department       
        $ticketbydeptchart = \Lava::DataTable();
        $ticketbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id GROUP BY departments.name");
        $ticketbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($ticketbydeptdata as $dat){
            $ticketbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('ticketbydept',$ticketbydeptchart,[
            'title'=>'Tickets by Department',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);

        // Tickets by Category
        $ticketbycategorychart = \Lava::DataTable();
        $ticketbycategorydata = DB::select("SELECT count(`category_id`) as total, categories.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN categories ON categories.id = ticket.`category_id` GROUP BY categories.name");
        $ticketbycategorychart->addStringColumn('Category')
                        ->addNumberColumn('Total');

        foreach($ticketbycategorydata as $dat){
            $ticketbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('ticketbycategory',$ticketbycategorychart,[
            'title'=>'Tickets by Category',
            /* 'backgroundColor'   => '#F8F9F9', */
            /* 'colors'=> array('#26C6DA'), */
            ]);

        // Tickets by Status
        $ticketbystatuschart = \Lava::DataTable();
        $ticketbystatusdata = DB::select("SELECT count(`status_id`) as total, statuses.name AS name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) ) as ticket RIGHT OUTER JOIN statuses ON statuses.id = ticket.`status_id` GROUP BY statuses.name ORDER BY statuses.id");
        $ticketbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($ticketbystatusdata as $dat){
            if($dat->name != 'DECLINED'){
                $ticketbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('ticketbystatus',$ticketbystatuschart,[
            'title'=>'Tickets by Status',
            'colors'=> array('#26C6DA'),
            /* 'backgroundColor'   => '#F8F9F9', */
            ]);
        
        return view('tabs.it.reports.rpcustom',compact('ticketdepartmentchart','data','totalticketchart','newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }
}
