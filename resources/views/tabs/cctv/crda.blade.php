@extends('layouts.app2')

@section('pageTitle','CCTV Review | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container admincreateticket_container" >
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ url('/cr/crl') }}">CCTV Review</a></li>
                    <li class="breadcrumb-item"><a href="{{ URL::previous() }}">Request Details</a></li>
                    <li class="breadcrumb-item">Request Attachments</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12">
            <table class='table table-bordered'>
                <thead class="thead-light">
                    <th>#</th>
                    <th>Filename</th>
                    <th>Action</th>
                </thead>
                <tbody>                            
                    @foreach ($images as $image)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <th>               
                                {{-- <a href="{{url('/storage/requestfile/'.$image)}}" onclick="window.open(this.href,'_blank');return false;">
                                    <img src="{{ url('/storage/requestfile/'.$image) }}" style='width:auto;height:200px' class='border m-3' title='{{$image}}' />
                                </a> --}}
                                {{$image}}
                            </th>
                            <th>
                                <a class='btn btn-primary' href='{{url('/storage/requestfile/'.$image)}}' onclick="window.open(this.href,'_blank');return false;"><i class="far fa-eye"></i> Preview</a>                                    
                                <a class='btn btn-primary' href='{{url('/storage/requestfile/'.$image)}}' download='{{$image}}' download><i class="fas fa-download"></i> Download</a>
                            </th>
                        </tr>
                    @endforeach                            
                </tbody>
            </table>            
        </div>
    </div>    
</div>
@endsection