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
                        <h3>Edit District</h3>
                        {!! Form::model($dis, ['route' => [ 'district.update', $dis->id ], 'method'=>'PUT', 'id' => 'district-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                            <div class="form-group">
                                <label for="id">District ID</label>
                                <input type="integer" name="id" placeholder="District" class="form-control" value="{{$dis->id}}"/>
                            </div>
                             <div class="form-group">
                                    <label for="districtName">District Name</label>
                             <input type="text" name="districtName" placeholder="District name" value="{{$dis->districtName}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select name="state_id" class="form-control">
                                            @foreach($states as $s)
                                                <option value={{$s->id}} {{ ($dis->state_id == $s->id) ? "selected":""}}>{{$s->stateName}}</option>
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