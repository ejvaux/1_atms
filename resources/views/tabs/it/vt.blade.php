@extends('layouts.app2')

@section('pageTitle','Ticket | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container">
    <div class='row mb-2'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    @if(Auth::user()->admin == true)
                        <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Tickets</a></li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ URL::previous() }}">My Tickets</a></li>
                    @endif
                    <li class="breadcrumb-item">Details</li>                    
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    @include('inc.viewticket');
</div>
@endsection