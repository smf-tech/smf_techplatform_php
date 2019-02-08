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
                        <h3>Edit Associate</h3></br>
                        {!! Form::open(['route' => [ 'associates.update', $orgId, $associate->id ], 'method'=>'PUT', 'id' => 'associate-edit-form']) !!}
                        {{csrf_field()}} 
                        <legend></legend>       
                                        
                             <div class="form-group">
                                    <h4>Name</h4>
                                        <input type="text" name="name" value="{{$associate->name}}" class="form-control"/>
                                        {{-- @if($errors->has('name'))
                                            <b style="color:red">{{$errors->first('name')}}</b>
                                        @endif --}}
                                        </br>

                                    <h4>Type</h4>
                                    <select name="type" class="form-control">
                                        <option value="0"></option>
                                        <option value="donor" @if($associate->type == 'donor') selected="selected" @endif > Donor </option>                                                                                               
                                        <option value="vendor" @if($associate->type == 'vendor') selected="selected" @endif> Vendor </option>                                                                                               
                                        <option value="partner" @if($associate->type == 'partner') selected="selected" @endif> Partner </option>
                                    </select>                                  
                                    </br>

                                    <h4>Contact Person : </h4>
                                        <input type ="text" name="contact_person" value="{{$associate->contact_person}}" class="form-control"></input>
                                    </br>

                                <h4>Contact Number : </h4>
                                    <input type ="text" name="contact_number" value="{{$associate->contact_number}}" class="form-control"></input>
                                </br>
                               
                            </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!}
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection