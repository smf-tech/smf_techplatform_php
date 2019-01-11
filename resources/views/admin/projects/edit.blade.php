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
                        <h3>Edit Project</h3>
                        {!! Form::model($project, ['route' => [ 'project.update', $project->id ], 'method'=>'PUT', 'id' => 'entity-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>                            
                             <div class="form-group">
                                    <label for="Name">Project Name</label>
                             <input type="text" name="Name" placeholder="Project name" value="{{$project->name}}" class="form-control"/>
                            </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection