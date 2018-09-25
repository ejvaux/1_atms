@extends('layouts.app2')

@section('pageTitle','Dashboard | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container mt-4'>
    <div class='row'>
        <div class='col-md text-center'>
            <h1>IT Ticketing System</h1>
        </div>
    </div>
</div>
{{-- <div class="container">
    <div class="row mb-5">
        <div class="col-md-6">
            <div class="card-header">
                My Tickets
            </div>
            <div class="card">
                <div class="card-body">
                    Tickets Updates Here
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card-header">
                My Requests
            </div>
            <div class="card">
                <div class="card-body">
                    Requests Updates Here
                </div>
            </div>
        </div>
    </div>
    <div class="row">
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
    </div>
</div> --}}
@endsection