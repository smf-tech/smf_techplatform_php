@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Roles</h3>
                        <a class ="btn btn-success"href="{{route('role.create')}}">Create role BJS tenant</a>
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
                                    <td><a class="btn btn-default" href={{route('role.edit',$role->id)}}>edit</a>
                                        {!!Form::open(['action'=>['RoleController@destroy',$role->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                            {{Form::submit('Delete',['class'=>'btn btn-danger'])}}
                                         {!!Form::close()!!}
                                        </form>    
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Roles</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection