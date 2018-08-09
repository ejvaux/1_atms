@extends('layouts.app2')

@section('pageTitle','Admin | ATMS - Primatech')

@section('content')
<div class='container'>
    <input type='hidden' value='{{Auth::user()->id}}' id='logged_userid'>
    <div class='row'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Roles</li>
                </ol>
            </nav>
        </div>        
    </div>
    <div class='row mb-2'>
        {{-- <div class='col-md-3'>
            <button type='button' class='btn btn-secondary'>Add Tech</button>
        </div> --}}
        <div class="col-md-4">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="adminsearch" placeholder="Search user . . .">
                    <button type="button" id="refresh"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
    </div>
    <div class='row mb-2'>
        <div class='col-md'>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>NAME</th>
                        <th>EMAIL</th>
                        <th>ADMIN</th>
                        <th>TECH</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($users)>0)
                        @foreach($users as $user)
                            <tr>
                                <th>
                                    {{$user->id}}
                                </th>
                                <th>
                                    {{$user->name}}
                                </th>
                                <th>
                                    {{$user->email}}
                                </th>
                                <th>
                                    @if ($user->admin == true)
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox' checked>
                                    @else
                                        <input id='admin_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th>
                                <th>
                                    @if ($user->tech == true)
                                        <input id='tech_checkbox' value='{{$user->id}}' type='checkbox' checked>
                                    @else
                                        <input id='tech_checkbox' value='{{$user->id}}' type='checkbox'>
                                    @endif
                                </th>
                            </tr>
                        @endforeach                
                    @else
                        <p>No Users Found.</p>
                    @endif 
                </tbody>
            </table>
        </div>
    </div>
    <div class='row'>
        <div class='col-md'>
            {{$users->links()}}
        </div>
    </div>
</div>
@endsection