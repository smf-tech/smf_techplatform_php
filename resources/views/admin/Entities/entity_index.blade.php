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
                        <h3 class="col-md-9">Entities</h3>
                        <div class="col">
                                <a class ="btn btn-success"href="/{{$orgId}}/entity/create">Entity   <i class="fas fa-plus"></i></a>
                        </div>
                        </div>
                        <table class="table">
                            <tr>
                                {{-- <th>District ID</th> --}}
                                <th>Entity Name</th>
                                <th>Display Name</th>
                            </tr>
                            @forelse($entities as $entity)
                                <tr>
                                    {{-- <td>{{$d->id}}</td> --}}
                                    <td>{{$entity->Name}}</td>
                                    <td>{{$entity->display_name}}</td>
                                    {{-- <td>{{App\District::find($d->id)->state['Name']}}</td> --}}
                                    <td> <div class="actions">
                                            <a class="btn btn-primary" href={{route('district.edit',$entity->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['EntityController@destroy',$entity->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                         {!!Form::close()!!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Entities</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection