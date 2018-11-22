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
                    <li class="breadcrumb-item">Create Request</li>
                    {{-- <li class="breadcrumb-item">Data</li> --}}
                </ol>
            </nav>
        </div>
    </div>
    <div class="row pt-1">
        <div class="col-md-12">
            <form class='form_to_submit' id='createrequestform' method='POST' action='/1_atms/public/cctvreview' enctype="multipart/form-data">                
                @csrf
                <input name="user_id" type="hidden" value="{{ Auth::user()->id }}">                
                <input type="hidden" id="username" name="username" placeholder="" value="{{ Auth::user()->name }}">
                <input type='hidden' id="createticket_message" name="message">
                <input type='hidden' name="mod" value='default'>
                <input type='hidden' name="request_id" value='{{ CustomFunctions::generateRequestNumber() }}'>
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="subject">Subject:</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="" required>
                    </div>                    
                    <div class="col-md-2">
                        <label for="priority">Priority:</label>
                        <select type="text" class="form-control custom-select" id="priority" name="priority_id" placeholder="" required>
                            <option value="">- Select Priority -</option>
                            @foreach($priorities as $priority)
                                <option value="{{$priority->id}}">{{$priority->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">                            
                        <label for="priority">Location:</label>
                        <select type="text" class="form-control custom-select" id="priority" name="location" placeholder="" required>
                            <option value="">- Select Location -</option>
                            @foreach($locations as $location)
                                <option value="{{$location->id}}">{{$location->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="department">Department:</label> 
                        <select type="text" class="form-control custom-select" id="department" name="department_id" placeholder="" required>
                            <option value="">- Select Department -</option>
                            @foreach($departments as $department)
                                <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-7'>
                        <label for="start_time">Time:</label>
                        <div class="btn-group">
                            <input class="form-control" type='datetime-local' id='start_time' name='start_time' required><span class='pt-2 mx-1'> to </span><input class="form-control" type='datetime-local' id='end_time' name='end_time' required>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <label>Attach Report:</label>
                        <input class='border' type='file' name='report'>                        
                    </div>
                </div>
                <div class="form-group row mt-2">
                    <div class="col-md" id='messagecol'>
                        <label for="message">Description:</label>
                        <textarea type="text" class="form-control" rows="8" id="message" name="message" placeholder="" required></textarea>                        
                    </div>
                </div>
                <div class="form-group row text-right">                    
                    <div class="col-md">
                        <button type='submit' class="btn btn-primary form_submit_button" id="saveTicketButton"><i class="fa fa-share-square"></i> Submit Request</button>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
@endsection