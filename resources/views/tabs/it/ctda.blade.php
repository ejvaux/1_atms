@extends('layouts.app2')

@section('pageTitle','CCTV Review | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container admincreateticket_container" >
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    @if(Auth::user()->admin == 1)
                        <li class="breadcrumb-item text-muted"><a href="{{ url('/it/al') }}">Tickets</a></li>
                        <li class="breadcrumb-item text-muted"><a href="{{ url('/it/actl') }}">Closed Tickets</a></li>
                    @else
                        <li class="breadcrumb-item text-muted"><a href="{{ url('/it/lt') }}">Tickets</a></li>
                        <li class="breadcrumb-item text-muted"><a href="{{ url('/it/ctl') }}">Closed Tickets</a></li>
                    @endif                    
                    <li class="breadcrumb-item text-muted"><a href="{{ URL::previous() }}">Details</a></li>
                    <li class="breadcrumb-item text-muted">Ticket Attachments</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12">            
            @foreach ($images as $image)
                <a href="{{url('/storage/attachedfile/'.$image)}}" onclick="window.open(this.href,'_blank');return false;">
                    <img src="{{ url('/storage/attachedfile/'.$image) }}" style='width:auto;height:200px' class='border m-3' title='{{$image}}' />
                </a>
            @endforeach      
        </div>
    </div>    
</div>
@endsection