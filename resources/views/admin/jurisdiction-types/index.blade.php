@extends('layouts.userBased')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    <div class="row">
                        <h3 class="col-md-9">Jurisdiction Types</h3>
                        <a class ="btn btn-success" href="/{{$orgId}}/jurisdiction-types/create">Create<i class="fas fa-plus"></i></a>
                    </div>
                    
                    <table class="table">
                        <tr>
                            <th>Name</th>
                        </tr>
                        @forelse ($jurisdictionTypes as $jurisdictionType)
                        <?php $jurisdiction = "" ?>
                        <tr>
                                @foreach($jurisdictionType->jurisdictions as $type)
                                @if($jurisdiction != "")
                                    <?php $jurisdiction = $jurisdiction.", ".$type ?>
                                @else
                                    <?php $jurisdiction = $type ?>
                                @endif
                            @endforeach
                                <td>{{ $jurisdiction }}</td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-primary" href="/{{$orgId}}/jurisdiction-types/{{$jurisdictionType->id}}/edit"><i class="fas fa-pen"></i></a>
                                    {!!Form::open(['route' => ['jurisdiction-types.destroy', $orgId, $jurisdictionType->id],'method' => 'DELETE', 'class' => 'pull-right'])!!}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    {!!Form::close()!!}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No Jurisdiction Type created yet.</td></tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
