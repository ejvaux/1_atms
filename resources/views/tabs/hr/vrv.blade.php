@extends('layouts.app2')

@section('pageTitle','Vehicle Request | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container'>
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href="{{ url('/hr/vrl') }}">Vehicle Request</a></li>
                    <li class="breadcrumb-item text-muted">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.hr.vr.viewvehiclerequest')
</div>
@endsection