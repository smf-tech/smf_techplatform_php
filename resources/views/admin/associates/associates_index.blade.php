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
                            <h3 class="col-md-9">Associates</h3>
                            <a class ="btn btn-success"href="/{{$orgId}}/associates/create">Associate <i class="fas fa-plus"></i></a>
                    </div>
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Contact Person</th>
                                <th>Contact Number</th>
                                <th>Action</th>
                            </tr>
                            @forelse($associates as $associate)
                                <tr>
                                    <td>{{$associate->name}}</td>
                                    <td>{{$associate->type}}</td>
                                    <td>{{$associate->contact_person}}</td>
                                    <td>{{$associate->contact_number}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-primary"  href={{route('associates.edit',['orgId' => $orgId,'location' => $associate->id])}}><i class="fas fa-pen"></i></a>   
                                        {!!Form::open(['action'=>['AssociateController@destroy', $orgId, $associate->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        {!!Form::close()!!}
                                        </form> 
                                     </div>   
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Associates</td></tr>
                            @endforelse
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection