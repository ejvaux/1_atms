@extends('layouts.app2')

@section('pageTitle','CCTV Review | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class="container-fluid">
    <div class='row mb-1'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">CCTV Review</li>
                </ol>
            </nav>
        </div>
    </div>
    <div class="row mb-3">
        <div class='col-md-3'>
            <a class='btn btn-secondary' href='{{ url('/cr/crc') }}'><i class="fa fa-plus-square"></i> Create Request</a>
        </div>
        <div class='col-md'></div>
        @if(Auth::user()->admin == true || Auth::user()->tech == true)
            <div class='col-md-3 ml-auto input-group'>
                <div class='input-group-prepend'>
                    <label class='input-group-text'>Sort by: </label>
                </div>           
                    <select id='sortrequestdd' class="form-control">
                        <option value='all'>All</option>
                        <option value='handled'>Handled</option>
                    </select>            
            </div>
        @endif      
        <div class="col-md-4">
            <form>
                <div class="input-group">                    
                    <input type="text" class="form-control" id="searchtextbox" placeholder="Search ticket . . .">
                    <button type="button" value="/1_atms/public/cr/crl/" id="search"><i class="fa fa-search"></i></button>
                </div>                
            </form>
        </div>
    </div>
    <div id='table_list'>@include('inc.requestlist')</div>
</div>
@endsection