@extends('layouts.userBased')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Jurisdictions</h1>
<p class="mb-4">
@if (session('status'))
  <div class="alert alert-success">
      {{ session('status') }}
  </div>
@endif
</p>

<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">
        <a href="/{{$orgId}}/jurisdiction/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Jurisdiction</span>
        </a>
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
                <th>Level Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
        <tr>
            <th>Level Name</th>
            <th>Action</th>
        </tr>
        </tfoot>
        <tbody>
            @forelse($juris as $j)
            <tr>
                <td>{{$j->levelName}}</td>
                <td>
                    <div class="actions">
                    <div style="float:left !important;">
                        <a class="btn btn-primary btn-circle btn-sm"  id="edit-jusrisdiction" value="{{$j->id}}" href={{route('jurisdictions.edit',$j->id)}}><i class="fas fa-pen"></i></a>
                        </div>
                        <div style="float:left !important;padding-left:5px;">
                        <form action="{{ url('jurisdictions', $j->id) }}" method="POST" id="delete-jusrisdiction-form">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-circle btn-sm" id="delete-jusrisdiction" name="delJusrisButton" value="{{$j->id}}"><i class="fas fa-trash"></i></button>
                        </form>
                        </div>
                        <div style="clear:both;"></div>    
                    </div>   
                </td>
            </tr>
            @empty
            <tr><td>no Jurisdictions</td></tr>
            @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>

</div>
<!-- /.container-fluid -->
<!-- modal pop up code begins -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirmation</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <p>The Jurisdiction can not be edited/deleted for it has been associated with the Jurisdiction Type !</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- modal pop up code ends -->
@endsection

