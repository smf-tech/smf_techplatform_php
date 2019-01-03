@extends('layouts.editSurvey',compact(['orgId'=>$orgId,'modules'=>$modules,'surveyJson'=>$surveyJson,'surveyID'=>$surveyID]))
@section('content')

<div>
        <?php
        $survey_details = explode(" ",$surveys);
        ?>

        <label><b> Category:</b></label>
        <select id='cat_id' >
                <option value='' selected disabled hidden>--Please Select--</option>
            @foreach($categories as $category)
                    @if($survey_details[1] == $category['_id'])
                        <option value={{$category['_id']}} selected="selected">{{ $category['name'] }}</option>
                    @else
                        <option value={{$category['_id']}}>{{ $category['name'] }}</option>
                    @endif
            @endforeach
        </select>
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 

    <label><b> Project: </b></label>
        <select id='pid'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($projects as $project)
                    @if($survey_details[0] == $project['_id'])
                        <option value={{$project['_id']}} selected="selected">{{ $project['name'] }}</option>
                    @else
                        <option value={{$project['_id']}}>{{ $project['name'] }}</option>
                    @endif
                @endforeach
        </select>
        
        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    
    <label><b> Microservices: </b></label>
        <select id='service_id'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($microservices as $microservice)
                    @if($survey_details[2] == $microservice['_id'])
                        <option value={{$microservice['_id']}} selected="selected">{{ $microservice['name'] }}</option>
                    @else
                        <option value={{$microservice['_id']}}>{{ $microservice['name'] }}</option>
                    @endif
                @endforeach
        </select>

        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    
        <label><b> Entities: </b></label>
        <select id='entity_id'>
                <option value='' selected disabled hidden>--Please Select--</option>
                @foreach($entities as $entity)
                    @if($survey_details[7] == $microservice['_id'])
                        <option value={{$entity['_id']}} selected="selected">{{ $entity['display_name'] }}</option>
                    @else
                        <option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
                    @endif
                @endforeach
        </select>
    
    </div>
    
    <div>
        
<label><b> Is Active </b></label>
<?php
 echo Form::checkbox('active', '',$survey_details[4] === 'true'? true: false,['id'=>'active']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 {{-- <br/> --}}
 <label><b> Is Editable</b></label>
<?php
 echo Form::checkbox('editable', '',$survey_details[5] === 'true'? true: false,['id'=>'editable']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
 {{-- <br/> --}}
 <label><b> Is Multiple Entry Allowed</label>
<?php
 echo Form::checkbox('multiple_entry','',$survey_details[6] === 'true'? true: false, ['id'=>'multiple_entry']);   
 ?>
 &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
{{-- <br/> --}}
 <label><b> Allowed Roles</b></label>
<select multiple="multiple" name="assigned_roles[]" id="assigned_roles">
@foreach($org_roles as $org_role)
            @if(in_array($org_role->id, $roles))
                <option value={{$org_role->id}} selected="selected">{{$org_role->display_name}}</option>
            @else
                <option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
            @endif
@endforeach
</select>
</div>
</br>

<div id="surveyContainer">
    <div id="editorElement"></div>
</div>
@endsection