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
                        <h3>Edit Village</h3>
                        {!! Form::model($vil, ['route' => [ 'village.update', $vil->id ], 'method'=>'PUT', 'id' => 'village-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                            <div class="form-group">
                                <label for="id">Village ID</label>
                                <input type="integer" name="id" placeholder="Village" class="form-control" value="{{$vil->id}}"/>
                            </div>
                             <div class="form-group">
                                    <label for="clusterName">Village Name</label>
                             <input type="text" name="villageName" placeholder="Name of the Village" value="{{$vil->Name}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select id="state_id" name="state_id" class="form-control">
                                            @foreach($states as $s)
                                                <option value={{$s->id}} {{ ($vil->state_id == $s->id) ? "selected":""}}>{{$s->Name}}</option>
                                            @endforeach
                                    </select>
                            </div>
                            <div>
                                <h4>Districts</h4>
                                <select name="district_id" class="form-control">
                                        @foreach($districts as $d)
                                            <option value={{$d->id}} {{ ($vil->district_id == $d->id) ? "selected":""}}>{{$d->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                <h4>Talukas</h4>
                                <select name="taluka_id" class="form-control">
                                        @foreach($talukas as $t)
                                            <option value={{$t->id}} {{ ($vil->taluka_id == $t->id) ? "selected":""}}>{{$t->Name}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                <h4>Clusters</h4>
                                <select name="cluster_id" class="form-control">
                                        @foreach($clusters as $c)
                                            <option value={{$c->id}} {{ ($vil->cluster_id == $c->id) ? "selected":""}}>{{$c->clusterName}}</option>
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