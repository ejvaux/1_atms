@extends('layouts.app')

@section('pageTitle','Dashboard | TMS - Primatech')

@section('content')
<div class="container-fluid" style='height:100vh'>
    <div class="row">
        @include('inc.sidebar')  
        <div class='col-md-9 m-0 pt-3 border' id="main_panel" style="background:white" >
            @include('tabs.h_dash')     
        </div> 
    </div>
</div>
@endsection
