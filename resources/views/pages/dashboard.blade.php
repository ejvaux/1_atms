@extends('layouts.app')

@section('pageTitle','Dashboard | ATMS - Primatech')

@section('content')
<div class="container-fluid" style='height:100vh'>
    <div class="row">
        <div class="col-md-2 m-0 p-0" style='height:100vh;' id='sidebr'>
            @include('inc.sidebar')
        </div>  
        <div class='col-md m-0 ml-3 pt-3 border' id="main_panel" style="background:white" >            
            @include('tabs.home.dash') 
        </div> 
    </div>
</div>
@endsection
