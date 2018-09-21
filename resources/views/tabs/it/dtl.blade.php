@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href='/1_atms/public/it/al'>Tickets</a></li>
                    <li class="breadcrumb-item">Declined Tickets</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">      
        <div class="col-md-4 ml-auto">
            <form>
                <div class="input-group">                    
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Search ticket . . .">
                    <button type="button" value="/1_atms/public/it/dtl/" id="search"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.ticketlistdecline');</div>        
</div>
@endsection