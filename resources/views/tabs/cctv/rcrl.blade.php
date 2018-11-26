@extends('layouts.app2')

@section('pageTitle','CCTV Review | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href='{{ url("/cr/crl") }}'>CCTV Review</a></li>
                    <li class="breadcrumb-item text-muted">Rejected Requests</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">             
        <div class="col-md-4">
            <form>
                <div class="input-group">                    
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Search Request . . .">
                    <button type="button" value="/1_atms/public/cr/crl/" id="search"><i class="fa fa-search"></i></button>
                </div>                
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.rejectedrequestlist')</div>
</div>
@endsection