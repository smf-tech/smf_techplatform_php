@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))

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
                            <h3 class="col-md-9">Locations</h3>
                            <a class ="btn btn-success"href="/{{$orgId}}/locations/create">Location  <i class="fas fa-plus"></i></a>
                    </div>
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Levels</th>
                                <th>Action</th>
                            </tr>
                            @forelse($locations as $location)
                                <tr>
                                    <td>{{$location->name}}</td>
                                    {{-- <td>                                
                                    </td> --}}
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-primary"  href={{route('locations.edit',['orgId' => $orgId,'location' => $location->id])}}><i class="fas fa-pen"></i></a>
                                            {{-- <a class="btn btn-primary"  href={{route('location.edit',$location->id)}}><i class="fas fa-pen"></i></a> --}}
                                        {!!Form::open(['action'=>['LocationController@destroy', $orgId, $location->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                        {{-- {!!Form::open(['action'=>['LocationController@destroy',$location->id],'method'=>'DELETE','class'=>'pull-right' ])!!} --}}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        {!!Form::close()!!}
                                        </form> 
                                     </div>   
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Jurisdictions</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection