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
                        <h3>Edit Cluster</h3>
                        {!! Form::model($clu, ['route' => [ 'cluster.update', $clu->id ], 'method'=>'PUT', 'id' => 'cluster-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                            <div class="form-group">
                                <label for="id">Cluster ID</label>
                                <input type="integer" name="id" placeholder="Cluster" class="form-control" value="{{$clu->id}}"/>
                            </div>
                             <div class="form-group">
                                    <label for="clusterName">Cluster Name</label>
                             <input type="text" name="clusterName" placeholder="Name of the cluster" value="{{$clu->clusterName}}" class="form-control"/>
                            </div>
                            <div>
                                    <h4>State</h4>
                                    <select name="state_id" class="form-control">
                                            @foreach($states as $s)
                                                <option value={{$s->id}} {{ ($tal->state_id == $s->id) ? "selected":""}}>{{$s->stateName}}</option>
                                            @endforeach 
                                    </select>
                            </div>
                            <div>
                                <h4>Districts</h4>
                                <select name="district_id" class="form-control">
                                        @foreach($districts as $d)
                                            <option value={{$d->id}} {{ ($tal->district_id == $d->id) ? "selected":""}}>{{$d->districtName}}</option>
                                        @endforeach 
                                </select>
                            </div>
                            <div>
                                <h4>Talukas</h4>
                                <select name="taluka_id" class="form-control">
                                        @foreach($talukas as $t)
                                            <option value={{$t->id}} {{ ($clu->taluka_id == $t->id) ? "selected":""}}>{{$t->talukaName}}</option>
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