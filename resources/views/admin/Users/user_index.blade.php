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
                            <h3 class="col-md-9">Users</h3>
                            <a class ="btn btn-success"href="{{route('users.create')}}">User   <i class="fas fa-plus"></i></a>
                    </div>
                       
                     
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{$user->id}}</td>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>
                                        <div class="actions">
                                        <a class="btn btn-primary" href={{route('users.edit',$user->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['UserController@destroy',$user->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                         {!!Form::close()!!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no users</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
        
    </div>
</div>
@endsection