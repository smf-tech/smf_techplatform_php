@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))
@section('content')
<div>
<label> Is Active</label>
<?php
 echo Form::checkbox('active', '',true,['id'=>'active']);   
 ?>
 <br/>
 <label> Is Editable</label>
<?php
 echo Form::checkbox('editable', '',false,['id'=>'editable']);   
 ?>
 <br/>
 <label> Is Multiple Entry Allowed</label>
<?php
 echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']);   
 ?>
<br/>
 <label> Allowed Roles</label>
<select multiple="multiple" name="assigned_roles[]" id="assigned_roles">
@foreach($org_roles as $org_role)
        <option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
@endforeach
</select>
</div>


<div>
    <b> Category:</b>
    <select>
            <option value="0"></option>
        @foreach($categories as $category)
            <option id='cat_id' value={{$category['_id']}}><?php echo $category['name'] ?></option>
        @endforeach
    </select>
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
    <b> Project: </b>
    <select>
            <option value="0"></option>
            @foreach($projects as $project)
                <option id='pid' value={{$project['_id']}}><?php echo $project['name'] ?></option>
            @endforeach
    </select>

</div>


<div id="surveyContainer">
    <div id="editorElement"></div>
</div>
@endsection