@extends('layouts.userBased')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Entities</h1>
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
        <a href="/{{$orgId}}/entity/create" class="btn btn-primary btn-icon-split">
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
        <span class="text">Entity</span>
        </a>
    </h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
        <thead>
            <tr>
               <th>Entity Name</th>
               <th>Display Name</th>
               <th>Is Active</th>
               <th></th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <th>Entity Name</th>
               <th>Display Name</th>
               <th>Is Active</th>
               <th></th>
            </tr>
            </tfoot>
            <tbody>
                @forelse($entities as $entity)
                    <tr>
                       <td>{{$entity->Name}}</td>
                       <td>{{$entity->display_name}}</td>
                        @if($entity->is_active == true)
                            <td>Yes</td>
                        @else
                            <td>No</td>
                        @endif
                       <td> 
                            <div class="actions">
                                <div style="float:left !important;">
                                    <a class="btn btn-primary" href={{route('entity.edit',$entity->id)}}><i class="fas fa-pen"></i></a>
                                </div>
                                <div style="float:left !important;padding-left:5px;"> 
                                    {!!Form::open(['action'=>['EntityController@destroy',$entity->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                    <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    {!!Form::close()!!}
                                </div>
                                <div style="clear:both;"></div>    
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td>no Entities</td></tr>
                @endforelse
            </tbody>
      </table>
    </div>
    
  </div>
</div>

</div>
<!-- /.container-fluid -->
@endsection