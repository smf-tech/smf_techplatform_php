@extends('layouts.app')

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
                    <h3>Edit <h3 id="levelPage">Taluka</h3></h3></br>
                    {!! Form::model($tal, ['route' => [ 'taluka.update', $tal->id ], 'method'=>'PUT', 'id' => 'taluka-edit-form']) !!}
                    
                    {{csrf_field()}} 
                    <legend></legend>
                         <div class="form-group">
                                <label for="talukaName"><h4>Taluka Name</h4></label>
                         <input type="text" name="talukaName" placeholder="Name of the taluka" value="{{$tal->Name}}" class="form-control"/>
                        </div>
                        <div>
                                <h4>State</h4>
                                <select id="state_id" name="state_id" class="form-control">
                                        <option value="0"></option>
                                        @foreach($states as $s)
                                            <option value={{$s->id}} {{ ($tal->state_id == $s->id) ? "selected":""}} > {{$s->Name}} </option>
                                        @endforeach 
                                </select>
                        </div>
                        <br/>

                        <div id="levelContainer"  class="form-group">
                            <h4>District</h4>
                            <select name="District" class="form-control">
                                    <option value="0"></option>
                                    @foreach($districts as $d)
                                        <option value={{$d->id}} {{ ($tal->district_id == $d->id) ? "selected":""}} > {{$d->Name}} </option>
                                    @endforeach 
                            </select>
                        </div>
                        
                        <input type="submit" class="btn btn-success"/>
                
                    {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection