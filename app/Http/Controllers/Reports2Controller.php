<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;
use Carbon\Carbon;
use DB;
use App\Custom\CustomFunctions;
use App\CctvReview;
use App\Ticket;
use App\ClosedTicket;

class Reports2Controller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // TODAY ----------------------
    public function reviewreportstoday()
    {
        // Total requests
        $reviews = CctvReview::where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Approved requests
        $approvedreviews = CctvReview::where('approved',1)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // In-progress requests
        $inprogressreviews = CctvReview::where(function ($query) {
                                    $query->where('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Completed Reviews
        $totalcompletedreviews = CctvReview::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->count();

        // Average response time
        $artreviews = CctvReview::where('start_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
        $rtime = 0;
        foreach($artreviews as $artreview){
            $start = Carbon::parse($artreview->start_at);
            $created = Carbon::parse($artreview->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($artreviews->count()){
            $trtime = round($rtime / $artreviews->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $completedreviews = CctvReview::where('finish_at','!=',null)->where('created_at','LIKE','%'.Date('Y-m-d').'%')->get();
        $rentime = 0;
        foreach($completedreviews as $completedreview){
            $start = Carbon::parse($completedreview->start_at);
            $finish = Carbon::parse($completedreview->finish_at);
            $rentime += $finish->diffInMinutes($start);
        }
        
        if($completedreviews->count()){
            $reviewcount = $completedreviews->count();
            $trentime = round($rentime / $reviewcount, 2);
        }
        else{
            $trentime = 0;
        }
        
        // Reviews by Tech        
        $reviewbytechchart = \Lava::DataTable();
        $reviewbytechdata = DB::select("SELECT COUNT(cctv_reviews.assigned_to) as total, users.name as name FROM ( SELECT * FROM `cctv_reviews` WHERE cctv_reviews.created_at LIKE concat(curdate(),'%') AND cctv_reviews.assigned_to IS NOT null) as cctv_reviews RIGHT JOIN users ON users.id = cctv_reviews.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $reviewbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
        foreach($reviewbytechdata as $dat){
            $reviewbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('reviewbytech',$reviewbytechchart,[
            'title'=>'CCTV Reviews by Tech',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Priority
        $reviewbyprioritychart = \Lava::DataTable();
        $reviewbyprioritydata = DB::select("SELECT COUNT(cctv_reviews.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `cctv_reviews` WHERE cctv_reviews.created_at LIKE concat(curdate(),'%')) as cctv_reviews RIGHT JOIN priorities ON priorities.id = cctv_reviews.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $reviewbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
        foreach($reviewbyprioritydata as $dat){
            $reviewbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbypriority',$reviewbyprioritychart,[
            'title'=>'CCTV Reviews by Priority',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);                

        // Reviews by Department       
        $reviewbydeptchart = \Lava::DataTable();
        $reviewbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at LIKE concat(curdate(),'%')) as cctv_reviews RIGHT OUTER JOIN departments ON departments.id = cctv_reviews.department_id GROUP BY departments.name");
        $reviewbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($reviewbydeptdata as $dat){
            $reviewbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbydept',$reviewbydeptchart,[
            'title'=>'CCTV Reviews by Department',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Location
        $reviewbycategorychart = \Lava::DataTable();
        $reviewbycategorydata = DB::select("SELECT count(`location`) as total, locations.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at LIKE concat(curdate(),'%') ) as cctv_reviews RIGHT OUTER JOIN locations ON locations.id = cctv_reviews.`location` GROUP BY locations.name");
        $reviewbycategorychart->addStringColumn('Location')
                        ->addNumberColumn('Total');

        foreach($reviewbycategorydata as $dat){
            $reviewbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('reviewbycategory',$reviewbycategorychart,[
            'title'=>'CCTV Reviews by Location',
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Status
        $reviewbystatuschart = \Lava::DataTable();
        $reviewbystatusdata = DB::select("SELECT count(`status_id`) as total, review_statuses.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at LIKE concat(curdate(),'%')) as cctv_reviews RIGHT OUTER JOIN review_statuses ON review_statuses.id = cctv_reviews.`status_id` GROUP BY review_statuses.name ORDER BY review_statuses.id");
        $reviewbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($reviewbystatusdata as $dat){
            if($dat->name != 'Rejected'){
                $reviewbystatuschart->addRow([$dat->name,$dat->total]);
            }
        }

        \Lava::ColumnChart('reviewbystatus',$reviewbystatuschart,[
            'title'=>'CCTV Reviews by Status',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);
        
        return view('tabs.it.reports2.crptoday',compact('reviews','approvedreviews','inprogressreviews','totalcompletedreviews','trtime','trentime','rtime'));
    }

    // WEEK

    public function reviewreportsweek()
    {
        // Total Review
        $reviews = CctvReview::whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Approved Review
        $approvedreviews = CctvReview::where('status_id',1)->whereBetween('created_at', [now()->subDays(7), now()])->count();

        // In-Progress Review
        $inprogessreviews = CctvReview::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Completed Review
        $totalcompletedreviews = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->count();

        // Average response time
        $assignreviews = CctvReview::where('start_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->get();
        $rtime = 0;
        foreach($assignreviews as $assignreview){
            $start = Carbon::parse($assignreview->start_at);
            $created = Carbon::parse($assignreview->created_at);
            $rtime += $start->diffInMinutes($created);
        }
        if($assignreviews->count()){
            $trtime = round($rtime / $assignreviews->count(), 2);
        }
        else{
            $trtime = 0;
        }

        // Average processing time
        $completedreviews = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subDays(7), now()])->get();
        $rentime = 0;
        foreach($completedreviews as $completedreview){
            $start = Carbon::parse($completedreview->start_at);
            $finish = Carbon::parse($completedreview->finish_at);
            $rentime += $finish->diffInMinutes($start);
        }

        if($completedreviews->count()){
            $totalrentime = $rentime;
            $reviewcount = $completedreviews->count();
            $trentime = round($totalrentime / $reviewcount, 2);
        }
        else{
            $trentime = 0;
        }
        
        // Review by Date
        $reviewbydaychart = \Lava::DataTable();
        $reviewbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews GROUP BY DAY(`created_at`) ORDER BY `created_at`");
        $reviewbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        
        foreach($reviewbydaydata as $dat){            
            $reviewbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('reviewbyday',$reviewbydaychart,[
            'title'=>'CCTV Reviews by Day',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Review by Tech        
        $reviewbytechchart = \Lava::DataTable();
        $reviewbytechdata = DB::select("SELECT COUNT(cctv_reviews.assigned_to) as total, users.name as name FROM ( SELECT * FROM `cctv_reviews` WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND cctv_reviews.assigned_to IS NOT null) as cctv_reviews RIGHT JOIN users ON users.id = cctv_reviews.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $reviewbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
        foreach($reviewbytechdata as $dat){
            $reviewbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('reviewbytech',$reviewbytechchart,[
            'title'=>'CCTV Reviews by Tech',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Review by Priority
        $reviewbyprioritychart = \Lava::DataTable();
        $reviewbyprioritydata = DB::select("SELECT COUNT(cctv_reviews.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as cctv_reviews RIGHT JOIN priorities ON priorities.id = cctv_reviews.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $reviewbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
        foreach($reviewbyprioritydata as $dat){
            $reviewbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbypriority',$reviewbyprioritychart,[
            'title'=>'CCTV Reviews by Priority',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);                

        // Review by Department       
        $reviewbydeptchart = \Lava::DataTable();
        $reviewbydeptdata = DB::select("SELECT count(cctv_reviews.department_id) as total, departments.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN departments ON departments.id = cctv_reviews.department_id GROUP BY departments.name");
        $reviewbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($reviewbydeptdata as $dat){
            $reviewbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbydept',$reviewbydeptchart,[
            'title'=>'CCTV Reviews by Department',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Review by Category
        $reviewbycategorychart = \Lava::DataTable();
        $reviewbycategorydata = DB::select("SELECT count(`location`) as total, locations.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as cctv_reviews RIGHT OUTER JOIN locations ON locations.id = cctv_reviews.`location` GROUP BY locations.name");
        $reviewbycategorychart->addStringColumn('Location')
                        ->addNumberColumn('Total');

        foreach($reviewbycategorydata as $dat){
            $reviewbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('reviewbycategory',$reviewbycategorychart,[
            'title'=>'CCTV Reviews by Location',
            'fontName'=> 'Roboto Slab',
            ]);

        // Review by Status
        $reviewbystatuschart = \Lava::DataTable();
        $reviewbystatusdata = DB::select("SELECT count(cctv_reviews.`status_id`) as total, review_statuses.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 7 DAY) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN review_statuses ON review_statuses.id = cctv_reviews.`status_id` GROUP BY review_statuses.name ORDER BY review_statuses.id");
        $reviewbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($reviewbystatusdata as $dat){
            if($dat->name != 'Rejected'){
                $reviewbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('reviewbystatus',$reviewbystatuschart,[
            'title'=>'CCTV Reviews by Status',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);
        
        return view('tabs.it.reports2.crpweek',compact('reviews','approvedreviews','inprogessreviews','totalcompletedreviews','trtime','trentime','rtime'));
    }

    // MONTH 

    public function reviewreportsmonth()
    {
        // Total Reviews
        $newticket = CctvReview::whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Approved Reviews
        $openticket = CctvReview::where('status_id',1)->whereBetween('created_at', [now()->subMonth(), now()])->count();

        // In Progress Reviews
        $assignedticket = CctvReview::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subMonth(), now()])->count(); 

        // Completed Reviews
        $totalresolvedticket = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->count();

        // Average response time
        $assigntickets = CctvReview::where('start_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->get();
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
        $resolvedtickets = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subMonth(), now()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
        }
        
        if($resolvedtickets->count()){
            $totalrentime = $rentime;
            $ticketcount = $resolvedtickets->count();
            $trentime = round($totalrentime / $ticketcount, 2);
        }
        else{
            $trentime = 0;
        }
        
        // Reviews by Date
        $reviewbydaychart = \Lava::DataTable();
        $reviewbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 MONTH) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews GROUP BY DAY(`created_at`) ORDER BY `created_at`");
        $reviewbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        foreach($reviewbydaydata as $dat){            
            $reviewbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('reviewbyday',$reviewbydaychart,[
            'title'=>'CCTV Reviews by Day',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Tech        
        $reviewbytechchart = \Lava::DataTable();
        $reviewbytechdata = DB::select("SELECT COUNT(cctv_reviews.assigned_to) as total, users.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) AND cctv_reviews.assigned_to IS NOT null ) as cctv_reviews RIGHT JOIN users ON users.id = cctv_reviews.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $reviewbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
        foreach($reviewbytechdata as $dat){
            $reviewbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('reviewbytech',$reviewbytechchart,[
            'title'=>'CCTV Reviews by Tech',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Priority
        $reviewbyprioritychart = \Lava::DataTable();
        $reviewbyprioritydata = DB::select("SELECT COUNT(cctv_reviews.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT JOIN priorities ON priorities.id = cctv_reviews.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $reviewbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
        foreach($reviewbyprioritydata as $dat){
            $reviewbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbypriority',$reviewbyprioritychart,[
            'title'=>'CCTV Reviews by Priority',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);                

        // Reviews by Department       
        $reviewbydeptchart = \Lava::DataTable();
        $reviewbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as cctv_reviews RIGHT OUTER JOIN departments ON departments.id = cctv_reviews.department_id GROUP BY departments.name");
        $reviewbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($reviewbydeptdata as $dat){
            $reviewbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbydept',$reviewbydeptchart,[
            'title'=>'CCTV Reviews by Department',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Location
        $reviewbycategorychart = \Lava::DataTable();
        $reviewbycategorydata = DB::select("SELECT count(`location`) as total, locations.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY) ) as cctv_reviews RIGHT OUTER JOIN locations ON locations.id = cctv_reviews.`location` GROUP BY locations.name");
        $reviewbycategorychart->addStringColumn('Location')
                        ->addNumberColumn('Total');

        foreach($reviewbycategorydata as $dat){
            $reviewbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('reviewbycategory',$reviewbycategorychart,[
            'title'=>'CCTV Reviews by Location',
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Status
        $reviewbystatuschart = \Lava::DataTable();
        $reviewbystatusdata = DB::select("SELECT count(`status_id`) as total, review_statuses.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 30 DAY) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN review_statuses ON review_statuses.id = cctv_reviews.`status_id` GROUP BY review_statuses.name ORDER BY review_statuses.id");
        $reviewbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($reviewbystatusdata as $dat){
            if($dat->name != 'Rejected'){
                $reviewbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('reviewbystatus',$reviewbystatuschart,[
            'title'=>'CCTV Reviews by Status',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);
        
        return view('tabs.it.reports2.crpmonth',compact('newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }

    // YEAR

    public function reviewreportsyear()
    {
        // Total Tickets
        $newticket = CctvReview::whereBetween('created_at', [now()->subYear(), now()])->count();

        // Open Ticket
        $openticket = CctvReview::where('status_id',1)->whereBetween('created_at', [now()->subYear(), now()])->count();

        // Assigned Ticket
        $assignedticket = CctvReview::where(function ($query) {
                                        $query->where('status_id',2)
                                            ->orwhere('status_id',3)
                                            ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [now()->subYear(), now()])->count();

        // Completed Ticket
        $totalresolvedticket = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->count();

        // Average response time
        $assigntickets = CctvReview::where('start_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->get();
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
        $resolvedtickets = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [now()->subYear(), now()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
        }
        
        if($resolvedtickets->count()){
            $totalrentime = $rentime;
            $ticketcount = $resolvedtickets->count();
            $trentime = round($totalrentime / $ticketcount, 2);
        }
        else{
            $trentime = 0;
        }
        
        // Reviews by Date
        $reviewbydaychart = \Lava::DataTable();
        $reviewbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews GROUP BY DAY(`created_at`) ORDER BY `created_at`");
        $reviewbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');
        foreach($reviewbydaydata as $dat){            
            $reviewbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('reviewbyday',$reviewbydaychart,[
            'title'=>'CCTV Reviews by Day',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Tech        
        $reviewbytechchart = \Lava::DataTable();
        $reviewbytechdata = DB::select("SELECT COUNT(cctv_reviews.assigned_to) as total, users.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) AND cctv_reviews.assigned_to IS NOT null) as cctv_reviews RIGHT JOIN users ON users.id = cctv_reviews.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $reviewbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
        foreach($reviewbytechdata as $dat){
            $reviewbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('reviewbytech',$reviewbytechchart,[
            'title'=>'CCTV Reviews by Tech',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Priority
        $reviewbyprioritychart = \Lava::DataTable();
        $reviewbyprioritydata = DB::select("SELECT COUNT(tickets.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM `tickets` WHERE tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) UNION ALL SELECT * FROM `closed_tickets` WHERE closed_tickets.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY) ) as tickets RIGHT JOIN priorities ON priorities.id = tickets.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $reviewbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
        foreach($reviewbyprioritydata as $dat){
            $reviewbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbypriority',$reviewbyprioritychart,[
            'title'=>'CCTV Reviews by Priority',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);                

        // Reviews by Department       
        $reviewbydeptchart = \Lava::DataTable();
        $reviewbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN departments ON departments.id = cctv_reviews.department_id GROUP BY departments.name");
        $reviewbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($reviewbydeptdata as $dat){
            $reviewbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbydept',$reviewbydeptchart,[
            'title'=>'CCTV Reviews by Department',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Location
        $reviewbycategorychart = \Lava::DataTable();
        $reviewbycategorydata = DB::select("SELECT count(`location`) as total, locations.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN locations ON locations.id = cctv_reviews.`location` GROUP BY locations.name");
        $reviewbycategorychart->addStringColumn('Location')
                        ->addNumberColumn('Total');

        foreach($reviewbycategorydata as $dat){
            $reviewbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('reviewbycategory',$reviewbycategorychart,[
            'title'=>'CCTV Reviews by Location',
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Status
        $reviewbystatuschart = \Lava::DataTable();
        $reviewbystatusdata = DB::select("SELECT count(`status_id`) as total, review_statuses.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN DATE_SUB(curdate(),INTERVAL 1 YEAR) AND date_add(curdate(),INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN review_statuses ON review_statuses.id = cctv_reviews.`status_id` GROUP BY review_statuses.name ORDER BY review_statuses.id");
        $reviewbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($reviewbystatusdata as $dat){
            if($dat->name != 'Rejected'){
                $reviewbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('reviewbystatus',$reviewbystatuschart,[
            'title'=>'CCTV Reviews by Status',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);
        
        return view('tabs.it.reports2.crpyear',compact(/* 'ticketdepartmentchart','data','totalticketchart', */'newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }

    // RANGE

    public function reviewreportsrange(Request $request)
    {
        // Total Tickets
        $newticket = CctvReview::whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Open Ticket
        $openticket = CctvReview::where('status_id',1)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Assigned Ticket
        $assignedticket = CctvReview::where(function ($query) {
                                    $query->where('status_id',2)
                                        ->orwhere('status_id',3)
                                        ->orwhere('status_id',4);
                                })
                                ->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Completed Ticket
        $totalresolvedticket = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->count();

        // Average response time
        $assigntickets = CctvReview::where('start_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get();
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
        $resolvedtickets = CctvReview::where('finish_at','!=',null)->whereBetween('created_at', [$request->start_date, Carbon::parse($request->end_date)->addDay()])->get();
        $rentime = 0;
        foreach($resolvedtickets as $resolveticket){
            $start = Carbon::parse($resolveticket->start_at);
            $finish = Carbon::parse($resolveticket->finish_at);
            $rentime += $finish->diffInMinutes($start);
        }
        
        if($resolvedtickets->count()){
            $totalrentime = $rentime;
            $ticketcount = $resolvedtickets->count();
            $trentime = round($totalrentime / $ticketcount, 2);
        }
        else{
            $trentime = 0;
        }
        
        // Reviews by Date
        $reviewbydaychart = \Lava::DataTable();        
        $reviewbydaydata = DB::select("SELECT count(`id`) as total, DATE(created_at) AS date FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY)) as cctv_reviews GROUP BY DAY(`created_at`) ORDER BY `created_at`");
        $reviewbydaychart->addStringColumn('Date')
                        ->addNumberColumn('Total');        
        foreach($reviewbydaydata as $dat){            
            $reviewbydaychart->addRow([$dat->date,$dat->total]);
        }

        \Lava::LineChart('reviewbyday',$reviewbydaychart,[
            'title'=>'CCTV Reviews by Day',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Tech        
        $reviewbytechchart = \Lava::DataTable();
        $reviewbytechdata = DB::select("SELECT COUNT(cctv_reviews.assigned_to) as total, users.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY) AND cctv_reviews.assigned_to IS NOT null) as cctv_reviews RIGHT JOIN users ON users.id = cctv_reviews.assigned_to WHERE users.tech = true GROUP BY users.name");
        
        $reviewbytechchart->addStringColumn('Tech')
                        ->addNumberColumn('Total');
        foreach($reviewbytechdata as $dat){
            $reviewbytechchart->addRow([$dat->name,$dat->total]);
        }
        
        \Lava::ColumnChart('reviewbytech',$reviewbytechchart,[
            'title'=>'CCTV Reviews by Tech',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Priority
        $reviewbyprioritychart = \Lava::DataTable();
        $reviewbyprioritydata = DB::select("SELECT COUNT(cctv_reviews.`priority_id`) as total, priorities.name as name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY)) as cctv_reviews RIGHT JOIN priorities ON priorities.id = cctv_reviews.`priority_id` GROUP BY priorities.name ORDER BY priorities.id");

        $reviewbyprioritychart->addStringColumn('Priority')
                        ->addNumberColumn('Total');
        foreach($reviewbyprioritydata as $dat){
            $reviewbyprioritychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbypriority',$reviewbyprioritychart,[
            'title'=>'CCTV Reviews by Priority',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);                

        // Reviews by Department       
        $reviewbydeptchart = \Lava::DataTable();
        $reviewbydeptdata = DB::select("SELECT count(department_id) as total, departments.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN departments ON departments.id = cctv_reviews.department_id GROUP BY departments.name");
        $reviewbydeptchart->addStringColumn('Department')
                        ->addNumberColumn('Total');

        foreach($reviewbydeptdata as $dat){
            $reviewbydeptchart->addRow([$dat->name,$dat->total]);
        }

        \Lava::ColumnChart('reviewbydept',$reviewbydeptchart,[
            'title'=>'CCTV Reviews by Department',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Location
        $reviewbycategorychart = \Lava::DataTable();
        $reviewbycategorydata = DB::select("SELECT count(`location`) as total, locations.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN locations ON locations.id = cctv_reviews.location GROUP BY locations.name");
        $reviewbycategorychart->addStringColumn('Location')
                        ->addNumberColumn('Total');

        foreach($reviewbycategorydata as $dat){
            $reviewbycategorychart->addRow([$dat->name,$dat->total]);
        }

        \Lava::PieChart('reviewbycategory',$reviewbycategorychart,[
            'title'=>'CCTV Reviews by Location',
            'fontName'=> 'Roboto Slab',
            ]);

        // Reviews by Status
        $reviewbystatuschart = \Lava::DataTable();
        $reviewbystatusdata = DB::select("SELECT count(`status_id`) as total, review_statuses.name AS name FROM ( SELECT * FROM cctv_reviews WHERE cctv_reviews.created_at BETWEEN '".$request->start_date."' AND date_add('".$request->end_date."',INTERVAL 1 DAY)) as cctv_reviews RIGHT OUTER JOIN review_statuses ON review_statuses.id = cctv_reviews.`status_id` GROUP BY review_statuses.name ORDER BY review_statuses.id");
        $reviewbystatuschart->addStringColumn('Status')
                        ->addNumberColumn('Total');

        foreach($reviewbystatusdata as $dat){
            if($dat->name != 'Rejected'){
                $reviewbystatuschart->addRow([$dat->name,$dat->total]);
            }            
        }

        \Lava::ColumnChart('reviewbystatus',$reviewbystatuschart,[
            'title'=>'CCTV Reviews by Status',
            'colors'=> CustomFunctions::colorsets(),
            'fontName'=> 'Roboto Slab',
            ]);
        
        return view('tabs.it.reports2.crpcustom',compact(/* 'totalticketchart', */'newticket','openticket','assignedticket','totalresolvedticket','trtime','trentime','rtime'));
    }
}