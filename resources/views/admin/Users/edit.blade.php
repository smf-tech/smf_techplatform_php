@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Edit User</h3>
                        
                        {!! Form::model($user, ['route' => [ 'users.update', $user->id ], 'method'=>'PUT', 'id' => 'user-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Name</label>
                                 <input type="text" name="name" placeholder="name"class="form-control"value="{{$user->name}}"/>
                             </div>
                             <div class="form-group">
                                    <label for="email">email</label>
                                    <input type="email" name="email" placeholder="email"class="form-control" value="{{$user->email}}"/>
                            </div>
                            
                            <div class="form-group{{ $errors->has('org_id') ? ' has-error' : '' }} ">
                                <label for="org_id" class="col-md-4 col-form-label ">Organisation</label>
    
                                <div >
                                    <select id="org_id"  class="form-control" name="org_id" required>
                                        <option value=0></option>
                                        @foreach($orgs as $org)
                                        <option value={{$org->id}} @if ($org->id == $orgId) selected @endif> {{$org->name}}</option>
                                        @endforeach 
                                    </select>
    
                                    @if ($errors->has('org_id'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('org_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                                    <label for="role_id" class="col-md-4 col-form-label ">Role</label>
                                   
                                  
                                    <div >
                                        <select id="role_id"  class="form-control" name="role_id" required>
                                            <option value="0"></option>
                                            <option value={{$role->id}} selected>{{$role->name}}</option>
                                        </select>
        
                                        @if ($errors->has('role_id'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('role_id') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                <br/>
                                    <div class=" form-group row">
                                        <div  id="levelContainer"   class="col-md-8">
   
                                        </div>
                                       </div>
                            <input type="submit" class="btn btn-success"/>
                        
                        {!! Form::close() !!} 
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection