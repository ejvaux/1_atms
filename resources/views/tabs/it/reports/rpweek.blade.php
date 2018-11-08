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
                                @include('tabs.it.reports.rpmenu')                                
                            </div>                            
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>    
    <div class='row mb-2'>
        <div class='col-md-4'>
            <div class="card repcard2 stat1">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$newticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Total Tickets</span>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 stat2">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$openticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Open Tickets</span>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 stat3">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$assignedticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Assigned Tickets</span>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
            <div class='col-md-4'>
                <div class="card repcard2 stat4">
                    <div class="card-body text-center">
                        <span class='font-weight-bold statnum'>{{$totalresolvedticket}}</span><br>
                        <span class='font-weight-bold statlabel'>Completed Tickets</span>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class="card repcard2 stat5">
                    <div class="card-body text-center">
                        @if($trtime > 60)
                            <span class='font-weight-bold statnum'>{{floor($trtime/60)}}.{{$trtime%60}}</span><span class='font-weight-bold statlabel'> hours</span><br>
                        @else
                            <span class='font-weight-bold statnum'>{{$trtime}}</span><span class='font-weight-bold statlabel'> minutes</span><br>
                        @endif                            
                        <span class='font-weight-bold statlabel'>Average response time</span>
                    </div>
                </div>
            </div>
            <div class='col-md-4'>
                <div class="card repcard2 stat6">
                    <div class="card-body text-center">
                        @if($trentime > 60)
                            <span class='font-weight-bold statnum'>{{floor($trentime/60)}}.{{$trentime%60}}</span><span class='font-weight-bold statlabel'> hours</span><br>
                        @else
                            <span class='font-weight-bold statnum'>{{round($trentime,2)}}</span><span class='font-weight-bold statlabel'> minutes</span><br>
                        @endif
                        <span class='font-weight-bold statlabel'>Average processing time</span>
                    </div>
                </div>
            </div>
        </div>
    {{-- <div class='row mb-2'>
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
    </div> --}}
</div>
@endsection
@section('graphs')
    {{-- {!! \Lava::render('ColumnChart', 'ticketbytech', 'ticketbytechdiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbypriority', 'ticketbyprioritydiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbydept', 'ticketbydeptdiv') !!}
    {!! \Lava::render('PieChart', 'ticketbycategory', 'ticketbycategorydiv') !!}
    {!! \Lava::render('ColumnChart', 'ticketbystatus', 'ticketbystatusdiv') !!} --}}
@endsection