@extends('layouts.app')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Roles</h1>
    <p class="mb-4">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">
            <a href="{{route('role.create')}}" class="btn btn-primary btn-icon-split">
            <span class="icon text-white-50">
                <i class="fas fa-plus"></i>
            </span>
            <span class="text">Role</span>
            </a>
        </h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>
                @forelse($roles as $role)
                    @if ($role->display_name !== 'RootOrgAdmin')
                    <tr>
                        <td>{{$role->display_name}}</td>
                        <td>{{$role->description}}</td>
                        <td>
                            <div class="actions">
                            <div style="float:left !important;padding-left:5px;">
                                <a class="btn btn-primary btn-circle btn-sm" href={{route('role.edit',$role->id)}}><i class="fas fa-pen"></i></a>
                            </div>
                            <div style="float:left !important;padding-left:5px;"> 
                                <form action="{{ url('role',$role->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-circle btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                            </div>
                            <div style="clear:both !important;"></div>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr><td>no users</td></tr>                        
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    </div>

</div>
@endsection