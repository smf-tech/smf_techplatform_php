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
                            <h3 class="col-md-9">Organisations</h3>
                            <a class ="btn btn-success"href="{{route('organisation.create')}}">Organisation <i class="fas fa-plus"></i></a>  
                  </div>
                        
                    
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Service</th>
                                <th>Action</th>
                            </tr>
                           @forelse($orgs as $item)
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->service}}</td>
                                    <td> 
                                        <div class="actions">
                                             <a class="btn btn-primary"  href={{route('organisation.edit',$item->id)}}><i class="fas fa-pen"></i></a>
                                            {!!Form::open(['action'=>['OrganisationController@destroy',$item->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            {!!Form::close()!!}
                                            <a class="btn btn-info"  href={{route('orgManager.show',$item->id)}}>Manage</a>

                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no organisations</td></tr>
                            @endforelse  
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection