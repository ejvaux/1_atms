@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/1_atms/public/it/al">Tickets</a></li>
                    <li class="breadcrumb-item"><a href='/1_atms/public/it/dtl'>Declined Tickets</a></li>                    
                    <li class="breadcrumb-item">Details</li>
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.declinedviewticket');
</div>
@endsection