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
                            <h3 class="col-md-9">Jurisdictions</h3>
                            <a class ="btn btn-success"href="/{{$orgId}}/jurisdiction/create">Jurisdiction  <i class="fas fa-plus"></i></a>
                    </div>
                        <table class="table">
                            <tr>
                                <th>Level Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($juris as $j)
                                <tr>
                                    <td>{{$j->levelName}}</td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-primary"  href={{route('jurisdictions.edit',$j->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['JurisdictionController@destroy',$j->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
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