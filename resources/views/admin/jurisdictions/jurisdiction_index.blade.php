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
                                    <form action="{{ url('jurisdictions', $j->id) }}" method="POST" id="delete-jusrisdiction-form">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger btn-delete" id="delete-jusrisdiction" name="delJusrisButton" value="{{$j->id}}"><i class="fas fa-trash-alt"></i></button>
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
<!-- modal pop up code begins -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <p>The Jurisdiction can not be deleted for this has been associated with the Jurisdiction Type !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal pop up code ends -->
@endsection

