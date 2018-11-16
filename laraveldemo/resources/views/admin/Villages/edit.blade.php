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
                    <h3>Edit<h3 id="levelPage">Village</h3></h3></br>
                    {!! Form::model($vil, ['route' => [ 'village.update', $vil->id ], 'method'=>'PUT', 'id' => 'village-edit-form']) !!}
                    
                    {{csrf_field()}} 
                    <legend></legend>
                         <div class="form-group">
                                <label for="clusterName"><h4>Village Name</h4></label>
                         <input type="text" name="villageName" placeholder="Name of the Village" value="{{$vil->Name}}" class="form-control"/>
                        </div>
                        <div>
                                {{-- @if(isset($states)) --}}
                                <h4>State</h4>
                                <select id="state_id" name="state_id" class="form-control">
                                        <option value="0"></option>
                                        @foreach($states as $s)
                                            <option value={{$s->id}} {{ ($vil->state_id == $s->id) ? "selected":""}} >{{$s->Name}}</option>
                                        @endforeach
                                </select>
                                {{-- @endif --}}
                        </div>
                        <br/>
                        <div id="levelContainer"  class="form-group">
                            <h4>District</h4>
                            <select id="District" name="District" class="form-control">
                                    <option value="0"></option>
                                    @foreach($districts as $d)
                                        <option value={{$d->id}} {{ ($vil->district_id == $d->id) ? "selected":""}} >{{$d->Name}}</option>
                                    @endforeach
                            </select>
                            <h4>Taluka</h4>
                                <select id="Taluka" name="Taluka" class="form-control">
                                        <option value="0"></option>
                                        @foreach($talukas as $t)
                                            <option value={{$t->id}} {{ ($vil->taluka_id == $t->id) ? "selected":""}} >{{$t->Name}}</option>
                                        @endforeach
                                </select>
                            @if(isset($clusters))
                            <h4>Cluster</h4>
                                <select id="Cluster" name="Cluster" class="form-control">
                                        <option value="0"></option>
                                        @foreach($clusters as $c)
                                            <option value={{$c->id}} {{ ($vil->cluster_id == $c->id) ? "selected":""}} >{{$c->Name}}</option>
                                        @endforeach
                                </select>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-success"/>
                
                    {!! Form::close() !!} 
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection