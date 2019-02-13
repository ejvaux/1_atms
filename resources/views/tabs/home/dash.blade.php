@extends('layouts.app2')

@section('pageTitle','Dashboard | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container'>
    <div class='row'>
        <div class='col-md text-center'>
            {{-- <h1>Dashboard</h1> --}}
            <nav>
                <ol class="breadcrumb labelfontbold" {{-- style='background-color:#3498DB' --}}>
                    <li class="breadcrumb-item text-muted">Dashboard</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-md">
            <div class="alert alert-warning" role="alert">
                <span class='font-weight-bold mr-2'>SYSTEM UPDATED: </span>
                If the sidebar is missing, please hard refresh the page by pressing "CTRL + F5" to clear the cache. Thank you.
            </div>
        </div>
    </div>
    {{-- Handled Ticket and Requests --}}
    @if(Auth::user()->tech == 1)
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card-header labelfont" style='background-color:/* #85C1E9 */#707B7C; color:white'>
                My Handled Tickets
            </div>
            <div class="card" style='background-color:/* #D6EAF8 */#E5E8E8'>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    For Accept:
                                </div>
                                <div class="col">
                                    {{ $queuedticketh }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    In-Progress:
                                </div>
                                <div class="col">
                                    {{ $inprogressticketh }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Pending:
                                </div>
                                <div class="col">
                                    {{ $pendingticketh }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Resolved:
                                </div>
                                <div class="col">
                                    {{ $resolvedticketh }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Closed:
                                </div>
                                <div class="col">
                                    {{ $closedticketh }}
                                </div>
                            </div>
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header labelfont" style='background-color:/* #85C1E9 */#707B7C; color:white'>
                My Handled CCTV Review Requests
            </div>
            <div class="card" style='background-color:/* #D6EAF8 */#E5E8E8'>
                <div class="card-body">
                    <ul class="list-group list-group-flush">                        
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    For Accept:
                                </div>
                                <div class="col">
                                    {{ $queuedrequesth }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    In-Progress:
                                </div>
                                <div class="col">
                                    {{ $inprogressrequesth }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Pending:
                                </div>
                                <div class="col">
                                    {{ $pendingrequesth }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Done:
                                </div>
                                <div class="col">
                                    {{ $donerequesth }}
                                </div>
                            </div>
                        </li>                     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- My Ticket and Requests --}}
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card-header labelfont" style='background-color:/* #85C1E9 */#707B7C; color:white'>
                My Tickets
            </div>
            <div class="card" style='background-color:/* #D6EAF8 */#E5E8E8'>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Open:
                                </div>
                                <div class="col">
                                    {{ $openticket }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Queued:
                                </div>
                                <div class="col">
                                    {{ $queuedticket }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    In-Progress:
                                </div>
                                <div class="col">
                                    {{ $inprogressticket }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Pending:
                                </div>
                                <div class="col">
                                    {{ $pendingticket }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Resolved:
                                </div>
                                <div class="col">
                                    {{ $resolvedticket }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Closed:
                                </div>
                                <div class="col">
                                    {{ $closedticket }}
                                </div>
                            </div>
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header labelfont" style='background-color:/* #85C1E9 */#707B7C; color:white'>
                My CCTV Review Requests
            </div>
            <div class="card" style='background-color:/* #D6EAF8 */#E5E8E8'>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    For Approval:
                                </div>
                                <div class="col">
                                    {{ $forapprovalrequest }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Approved:
                                </div>
                                <div class="col">
                                    {{ $approvedrequest }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Queued:
                                </div>
                                <div class="col">
                                    {{ $queuedrequest }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    In-Progress:
                                </div>
                                <div class="col">
                                    {{ $inprogressrequest }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Pending:
                                </div>
                                <div class="col">
                                    {{ $pendingrequest }}
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="row">
                                <div class="col-md-6">
                                    Done:
                                </div>
                                <div class="col">
                                    {{ $donerequest }}
                                </div>
                            </div>
                        </li>                     
                    </ul>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6">
            <div class="card-header">
                My Approvals
            </div>
            <div class="card">
                <div class="card-body">
                    Approvals Updates Here
                </div>
            </div>
        </div>
        <div class='col'>
        </div>
    </div> --}}
</div>
@endsection