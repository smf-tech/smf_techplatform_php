@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Create Organisation</h3>
                    <form action="{{route('organisation.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" placeholder="name"class="form-control"/>
                             </div>
                            
                             <div class="form-group">
                                <label for="service">Service</label>
                                 <input type="text" name="service" placeholder="service"class="form-control"/>
                            </div>
                           
                            
                            <input type="submit" class="btn btn-success"/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection