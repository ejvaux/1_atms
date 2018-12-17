@extends('layouts.app2')

@section('pageTitle','Dashboard | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted">CCTV Reviews - Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div class='container text-center'>                        
                        <div class="row">
                            <div class="col-md">
                                <ul class="nav justify-content-center labelfontbold">
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/ctoday')}}" class="nav-link btn btn-outline-secondary">Day</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/cweek')}}" class="nav-link btn btn-outline-secondary">Week</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/cmonth')}}" class="nav-link btn btn-outline-secondary">Month</a>
                                    </li>
                                    <li class="nav-item mx-1">
                                        <a href="{{url('/it/rp/cyear')}}" class="nav-link btn btn-secondary">Year</a>
                                    </li>
                                    <li class="nav-item mx-1 ">
                                        <div class="dropdown">  
                                            <a class="nav-link btn btn-outline-secondary dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                                Custom Date Range
                                            </a>            
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <div class='dropdown-header'>
                                                    <form action="{{url('/it/rp/crange')}}" method="post">
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
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$newticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='labelfont statlabel'>Total Reviews</span>
                        </div>
                    </div>                   
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pb-0">                    
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$openticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='labelfont statlabel'>Approved Reviews</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pb-0">
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            <span class='font-weight-bold statnum'>{{$assignedticket}}</span>                                            
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='labelfont statlabel'>In-Progress Reviews</span>                                    
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
                    <div class="row">
                        <div class="col-md-5 stat3 p-3">
                            <span class='font-weight-bold statnum'>{{$totalresolvedticket}}</span>
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='labelfont statlabel'>Completed<br>Reviews</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pt-0">
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            @if($trtime > 60)
                                <span class='font-weight-bold statnum'>{{floor($trtime/60)}}.{{$trtime%60}}</span><br><span class='labelfont statlabel'> hours</span>
                            @else
                                <span class='font-weight-bold statnum'>{{$trtime}}</span><br><span class='labelfont statlabel'> minutes</span>
                            @endif                                        
                        </div>
                        <div class="col-md-7 stat3-2 p-2">                                        
                            <span class='labelfont statlabel'>Average response<br>time</span>                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 border-0">
                <div class="card-body text-center p-3 pt-0">
                    <div class="row">
                        <div class="col-md-5 stat3 p-2">
                            @if($trentime > 60)
                                <span class='font-weight-bold statnum'>{{floor($trentime/60)}}.{{$trentime%60}}</span><br><span class='labelfont statlabel'> hours</span>
                            @else
                                <span class='font-weight-bold statnum'>{{round($trentime,2)}}</span><br><span class='labelfont statlabel'> minutes</span>
                            @endif                                           
                        </div>
                        <div class="col-md-7 stat3-2 p-2">
                            <span class='labelfont statlabel'>Average processing<br>time</span>                                    
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
                        <div id="reviewbydaydiv"></div>
                    </div>
                </div>
            </div>        
        </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="reviewbytechdiv"></div>
                </div>
            </div>
        </div>        
    </div>
    <div class="row mb-2">
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="reviewbyprioritydiv"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="reviewbydeptdiv"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="reviewbystatusdiv"></div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class="card-body">
                    <div id="reviewbycategorydiv"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('graphs')
    {!! \Lava::render('LineChart', 'reviewbyday', 'reviewbydaydiv') !!}
    {!! \Lava::render('ColumnChart', 'reviewbytech', 'reviewbytechdiv') !!}
    {!! \Lava::render('ColumnChart', 'reviewbypriority', 'reviewbyprioritydiv') !!}
    {!! \Lava::render('ColumnChart', 'reviewbydept', 'reviewbydeptdiv') !!}
    {!! \Lava::render('PieChart', 'reviewbycategory', 'reviewbycategorydiv') !!}
    {!! \Lava::render('ColumnChart', 'reviewbystatus', 'reviewbystatusdiv') !!}
@endsection