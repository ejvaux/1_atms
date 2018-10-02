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
        $ticketbytech = new TicketsReport;
        $data = DB::select("SELECT COUNT(tickets.assigned_to) as total, users.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at LIKE concat(curdate(),'%') AND tickets.assigned_to IS NOT null UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at LIKE concat(curdate(),'%') AND closed_tickets.assigned_to IS NOT null ) as tickets RIGHT JOIN users ON users.id = tickets.assigned_to WHERE users.tech = true GROUP BY users.name");
        foreach($data as $dat){
            $techlabels[] = $dat->name;
            $techdt[] = $dat->total;
        }
        $ticketbytech->labels($techlabels);
        $ticketbytech->dataset('Total Tickets', 'bar', $techdt);

        // Total Ticket Chart
        $totalticketchart = new TicketsReport;
        /* $data = DB::select('SELECT DATE(created_at) as date, count(created_at) as total FROM `tickets` GROUP BY DAY(`created_at`)'); */
        $data = DB::select("SELECT DATE_ADD( TIME(DATE_FORMAT(created_at, '%Y-%m-%d %H:00:00')), INTERVAL IF(MINUTE(created_at) < 30, 0, 1) HOUR ) as hr, count(created_at) as total FROM `tickets` WHERE `created_at` LIKE concat(curdate(),'%') GROUP BY HOUR(`created_at`)");
        if(!empty($data)){
            foreach($data as $dat){
                $label[] = $dat->hr;
                $dt[] = $dat->total;
            }            
        }
        else{
            $label[] = '';
            $dt[] = '';            
        }
        $totalticketchart->labels($label);
        $totalticketchart->dataset('Total Tickets', 'line', $dt);        

        // Tickets by Department
        /* $deptdata = DB::select('SELECT count(tickets.department_id) as total, departments.name FROM `tickets` 
        RIGHT OUTER JOIN departments ON departments.id = tickets.department_id GROUP BY departments.name'); */
        $deptdata = DB::select('SELECT count(department_id) as total, departments.name FROM ( SELECT * FROM `tickets` UNION ALL SELECT * FROM `closed_tickets` ) as ticket RIGHT OUTER JOIN departments ON departments.id = ticket.department_id WHERE ticket.created_at LIKE concat(curdate(),"%") GROUP BY departments.name');
        if(!empty($data)){
            foreach($deptdata as $dat){
                $deptlabel[] = $dat->name;
                $deptdt[] = $dat->total;
            }
        }
        else{
            $deptlabel[] = '';
            $deptdt[] = ''; 
        }        
        $ticketdepartmentchart = new TicketsReport;
        $ticketdepartmentchart->labels($deptlabel);
        $ticketdepartmentchart->dataset('Total Tickets', 'pie', $deptdt)->options(['backgroundColor' => CustomFunctions::colorsets()]);
        /* $chart->dataset('Total Tickets', 'doughnut', $dt)->options(['backgroundColor' => CustomFunctions::colorsets()]); */   
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
