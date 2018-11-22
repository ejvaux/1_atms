@extends('layouts.app2')

@section('pageTitle','Admin | ATMS - Primatech')

@section('content')
@include('inc.messages')
<div class='container'>
    <div class='row'>
        <div class='col-md'>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item text-muted">Export Data</li>
                </ol>
            </nav>
        </div>        
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <span class='text-muted'>Tickets <span class="badge badge-info">NEW</span></span>
                </div>
                <div class="card-body container">
                <form action="{{ url('/admin/ticket/export') }}" method="POST">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">TICKET OWNER</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='user_id'>
                                <option value=''>ALL</option>
                                @foreach ($user_list as $user)
                                <option value='{{ $user->id }}'>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">DEPARTMENT</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='department_id'>
                                <option value=''>ALL</option>
                                @foreach ($departments as $department)
                                <option value='{{ $department->id }}'>{{ $department->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">CATEGORY</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='category_id'>
                                <option value=''>ALL</option>
                                @foreach ($categories as $category)
                                <option value='{{ $category->id }}'>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">PRIORITY</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='priority_id'>
                                <option value=''>ALL</option>
                                @foreach ($priorities as $priority)
                                <option value='{{ $priority->id }}'>{{ $priority->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">STATUS</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='status_id'>
                                <option value=''>ALL</option>
                                @foreach ($statuses as $status)
                                <option value='{{ $status->id }}'>{{ $status->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">TECH</label>
                        </div>
                        <div class="col-md-8">
                            <select class="custom-select sel2" id="" name='assigned_to'>
                                <option value=''>ALL</option>
                                @foreach ($user_tech as $tech)
                                <option value='{{ $tech->id }}'>{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">STARTED</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class='form-control form-control-sm'>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-4">
                            <label for="">FINISHED</label>
                        </div>
                        <div class="col-md-8">
                            <input type="text" class='form-control form-control-sm'>
                        </div>
                    </div> --}}
                    <div class="row mb-2">
                        <div class="col-md">
                            <div class="form-group">
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <span>CREATED FROM</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control form-control-sm" id="created_from" name='created_from'>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <span>TO</span>
                                    </div>
                                    <div class="col-md-8">
                                        <input type="date" class="form-control form-control-sm" id="" name='created_to'>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md text-right">
                            <button type='submit' class='btn btn-secondary'><i class="far fa-file-excel"></i> Export</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
        <div class="col-md">
            <div class="card">
                <div class="card-header">
                    <span class='text-muted'>CCTV Reviews</span>
                </div>
                <div class="card-body container">
                    <div class="row">
                        <div class="col-md">
                            Coming soon :)
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection