@extends('layouts.userBased')

@section('content')
<div class="container">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
		<div class="row">
		<div class="panel panel-default" style="padding-top:20px;padding-right:15px;padding-left:20px;">
		<div class="panel-heading"></div>
		<div class="panel-body">

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
		</div>
		<div>&nbsp; &nbsp;</div>
		<div>
			<label><b> Entities: </b></label>
			<select id='entity_id'>
				<option value='' selected disabled hidden>--Please Select--</option>
				@foreach($entities as $entity)
				<option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
				@endforeach
			</select>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			<label><b> Allowed Roles:</b></label>
			<select multiple="multiple" name="assigned_roles[]" id="assigned_roles">
				@foreach($org_roles as $org_role)
				<option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
				@endforeach
			</select>
		</div>
		<div>&nbsp; &nbsp;</div>
		<div>
			<label><b> Is Active:</b></label>
			<?php
			echo Form::checkbox('active', '',true,['id'=>'active']);   
			?>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			
			<label><b> Is Editable:</b></label>
			<?php
			echo Form::checkbox('editable', '',false,['id'=>'editable']);   
			?>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
			
			<label><b> Is Multiple Entry Allowed:</b></label>
			<?php
			echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']);   
			?>
			&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
		</div>

        <div id="surveyContainer">
			<div id="editorElement">
		</div>
		
		</div>
		</div>
		</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/create_survey.js') }}" id="id" class="{{ Auth::user()->id }}"></script>
@endpush


