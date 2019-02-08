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
                    @else
                        <li class="breadcrumb-item text-muted"><a href="{{ url('/it/lt') }}">Tickets</a></li>
                    @endif                    
                    <li class="breadcrumb-item text-muted"><a href="{{ URL::previous() }}">Details</a></li>
                    <li class="breadcrumb-item text-muted">Ticket Attachments</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12 table-responsive">            
            {{-- @foreach ($images as $image)
                <a href="{{url('/storage/attachedfile/'.$image)}}" onclick="window.open(this.href,'_blank');return false;">
                    <img src="{{ url('/storage/attachedfile/'.$image) }}" style='width:auto;height:200px' class='border m-3' title='{{$image}}' />
                </a>
            @endforeach  --}}
            <table class='table table-bordered'>
                <thead class="thead-light">
                    <th>#</th>
                    <th>Filename</th>
                </thead>
                <tbody>                            
                    @foreach ($images as $image)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>
                                <div class='row'>
                                    <div class="col-md">
                                        {{$image}}
                                    </div>
                                    <div class="col-md">
                                        <a class='btn btn-primary' href='{{url('/storage/attachedfile/'.$image)}}' download='{{$image}}' download><i class="fas fa-download"></i> Download</a>
                                    </div>
                                </div>                               
                            </th>
                        </tr>
                    @endforeach                            
                </tbody>
            </table>   
        </div>
    </div>    
</div>
@endsection