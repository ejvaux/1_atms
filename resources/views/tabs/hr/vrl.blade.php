@extends('layouts.app2')

@section('pageTitle','Vehicle Request | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted">Vehicle Request</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">
        <div class='col-md-6'>
            <a class='btn btn-secondary' href='/1_atms/public/hr/cvr'><i class="fa fa-plus-square"></i> Create Vehicle Request</a>
            @if (Auth::user()->hrvr_approval_type == 0 && Auth::user()->admin == 0)
            @else
            <a class="btn btn-secondary" href='{{ url('/hr/vra') }}'><i class="fas fa-thumbs-up"></i> Approved</a>
            @endif            
            {{-- <a class="btn btn-secondary" href='#'><i class="fas fa-ban"></i> Declined</a> --}}
        </div>        
        <div class="col-md-4 ml-auto">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="searchtextbox" placeholder="SEARCH: Enter request #. . .">
                    <button type="button" id="search" value='/1_atms/public/hr/vrl/'><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md">
            @if (Auth::user()->hrvr_approval_type > 0)
                <div class="input-color">
                    <input type="text" value="- For Approval" />
                    <div class="color-box" style="background-color:#E0F7FA; border-left: 2px solid green"></div>
                </div> 
            @endif                      
        </div>
    </div>
    <div id='table_list'>@include('inc.hr.vr.vehiclerequestlist')</div>
</div>
@endsection