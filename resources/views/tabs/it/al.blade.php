@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row'>
        <div class='col-lg'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Tickets</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class='row mb-2'>        
        <div class='col-md-3 '>
                <a class='btn btn-secondary' href='/1_atms/public/it/ac'><i class="fa fa-plus-square"></i> Create Ticket</a>
        </div>
        <div class='col-md  text-right'>
            <div class="btn-group" role="group" aria-label="Basic example">
                {{-- <a class="btn btn-secondary" href='/1_atms/public/it/aq'>Handled</a> --}}
                <a class="btn btn-secondary" href='/1_atms/public/it/dtl'>Declined</a>
                <a class="btn btn-secondary" href='/1_atms/public/it/actl'>Closed</a>                
            </div>
        </div>
        @if(Auth::user()->tech == true)
            <div class='col-md-3 input-group '>
                <div class='input-group-prepend'>
                    <label class='input-group-text'>Sort by: </label>
                </div>
                <select id='sortticketdd' class="form-control">
                <option value='all'>All</option>
                    @if($sorting == 2)
                        <option value='handled' selected="selected">Handled</option>
                    @else
                        <option value='handled'>Handled</option>
                    @endif                    
                </select>
            </div>
        @endif
        <div class="col-md-3 ml-0 pl-1 ">
            <form>
                <div class="input-group">                    
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Search ticket . . .">
                    <button type="button" value="/1_atms/public/it/al/" id="search"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.ticketlist');</div> 
    {{-- <div class='row mb-1'>
        <div class='col-lg table-responsive-lg'>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>#</th>
                        <th>@sortablelink('priority_id','Priority')</th>
                        <th>@sortablelink('subject','Subject')</th>
                        <th>@sortablelink('status_id','Status')</th>
                        <th>@sortablelink('created_at','Date')</th>
                        <th>@sortablelink('assigned_to','Assigned')</th>
                        <th>@sortablelink('updated_at','Updated')</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($tickets)>0)
                        @foreach($tickets as $ticket)
                            <tr>
                                <th>{{ $loop->iteration + (($tickets->currentPage() - 1) * 10) }}</th>
                                <th>
                                    {!! CustomFunctions::priority_format($ticket->priority_id) !!}<br>
                                    <span style="font-size:.8rem">
                                        @if ($ticket->start_at == null)
                                            @if ($ticket->status_id == 2)
                                                On Queue
                                            @else
                                                For Queuing
                                            @endif                                                
                                        @else
                                            @if($ticket->finish_at == null)
                                            {!! CustomFunctions::datetimelapse($ticket->start_at) !!}
                                            @else
                                            {!! CustomFunctions::datetimefinished($ticket->start_at,$ticket->finish_at) !!}
                                            @endif
                                        @endif
                                    </span>
                                </th>
                                <th style='width:35vw'>
                                    <div class='row' style="font-size:1rem">
                                        <div class='col-lg' style='overflow:hidden;text-overflow:ellipsis; white-space: nowrap ;width:300px'>
                                            <a class="adminviewticket" href="/1_atms/public/it/av/{{$ticket->id}}" ><span>{{$ticket->subject}}</span></a>
                                        </div>                                                                                
                                    </div>
                                    <div class='row' style='font-size:.8rem'>
                                        <div class='col-lg'>
                                            <span class='text-muted'><i class="fa fa-user"></i> 
                                                @if($ticket->user->name == null)
                                                    {{$ticket->username}}
                                                @else
                                                    {{$ticket->user->name}}
                                                @endif
                                            </span>                                        
                                            <span class='text-muted ml-2'><i class="fa fa-building"></i> 
                                                @if($ticket->department->name == null)
                                                    {{$ticket->department}}
                                                @else
                                                    {{$ticket->department->name}}
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                    <div class='row' style='font-size:.8rem'>
                                        <div class='col-lg'>                                            
                                            <span class='text-muted'><i class="fa fa-folder"></i> 
                                                @if(empty ( $ticket->category->name ))
                                                    {{$ticket->category}}
                                                @else
                                                    {{$ticket->category->name}}
                                                @endif
                                            </span>                                           
                                        </div>
                                    </div>                             
                                </th>
                                <th>
                                    <div class='row'>
                                        {!! CustomFunctions::status_color($ticket->status_id) !!}
                                    </div>
                                    <div class='row'>
                                        <span class='text-muted' style='font-size:.8rem'>#{{$ticket->ticket_id}}</span>
                                    </div>
                                </th>                    
                                <th>
                                    <span style='font-size:.8rem'>{!!str_replace(' ','<br>',$ticket->created_at)!!}</span>
                                </th>
                                <th>
                                    @if($ticket->assigned_to != '')                                        
                                        {{$ticket->assign->name}}
                                    @endif                                    
                                </th>
                                <th>
                                    <span style='font-size:.8rem'>{!!str_replace(' ','<br>',$ticket->updated_at)!!}</span>
                                </th>
                            </tr>                            
                        @endforeach
                        
                    @else
                        <p>No Tickets Found.</p>
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
    <div class='row'>
        <div class='col-lg'>
            {!! $tickets->appends(\Request::except('page'))->render() !!}
        </div>
    </div> --}}
</div>
@endsection