@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
          

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                            <h3 class="col-md-9">Roles</h3>
                                    <a class ="btn btn-success"href="{{route('role.create')}}">role   <i class="fas fa-plus"></i></a>
                    </div>
                       
                      
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Display Name</th>
                                <th>Description</th>
                                <th>Action</th>
                            </tr>
                            @forelse($roles as $role)
                                <tr>
                                    <td>{{$role->name}}</td>
                                    <td>{{$role->display_name}}</td>
                                    <td>{{$role->description}}</td>
                                    <td>
                                            <div class="actions">
                                                    <a class="btn btn-primary" href={{route('role.edit',$role->id)}}><i class="fas fa-pen"></i></a>
                                                {!!Form::open(['action'=>['RoleController@destroy',$role->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                {!!Form::close()!!}
                                            </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Roles</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>
@endsection