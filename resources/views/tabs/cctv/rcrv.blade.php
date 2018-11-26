@extends('layouts.app2')

@section('pageTitle','CCTV Review | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container'>
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href="{{ url('/cr/crl') }}">CCTV Review</a></li>
                    <li class="breadcrumb-item text-muted"><a href="{{ url('/cr/rcrl') }}">Rejected Requests</a></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.viewrejectedrequest')
</div>
@endsection