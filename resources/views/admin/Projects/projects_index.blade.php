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
                                <h3 class="col-md-9">Projects</h3>
                                <a class ="btn btn-success col"href="{{route('cluster.create')}}">Project   <i class="fas fa-plus"></i></a>
                        </div>
                     
                        <table class="table">
                            <tr>
                                <th>Project ID</th>
                                <th>Project Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($projects as $project)            
                            
                                <tr>
                                    <td>{{$project['_id']}}</td>
                                    <td>{{$project['name']}}</td>
                                    <td>
                                            {{-- <div class="actions">
                                                    <a class="btn btn-primary"  href={{route('cluster.edit',$c->id)}}><i class="fas fa-pen"></i></a>
                                            {!!Form::open(['action'=>['ClusterController@destroy',$c->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            {!!Form::close()!!}
                                         
                                        </div>   --}}
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Projects</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection