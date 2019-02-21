@extends('layouts.userBased')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Microservices</h1>
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
                <a href="{{route('microservice.create')}}" class="btn btn-primary btn-icon-split">
                <span class="icon text-white-50">
                    <i class="fas fa-plus"></i>
                </span>
                <span class="text">Microservice</span>
                </a>
            </h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Base_url</th>
                            <th>Route</th>
                            <th>Is active</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tfoot>
                    <tr>
                    <th>Name</th>
                            <th>Description</th>
                            <th>Base_url</th>
                            <th>Route</th>
                            <th>Is active</th>
                            <th></th>
                    </tr>
                    </tfoot>
                    <tbody>
                    @forelse($microservices as $microservice)
                        <tr>
                            <td>{{$microservice->name}}</td>
                            <td>{{$microservice->description}}</td>
                            <td>{{$microservice->base_url}}</td>
                            <td>{{$microservice->route}}</td>
                            @if($microservice->is_active == true)
                            <td>Yes</td>
                            @else
                            <td>No</td>
                            @endif
                            <td>
                                <div class="actions">
                                    <div style="float:left !important;">
                                        <a class="btn btn-primary"  href={{route('microservice.edit',$microservice->id)}}><i class="fas fa-pen"></i></a>
                                    </div>
                                    <div style="float:left !important;padding-left:5px;">    
                                        {!!Form::open(['action'=>['MicroservicesController@destroy',$microservice->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                        {!!Form::close()!!}
                                    </div>
                                    <div style="clear:both;"></div>    
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td>No Microservices</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->
@endsection