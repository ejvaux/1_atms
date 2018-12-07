@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    @if (Auth::user()->isadmin())
                        <li class="breadcrumb-item text-muted"><a href='/1_atms/public/it/al'>Tickets</a></li>
                    @else
                        <li class="breadcrumb-item text-muted"><a href='{{ url("/it/lt") }}'>My Tickets</a></li>
                    @endif 
                    <li class="breadcrumb-item text-muted"><a href='/1_atms/public/it/dtl'>Declined Tickets</a></li>                    
                    <li class="breadcrumb-item text-muted">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.declinedviewticket')
</div>
@endsection