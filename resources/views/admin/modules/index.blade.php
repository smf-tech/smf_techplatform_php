@extends('layouts.userBased')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <h3 class="col-md-9">Modules</h3>
                        <a class ="btn btn-success" href="/{{$orgId}}/modules/create">Create<i class="fas fa-plus"></i></a>
                    </div>
                    
                    <table class="table">
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                        </tr>
                        @forelse ($modules as $module)
                        <tr>
                            <td>{{ $module->id }}</td>
                            <td>{{ $module->name }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-primary" href="{{ route('modules.edit', ['orgId' => $orgId, 'module' => $module->id]) }}"><i class="fas fa-pen"></i></a>
                                    {!!Form::open(['route' => ['modules.destroy', $orgId, $module->id],'method' => 'DELETE', 'class' => 'pull-right'])!!}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    {!!Form::close()!!}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No Modules created yet.</td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
