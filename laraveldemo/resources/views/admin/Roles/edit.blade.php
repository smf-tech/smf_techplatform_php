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
                        <h3>Edit Role</h3>
                 
                      
                        

                        {!! Form::model($role, ['route' => [ 'role.update', $role->id ], 'method'=>'PUT', 'id' => 'role-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Role Name</label>
                                 <input type="text" name="name" placeholder="name of the role"class="form-control" value="{{$role->name}}"/>
                             </div>
                             <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" name="display_name" placeholder="Display Name"class="form-control" value="{{$role->display_name}}"/>
                            </div>
                             <div class="form-group">
                                <label for="description">Description</label>
                                 <input type="text" name="description" placeholder="description"class="form-control"value="{{$role->description}}"/>
                            </div>
                            <div class="form-group sub-con">
                            <div class="form-group">
                                <h4>Permissions</h4>
                                @foreach($permissions as $permission)
                                {{$permission->name}}<input type="checkbox"{{in_array($permission->id,$role_permissions)?"checked":""}} name="permission[]" value="{{$permission->id}}"  class="form-control"/><br/>
                                @endforeach 
                            </div>
                            <div  class="form-group" >
                                    <h4>Organisation</h4>
                                    <select name="org_id" class="form-control">
                                            @foreach($orgs as $org)
                                               
                                                <option value={{$org->id}}  {{ ($org->id===$role->org_id) ?"selected":""}}>{{$org->name}}</option>
                                            @endforeach 
                                    </select></br></br>
                                    <h4>State</h4>
                                    <select id="state" name="state_id" class="form-control">
                                            <option value="0"></option>
                                            @foreach($states as $state)
                                                <option value={{$state->id}} {{ ($state->id===$role_jurisdictions[0]->state_id) ?"selected":""}}>{{$state->Name}}</option>
                                            @endforeach 
                                    </select>                   
                                      
                                    </br>
                                            <div  id="levelContainer" class="form-group col-md-6 row">
                                               <h4>Jurisdiction</h4>
                                                <select id="jurisdiction" name="jurisdiction" class="form-control">
                                                    <option value="0"></option>
                                                    <?php $c = 0; ?>                          
                                                    @foreach($levels as $l)                                       
                                                        <option class="form-control" value={{$l->jurisdiction_id}} {{ ($l->jurisdiction_id==$role_jurisdictions[0]->jurisdiction_id) ?"selected":""}}>{{$levelNames[$c]->levelName}}</option> 
                                                        <?php $c++; ?>                      
                                                    @endforeach
                                                </select>
                                            </div>
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