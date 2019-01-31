@extends('layouts.userBased'))

@section('content')
<div>
        <label><b> Category:</b></label>
        <select id='cat_id'>
                <option value='' selected disabled hidden>--Please Select--</option>
            @foreach($categories as $category)
                <option value={{$category['_id']}}>{{ $category['name'] }}</option>
            @endforeach
        </select>
    
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    
        <label><b> Project: </b></label>
        <select id='pid'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($projects as $project)
                    <option value={{$project['_id']}}>{{ $project['name'] }}</option>
                @endforeach
        </select>
    
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    
        <label><b> Microservices: </b></label>
        <select id='service_id'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($microservices as $microservice)
                    <option value={{$microservice['_id']}}>{{ $microservice['name'] }}</option>
                @endforeach
        </select>

        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    
        <label><b> Entities: </b></label>
        <select id='entity_id'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($entities as $entity)
                    <option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
                @endforeach
        </select>
    
</div>
{{-- <br> --}}
<div>
        <label><b> Is Active:</b></label>
<?php
 echo Form::checkbox('active', '',true,['id'=>'active']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 {{-- <br/> --}}
 <label><b> Is Editable:</b></label>
<?php
 echo Form::checkbox('editable', '',false,['id'=>'editable']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 {{-- <br/> --}}
 <label><b> Is Multiple Entry Allowed:</b></label>
<?php
 echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
{{-- <br/></br> --}}
<label><b> Allowed Roles:</b></label>
<select multiple="multiple" name="assigned_roles[]" id="assigned_roles">
@foreach($org_roles as $org_role)
        <option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
@endforeach
</select>
</div>
{{-- </br> --}}

<div id="surveyContainer">
    <div id="editorElement"></div>
</div>

@endsection

@push('scripts')
     <script src="{{ asset('js/create_survey.js') }}" id="id" class="{{ Auth::user()->id }}"></script>
@endpush


