@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div class='container text-center'>                        
                        <div class="row">
                            <div class="col-md">
                                <ul class="nav justify-content-center">
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/today')}}" class="nav-link btn btn-secondary">Day</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/week')}}" class="nav-link btn btn-outline-secondary">Week</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/month')}}" class="nav-link btn btn-outline-secondary">Month</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/year')}}" class="nav-link btn btn-outline-secondary">Year</a>
                                    </li>
                                    <li class="nav-item mx-1 ">
                                        <div class="dropdown">  
                                            <a class="nav-link btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                Custom Date Range
                                            </a>            
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <div class='dropdown-header'>
                                                    <form action="{{url('/it/rp/range')}}" method="post">
                                                        @csrf
                                                        <input class='' type='date' name='start_date'> -
                                                        <input class='' type='date' name='end_date'>
                                                        <button type='submit' class='btn btn-primary py-0'>Go!</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>                            
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>    
    <div class='row mb-0'>
        <div class='col-md-4'>                       
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pb-0">
                    {{-- <span class='font-weight-bold statnum'>{{$newticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Total Tickets</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$newticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='font-weight-bold statlabel'>Total Tickets</span>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pb-0">
                    {{-- <span class='font-weight-bold statnum'>{{$openticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Open Tickets</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$openticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='font-weight-bold statlabel'>Open Tickets</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pb-0">
                    {{-- <span class='font-weight-bold statnum'>{{$assignedticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Assigned Tickets</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$assignedticket}}</span>                                            
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='font-weight-bold statlabel'>In-Progress Tickets</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2 mt-0'>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pt-0">
                    {{-- <span class='font-weight-bold statnum'>{{$totalresolvedticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Completed Tickets</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-3">
                            <span class='font-weight-bold statnum'>{{$totalresolvedticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='font-weight-bold statlabel'>Completed<br>Tickets</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pt-0">
                    {{-- @if($trtime > 60)
                        <span class='font-weight-bold statnum'>{{floor($trtime/60)}}.{{$trtime%60}}</span><span class='font-weight-bold statlabel'> hours</span><br>
                    @else
                        <span class='font-weight-bold statnum'>{{$trtime}}</span><span class='font-weight-bold statlabel'> minutes</span><br>
                    @endif                            
                    <span class='font-weight-bold statlabel'>Average response time</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            @if($trtime > 60)
                                <span class='font-weight-bold statnum'>{{floor($trtime/60)}}.{{$trtime%60}}</span><br><span class='font-weight-bold statlabel'> hours</span>
                            @else
                                <span class='font-weight-bold statnum'>{{$trtime}}</span><br><span class='font-weight-bold statlabel'> minutes</span>
                            @endif                                        
                        </div>
                        <div class="col-md-7 stat3-2 p-2">                                        
                            <span class='font-weight-bold statlabel'>Average response<br>time</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pt-0">
                    {{-- @if($trentime > 60)
                        <span class='font-weight-bold statnum'>{{floor($trentime/60)}}.{{$trentime%60}}</span><span class='font-weight-bold statlabel'> hours</span><br>
                    @else
                        <span class='font-weight-bold statnum'>{{round($trentime,2)}}</span><span class='font-weight-bold statlabel'> minutes</span><br>
                    @endif
                    <span class='font-weight-bold statlabel'>Average processing time</span> --}}
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            @if($trentime > 60)
                                <span class='font-weight-bold statnum'>{{floor($trentime/60)}}.{{$trentime%60}}</span><br><span class='font-weight-bold statlabel'> hours</span>
                            @else
                                <span class='font-weight-bold statnum'>{{round($trentime,2)}}</span><br><span class='font-weight-bold statlabel'> minutes</span>
                            @endif                                           
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='font-weight-bold statlabel'>Average processing<br>time</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>    
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="ticketbytechdiv"></div>
                </div>
            </div>
        </div>        
    </div>
    <div class="row mb-2">
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="ticketbyprioritydiv"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class='row mb-2'>
        <div class='col-md'>
            <div class="card">
                <div class="card-header">
                    Tickets per Day
                </div>
                <div class="card-body">                    
                    {!! $totalticketchart->container() !!}                                           
                </div>
            </div>
        </div>
    </div> --}}
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="ticketbydeptdiv"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="ticketbycategorydiv"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="ticketbystatusdiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('graphs')
    {!! \Lava::render('ColumnChart', 'ticketbytech', 'ticketbytechdiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbypriority', 'ticketbyprioritydiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbydept', 'ticketbydeptdiv') !!}
    {!! \Lava::render('PieChart', 'ticketbycategory', 'ticketbycategorydiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbystatus', 'ticketbystatusdiv') !!}
@endsection