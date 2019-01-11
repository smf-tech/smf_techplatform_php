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
                        <h3>Create Microservice</h3>
                    <form action="{{route('microservice.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                    <label for="microserviceName">Name</label>
                                    <input type="text" name="name" placeholder="Name of the Microservice"class="form-control"/>
                                    @if($errors->any())
                                        <b style="color:red">{{$errors->first()}}</b>
                                    @endif
                            </div>         
                            <div class="form-group">
                                <label for="microserviceDescription">Description</label>
                                <input type="text" name="description" placeholder="Description of the Microservice"class="form-control"/>                                
                        </div>   
                        <div class="form-group">
                            <label for="microserviceUrl">Base url</label>
                            <input type="text" name="url" placeholder="Base url of the Microservice"class="form-control"/>
                    </div>  
                    <div class="form-group">
                        <label for="microserviceRoute">Route</label>
                        <input type="text" name="route" placeholder="Route of the Microservice"class="form-control"/>
                </div>        
                <div class="form-group">
                    <label for="microserviceActive">Is active</label>
                    <input type="checkbox" name="active" class="form-control" checked/>
            </div>                 
                            <input type="submit" class="btn btn-success"/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection