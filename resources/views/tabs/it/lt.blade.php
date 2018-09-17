@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">My Tickets</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">
        @if(Auth::user()->tech == true)
            <div class='col-md'>
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a class="btn btn-secondary" href='/1_atms/public/it/ht'>Handled</a>
                    <a class="btn btn-secondary" href='/1_atms/public/it/ctl'>Closed</a>
                </div>
            </div>
            <div class='col-md-3 text-right'>
                <a class='btn btn-secondary' href='/1_atms/public/it/ct'>Create Ticket</a>
            </div>
        @else
            <div class='col-md-3'>
                <a class="btn btn-secondary" href='/1_atms/public/it/ctl'>Closed</a>
                <a class='btn btn-secondary' href='/1_atms/public/it/ct'>Create Ticket</a>
            </div>
        @endif
        {{-- <div class='col-md-3 ml-auto input-group'>
            <div class='input-group-prepend'>
                <label class='input-group-text'>Sort by: </label>
            </div>
            <select id='sortrequestdd' class="form-control">
                <option value='all'>All</option>
                <option value='handled'>Closed</option>
            </select>
        </div> --}}
        
        <div class="col-md-4 ml-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Enter ticket number . . .">
                    <button type="button" id="search" value="/1_atms/public/it/lt/"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.ticketlist');</div>        
</div>
@endsection