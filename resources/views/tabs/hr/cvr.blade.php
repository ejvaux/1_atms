@extends('layouts.app2')

@section('pageTitle','Vehicle Request | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container" >
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb labelfontbold">
                    <li class="breadcrumb-item text-muted"><a href="/1_atms/public/hr/vrl">Vehicle Request</a></li>
                    <li class="breadcrumb-item text-muted">Create Vehicle Request</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12">
            <form class='form_to_submit' id='createvehiclerequestform' method='POST' action='/1_atms/public/vehiclerequest' enctype="multipart/form-data">                
                @csrf
                <input name="created_by" type="hidden" value="{{ Auth::user()->id }}">
                <div class="form-group row">                                        
                    <div class="col-md-3">
                        <label for="requested_date" class='labelfontbold text-muted'>Requested Date:</label>
                        <input class="form-control" type='date' id='requested_date' name='requested_date' required>
                    </div>
                    <div class="col-md-3">                            
                        <label for="departure_time" class='labelfontbold text-muted'>Departure Time:</label>
                        <input class="form-control" type='time' id='departure_time' name='departure_time' required>
                    </div>
                    <div class="col-md-3">                            
                        <label for="arrival_time" class='labelfontbold text-muted'>Arrival Time:</label>
                        <input class="form-control" type='time' id='arrival_time' name='arrival_time' required>
                    </div>
                    <div class="col-md-3">
                        <label for="department_id" class='labelfontbold text-muted'>Department:</label>
                        <select type="text" class="form-control custom-select" id="department_id" name="department_id" placeholder="" required>
                            <option value="">- Select Department -</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-8">
                        <label for="user" class='labelfontbold text-muted'>Name of User/s (Separate names by comma):</label>
                        <input class="form-control" type='text' id='position' name='user' required>
                    </div>
                    <div class="col-md-4">
                        <label for="position" class='form-label labelfontbold text-muted'>Position:</label>
                        <input class="form-control" type='text' id='position' name='position' required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md">
                        <label for="purpose" class='labelfontbold text-muted'>Destination/Purpose:</label>
                        <textarea type="text" class="form-control" rows="4" id="purpose" name="purpose" placeholder="" required></textarea>
                    </div>
                </div>
                <div class="form-group row text-right">                    
                    <div class="col-md">
                        <button type='submit' class="btn btn-primary form_submit_button" id="saveVehicleRequestButton"><i class="fa fa-share-square"></i> Submit Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
@endsection