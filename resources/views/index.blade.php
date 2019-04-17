@extends('layouts.userBased')

@section('content')
<div class="container">
	<div class="card o-hidden border-0 shadow-lg my-5">
		<div class="card-body p-0">
		<div class="row">
		<div class="panel panel-default" style="padding-top:20px;padding-right:15px;padding-left:20px;">
		<div class="panel-heading"></div>
		<div class="panel-body">


		<div class="form-group row">
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Category:</b></label>
				</div>
			</div>
			<div class="col-sm-2">
				<select id='cat_id' style="max-width:100%;">
					<option value='' selected disabled hidden>--Please Select--</option>
					@foreach($categories as $category)
					<option value={{$category['_id']}}>{{ $category['name']['default'] }}</option>
					@endforeach
				</select>
			</div>
			<a href="/{{$orgId}}/category/create" class="btn btn-primary btn-icon-split">
				<span class="icon text-white-50">
					<i class="fas fa-plus"></i>
				</span>
				{{-- <span class="text">Create Entity</span> --}}
				</a>
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Project: </b></label>
				</div>
			</div>
			<div class="col-sm-2">
				<select id='pid' style="max-width:100%;">
					<option value='' selected disabled hidden>--Please Select--</option>
					@foreach($projects as $project)
					<option value={{$project['_id']}}>{{ $project['name'] }}</option>
					@endforeach
				</select>
			</div>
			<a href="/{{$orgId}}/project/create" class="btn btn-primary btn-icon-split">
				<span class="icon text-white-50">
					<i class="fas fa-plus"></i>
				</span>
				{{-- <span class="text">Create Entity</span> --}}
				</a>
		</div>
        <div class="form-group row">
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Microservices:</b></label>
				</div>
			</div>
			<div class="col-sm-2">
				<select id='service_id' style="max-width:100%;">
					<option value='' selected disabled hidden>--Please Select--</option>
					@foreach($microservices as $microservice)
					<option value={{$microservice['_id']}}>{{ $microservice['name'] }}</option>
					@endforeach
				</select>
			</div>
			<a href="/microservice/create" class="btn btn-primary btn-icon-split">
				<span class="icon text-white-50">
					<i class="fas fa-plus"></i>
				</span>
				{{-- <span class="text">Create Entity</span> --}}
				</a>
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Entities: </b></label>
				</div>
			</div>
			<div class="col-sm-2">
				<select id='entity_id' style="max-width:100%;">
					<option value='' selected disabled hidden>--Please Select--</option>
					@foreach($entities as $entity)
					<option value={{$entity['_id']}}>{{ $entity['display_name'] }}</option>
					@endforeach
				</select>
			</div>
			<a href="/{{$orgId}}/entity/create" class="btn btn-primary btn-icon-split">
				<span class="icon text-white-50">
					<i class="fas fa-plus"></i>
				</span>
				{{-- <span class="text">Create Entity</span> --}}
				</a>
		</div>
		<div class="form-group row">
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Allowed Roles:</b></label>
				</div>
			</div>
			<div class="col-sm-2">
				<select multiple="multiple" name="assigned_roles[]" id="assigned_roles" style="max-width:100%;">
					@foreach($org_roles as $org_role)
					<option value="{{$org_role->id}}" >{{$org_role->display_name}}</option>
					@endforeach
				</select>
			</div>
		</div>
	    <div class="form-group row">
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Is Active:</b>
					<?php
						echo Form::checkbox('active', '',true,['id'=>'active']);   
					?>
					</label>
				</div>
			</div>
			<div class="col-sm-2">
				<label><b> Is Editable:</b></label>
				<?php
					echo Form::checkbox('editable','',false,['id'=>'editable']);   
				?>
			</div>
			<div class="col-sm-2">
				<label><b> Is Deletable:</b></label>
				
				{{-- <input type="checkbox" name="deletable"/> --}}
				<?php
					 echo Form::checkbox('deletable','',false,['id'=>'deletable']);   
				?>
			</div>
			<div class="col-sm-3 mb-3 mb-sm-0" style="text-align:center;border:0px solid red;">
				<div style="text-align:left;border:0px solid blue;padding-left:5px;margin-left:50px;">
					<label><b> Is Multiple Entry Allowed:</b>
					<?php
						echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']);    
					?>
					</label>
				</div>
			</div>
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


