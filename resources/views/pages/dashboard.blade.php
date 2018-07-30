@extends('layouts.app')

@section('pageTitle','Dashboard | TMS - Primatech')

@section('content')
<div class="container-fluid" style='height:100vh'>
    <div class="row">
        <div class="col-md-3 m-0 p-0 pr-3" style='height:100vh;' id='sidebr'>
            @include('inc.sidebar')
        </div>  
        <div class='col-md-9 m-0 pt-3 border' id="main_panel" style="background:white" >            
            @include('tabs.home.dash') 
        </div> 
    </div>
</div>
@endsection
