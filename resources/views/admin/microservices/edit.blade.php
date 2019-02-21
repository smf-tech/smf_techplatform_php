@extends('layouts.userBased')

@section('content')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                 <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Edit Microservice</h3>
                        {!! Form::model($microservice, ['route' => [ 'microservice.update', $microservice->id ], 'method'=>'PUT', 'id' => 'microservice-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                    <label for="microserviceName">Name</label>
                                    <input type="text" name="name" placeholder="Name of the microservice"class="form-control" value="{{$microservice->name}}"/>
                            </div>   
                            <div class="form-group">
                                <label for="microserviceDescription">Description</label>
                                <input type="text" name="description" placeholder="Description of the Microservice"class="form-control" value="{{$microservice->description}}"/>                                
                        </div>   
                        <div class="form-group">
                            <label for="microserviceUrl">Base url</label>
                            <input type="text" name="url" placeholder="Base url of the Microservice"class="form-control" value="{{$microservice->base_url}}"/>
                    </div>  
                    <div class="form-group">
                        <label for="microserviceRoute">Route</label>
                        <input type="text" name="route" placeholder="Route of the Microservice"class="form-control" value="{{$microservice->route}}"/>
                </div>        
                <div class="form-check">
                @if($microservice->is_active == true)
                    <input type="checkbox" name="active"  checked/>
                    @else
                    <input type="checkbox" name="active" />
                    @endif
                    <label for="microserviceActive">Active</label>
                </div>                 
                    <input type="submit" class="btn btn-primary btn-user btn-block"/>
                    {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection