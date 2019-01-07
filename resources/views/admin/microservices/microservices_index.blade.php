@extends('layouts.userBased')

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
                                <h3 class="col-md-9">Microservices</h3>
                                <a class ="btn btn-success"href="{{route('microservice.create')}}">Microservice   <i class="fas fa-plus"></i></a>
                            </div>
                        
                        <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Base_url</th>
                            <th>Route</th>
                            <th>Is active</th>
                        </tr>
                        @forelse($microservices as $microservice)
                        <tr>
                            <td>{{$microservice->name}}</td>
                            <td>{{$microservice->description}}</td>
                            <td>{{$microservice->base_url}}</td>
                            <td>{{$microservice->route}}</td>
                            @if($microservice->is_active == true)
                            <td>Yes</td>
                            @else
                            <td>No</td>
                            @endif
                            <td><div class="actions">
                                    <a class="btn btn-primary"  href={{route('microservice.edit',$microservice->id)}}><i class="fas fa-pen"></i></a>
                            {!!Form::open(['action'=>['MicroservicesController@destroy',$microservice->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                        
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                            {!!Form::close()!!}
                            </div>
                            </td>
                        </tr>
                        @empty
                            <tr><td>No Microservices</td></tr>
                        @endforelse
                        </table>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection