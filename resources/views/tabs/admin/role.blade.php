@extends('layouts.app2')

@section('pageTitle','Admin | ATMS - Primatech')

@section('content')
@include('inc.messages')
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
        <div class="col-md-4">
            <form>
                <div class="input-group">
                    <input type="text" class="form-control" id="usersearch" placeholder="Search user . . .">
                    <button type="button" id="searchuser" value="/1_atms/public/admin/role/"><i class="fa fa-search"></i></button>
                </div>               
            </form>
        </div>
        {{-- <div class='col-md-3'>
            <button type='button' class='btn btn-secondary'>Add Tech</button>
        </div> --}}
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
                        <th>DEL</th>
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
                                <th>
                                    <form id='delete_user_form{{ $user->id }}' method='POST' action='/1_atms/public/users/{{ $user->id }}'>
                                        @method('DELETE')
                                        @csrf          
                                        <button type='button' id='delete_user' class='btn btn-danger p-0 px-2 m-0 delete_user' value="{{ $user->id }}">X</button>
                                    </form>
                                    {{-- <button type="button" class="btn btn-danger p-0 px-2 m-0" value="">
                                        <span style="font-size:.8rem">X</span>
                                    </button> --}}
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