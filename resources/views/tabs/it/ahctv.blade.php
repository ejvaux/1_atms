@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href="/1_atms/public/it/al">Tickets</a></li>
                    <li class="breadcrumb-item text-muted"><a href="/1_atms/public/it/aq">Handled Tickets</a></li>
                    <li class="breadcrumb-item text-muted"><a href='/1_atms/public/it/ahct'>Closed Handled Tickets</a></li>                    
                    <li class="breadcrumb-item text-muted">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.closedviewticket')
</div>
@endsection