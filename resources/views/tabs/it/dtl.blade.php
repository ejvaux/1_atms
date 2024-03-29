@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    @if (Auth::user()->isadmin())
                    <li class="breadcrumb-item text-muted"><a href='/1_atms/public/it/al'>Tickets</a></li>
                    @else
                    <li class="breadcrumb-item text-muted"><a href='{{ url("/it/lt") }}'>Tickets</a></li>
                    @endif                    
                    <li class="breadcrumb-item text-muted">Declined Tickets</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-2">      
        <div class="col-md-4">
            <form>
                <div class="input-group">                    
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Search ticket . . .">
                    <button type="button" value="/1_atms/public/it/dtl/" id="search"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.ticketlistdecline')</div>        
</div>
@endsection