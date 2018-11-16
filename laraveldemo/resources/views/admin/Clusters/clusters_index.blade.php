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
                                <h3 class="col-md-9">Clusters</h3>
                                <a class ="btn btn-success" href="{{route('cluster.create')}}">Cluster   <i class="fas fa-plus"></i></a>
                        </div>
                     
                        <table class="table">
                            <tr>
                                <th>Cluster ID</th>
                                <th>Cluster Name</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Taluka Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($clu as $c)
                                <tr>
                                    <td>{{$c->id}}</td>
                                    <td>{{$c->Name}}</td>
                                    <td>{{$c->state->Name}}</td>
                                    <td>{{$c->district->Name}}</td>
                                    <td>{{$c->taluka->Name}}</td>
                                    <td><div class="actions">
                                            <a class="btn btn-primary" href={{route('cluster.edit',$c->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['ClusterController@destroy',$c->id],'method'=>'DELETE','class'=>'pull-right' ])!!}

                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>

                                            {{-- {{Form::submit('Delete',['class'=>'btn btn-danger'])}} --}}
                                         {!!Form::close()!!}
                                        {{-- </form>     --}}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Clusters</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $clu->links() }}
            </div>
        </div>
       
    </div>
</div>
@endsection