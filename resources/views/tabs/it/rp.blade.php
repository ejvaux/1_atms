@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('chart')
    {!! $totalticketchart->script() !!}
    {!! $ticketdepartmentchart->script() !!}
@endsection

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card">
                <div class="card-body">
                    <div class='container text-center'>
                        <div class='row'>
                            <div class='col-md'></div>
                            <div class='col-md-2 pt-2 mr-0'>
                                <label class='font-weight-bold'>Report Period:</label>
                            </div>
                            <div class='col-md-2 p-0 ml-0 mr-2'>
                                <select class='form-control'>
                                    <option value='1'>Today</option>                                   
                                    <option value='2'>Last 7 days</option>                                    
                                    <option value='3'>Last 30 days</option>
                                </select>
                            </div>
                            <div class='col-md-2 p-0 mx-1'>
                                <input class='form-control' type='date'>
                            </div>
                            <label class='pt-2 font-weight-bold'>-</label>
                            <div class='col-md-2 p-0 ml-1 mr-2'>
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
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card">
                <div class="card-header">
                    Tickets Stats
                </div>
                <div class='container'>                    
                    <div class='row'>
                        <div class='col-md-2 py-3 mx-0 text-center'>
                            {{-- @foreach($data as $dat)
                                {{$dat->date}} | {{$dat->total}} &
                            @endforeach --}}
                            <span class='font-weight-bold'>{{$newticket}}{{--  - {{ count($data) }} --}}</span><br>
                            <span>Total tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            <span class='font-weight-bold'>{{$openticket}}</span><br>
                            <span>Open tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            <span class='font-weight-bold'>{{$assignedticket}}</span><br>
                            <span>Assigned tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            <span class='font-weight-bold'>{{$totalresolvedticket}}</span><br>
                            <span>Completed Tickets</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            @if($trtime > 60)
                                <span class='font-weight-bold'>{{floor($trtime/60)}}.{{$trtime%60}} hours</span><br>
                            @else
                                <span class='font-weight-bold'>{{$trtime}} minutes</span><br>
                            @endif                            
                            <span>Average response time</span>
                        </div>
                        <div class='col-md-2 py-3 mx-0 text-center border-left'>
                            @if($trentime > 60)
                                <span class='font-weight-bold'>{{floor($trentime/60)}}.{{$trentime%60}} hours</span><br>
                            @else
                                <span>{{$trentime}} minutes</span><br>
                            @endif
                            <span>Average processing time</span> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <div class="card">
                <div class="card-header">
                    Tickets per day
                </div>
                <div class="card-body">
                    {!! $totalticketchart->container() !!}
                </div>
            </div>
        </div>
    </div>
    <div class='row mb-2'>
            <div class='col-md'>
                <div class="card">
                    <div class="card-header">
                        Tickets by Department
                    </div>
                    <div class="card-body">
                        {!! $ticketdepartmentchart->container() !!}
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection