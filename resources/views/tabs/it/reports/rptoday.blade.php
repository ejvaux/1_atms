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
                        {{-- <div class="row">
                            <div class="col-md">
                                <div class='alert alert-danger mt-2'>
                                    *** UNDER DEVELOPMENT. DATA ARE FOR TODAY ONLY. ***
                                </div>
                            </div>
                        </div> --}}
                        <div class='row'>
                            <div class='col-md'></div>
                            <div class='col-md-1 pt-2 mr-0'>
                                <label class='font-weight-bold'>Period:</label>
                            </div>
                            <div class='col-md-2 p-0 ml-0 mr-2'>
                                <select class='form-control'>
                                    <option value='1'>Today</option>                                   
                                    <option value='2'>Last 7 days</option>                                    
                                    <option value='3'>Last 30 days</option>
                                </select>
                            </div>
                            <div class='col-md-3 p-0 mx-1'>
                                <input class='form-control' type='date'>
                            </div>
                            <label class='pt-2 font-weight-bold'>-</label>
                            <div class='col-md-3 p-0 ml-1 mr-2'>
                                <input class='form-control' type='date'>
                            </div>
                            <div class='col-md-1 p-0 mx-1'>
                                <button class='btn btn-primary form-control'>Update</button>
                            </div>
                            <div class='col-md'></div>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
    </div>
    {{-- <div class='row mb-2'>
        <div class='col-md'>
            <div class="card repcard">
                <div class='container'>                    
                    <div class='row'>
                        <div class='col-md-2 py-3 mx-0 text-center stat7'>                            
                            <span class='font-weight-bold'>{{$newticket}}</span><br>
                            <span class='font-weight-bold'>Total tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left stat7'>
                            <span class='font-weight-bold'>{{$openticket}}</span><br>
                            <span class='font-weight-bold'>Open tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left stat7'>
                            <span class='font-weight-bold'>{{$assignedticket}}</span><br>
                            <span class='font-weight-bold'>Assigned tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left stat7'>
                            <span class='font-weight-bold'>{{$totalresolvedticket}}</span><br>
                            <span class='font-weight-bold'>Completed Tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left stat7'>
                            @if($trtime > 60)
                                <span class='font-weight-bold'>{{floor($trtime/60)}}.{{$trtime%60}} hours</span><br>
                            @else
                                <span class='font-weight-bold'>{{$trtime}} minutes</span><br>
                            @endif                            
                            <span class='font-weight-bold'>Average response time</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            @if($trentime > 60)
                                <span class='font-weight-bold'>{{floor($trentime/60)}}.{{$trentime%60}} hours</span><br>
                            @else
                                <span class='font-weight-bold'>{{round($trentime,2)}} minutes</span><br>
                            @endif
                            <span class='font-weight-bold'>Average processing time</span> 
                        </div>
                    </div>                    
                </div>
            </div>
        </div>
    </div> --}}
    <div class='row mb-2'>
        <div class='col-md-4'>
            <div class="card repcard2 stat1">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$newticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Total tickets</span>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 stat2">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$openticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Open tickets</span>
                </div>
            </div>
        </div>
        <div class='col-md-4'>
            <div class="card repcard2 stat3">
                <div class="card-body text-center">
                    <span class='font-weight-bold statnum'>{{$assignedticket}}</span><br>
                    <span class='font-weight-bold statlabel'>Assigned tickets</span>
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