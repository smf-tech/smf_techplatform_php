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
                    <h3>Edit <h3 id="levelPage">Cluster</h3></h3></br>
                    {!! Form::model($clu, ['route' => [ 'cluster.update', $clu->id ], 'method'=>'PUT', 'id' => 'cluster-edit-form']) !!}
                    
                    {{csrf_field()}} 
                    <legend></legend>
                         <div class="form-group">
                                <label for="clusterName"><h4>Cluster Name</h4></label>
                         <input type="text" name="clusterName" placeholder="Name of the cluster" value="{{$clu->Name}}" class="form-control"/>
                        </div>
                        <div>
                                <h4>State</h4>
                                <select id="state_id" name="state_id" class="form-control">
                                        <option value="0"></option>
                                        @foreach($states as $s)
                                            @if($s->Name !='Goa')
                                                <option value={{$s->id}} {{ ($clu->state_id == $s->id) ? "selected":""}} >{{$s->Name}}</option>
                                            @endif
                                        @endforeach 
                                </select>
                        </div>
                    </br>
                        <div id="levelContainer"  class="form-group">
                            
                            <h4>Districts</h4>
                            <select id="District" name="District" class="form-control">
                                    @foreach($districts as $d)
                                        <option value={{$d->id}} {{ ($clu->district_id == $d->id) ? "selected":""}}>{{$d->Name}}</option>
                                    @endforeach 
                            </select>
                        </br>
                            <h4>Talukas</h4>
                            <select id="Taluka" name="Taluka" class="form-control">
                                    @foreach($talukas as $t)
                                        <option value={{$t->id}} {{ ($clu->taluka_id == $t->id) ? "selected":""}}>{{$t->Name}}</option>
                                    @endforeach 
                            </select>
                        </div>
                        
                        <br/>

                        <input type="submit" class="btn btn-success"/>
                
                    {!! Form::close() !!} 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection