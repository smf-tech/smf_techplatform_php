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
                            <h3 class="col-md-9">Villages</h3>
                    <a class ="btn btn-success" href="{{route('village.create')}}">Village <i class="fas fa-plus"></i></a>
                    </div>
                       
                       
                        
                        <table class="table">
                            <tr>
                                <th>Village ID</th>
                                <th>Village Name</th>
                                <th>State Name</th>
                                <th>District Name</th>
                                <th>Taluka Name</th>
                                <th>Cluster Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($vil as $v)
                                <tr>
                                    <td>{{$v->id}}</td>
                                    <td>{{$v->Name}}</td>
                                    <td>{{$v->state->Name}}</td>
                                    <td>{{$v->district->Name}}</td>
                                    <td>{{$v->taluka->Name}}</td>
                                    @if($v->cluster_id != null)
                                        <td>{{$v->cluster->Name}}</td>
                                    @else
                                        <td>{{null}}</td>
                                    @endif
                                    <td><div class="actions">
                                        <a class="btn btn-default" href={{route('village.edit',$v->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['VillageController@destroy',$v->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                          
                                        <button type="submit" class="btn btn-default"><i class="fas fa-trash-alt"></i></button>

                                            {{-- {{Form::submit('Delete',['class'=>'btn btn-danger'])}} --}}
                                         {!!Form::close()!!}
                                        {{-- </form>     --}}
                                    </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Villages</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $vil->links() }}
            </div>
        </div>
    </div>
</div>
@endsection