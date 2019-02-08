@extends('layouts.app2')

@section('pageTitle','Vehicle Request | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href="../hr/vrl">Vehicle Request</a></li>
                    <li class="breadcrumb-item text-muted">Approved Request</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">
        <div class='col-md-6'>
            <a class='btn btn-secondary' href='/1_atms/public/hr/cvr'><i class="fa fa-plus-square"></i> Create Vehicle Request</a>
            {{-- <a class="btn btn-secondary" href='#'><i class="fas fa-ban"></i> Declined</a> --}}
        </div>        
        <div class="col-md-4 ml-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Enter vehicle request number . . .">
                    <button type="button" id="search"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.hr.vr.vehiclerequestlist')</div>
</div>
@endsection