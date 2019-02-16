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
                        <h3>Create user</h3>
                    <form action="{{route('users.store')}}" method="post" class="form-horizontal">
                           {{csrf_field()}}     
                        <legend></legend>
                            <div class="row form-group">
                                    <div class="form-group col-md-6 row">
                                            <label  class="col-md-3" for="name"  >Name</label>
                                            <div class="col-md-9" >
                                                   <input type="text" name="name" placeholder="name" class="form-control"/>
                                            </div>
                                           
                                        </div>
                                        <div class="form-group col-md-6 row">
                                               <label for="email" class="col-md-3" >email</label>
                                               <div class="col-md-9">
                                               <input type="email" name="email" placeholder="email"class="form-control"/>
                                               </div>
                                       </div>
                                       </div>
                                        <div class="row">
                                                <div class="form-group  col-md-7 row">
                                                        <label for="password" class="col-md-3">Password</label>
                                                            <div class="col-md-9">
                                                            <input type="password" name="password" placeholder="password"class="form-control"/>
                                                            </div>
                                                </div>
                                        </div>
                                  
                                       
            
                           
                             <div class="row" >
                                    <div class="form-group row col-md-6">
                                            <label class="col-md-3"  for="phone">{{ __('Phone Number') }}</label>
                                        
                
                                            <div class="col-md-9">
                                                <input id="phone" type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                                                @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                                @endif
                                            </div>
                                        </div>
        
        
                                     <div class="form-group  row col-md-6 ">
                                        <label for="dob" class="col-md-3 col-form-label">{{ __('Date of Birth') }}</label>
        
                                        <div class="form-group col-md-9">
                                           <!-- {{-- <input id="dob" type="text" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob" value="{{ old('dob') }}" required> --}}  -->
                                           <!-- <input type="date" id="dob" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}" name="dob"> -->
                                           
                                           <div class="input-group date" data-provide="datepicker">
                                                <input  name="dob" class="form-control{{ $errors->has('dob') ? ' is-invalid' : '' }}">
                                                <div class="input-group-addon">
                                                    <span class="glyphicon glyphicon-th"></span>
                                                </div>
                                            </div>
                                            @if ($errors->has('dob'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dob') }}</strong>
                                            </span>
                                            @endif    
                                        </div>                       
                                    </div>
                             </div>
                                
                            <div class="form-group row">
                                    <div class="form-group col-md-6 row">
                                            <label for="gender" class="col-md-4 col-form-label ">{{ __('Gender') }}</label>
                
                                            <div class="form-group col-md-8">
                                                <select name="gender" id="gender" class="form-control{{ $errors->has('gender') ? ' is-invalid' : '' }}">
                                                   <option value="male">Male</option>
                                                   <option value="female">Female</option>
                                                   <option value="other">Other</option>
                                                </select>
                                                @if ($errors->has('gender'))
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('gender') }}</strong>
                                                    </span>
                                                @endif     
                                            </div>                      
                                        </div>
                                        <div class="col-md-6 row form-group{{ $errors->has('org_id') ? ' has-error' : '' }} ">
                                                <label for="org_id" class="col-md-4 col-form-label ">Organisation</label>
                    
                                                <div class="form-group col-md-8">
                                                    <select id="org_id"  class="form-control" name="org_id" required>
                                                        <option value="0"></option>   
                                                        @foreach($orgs as $org)
                                                                <option value={{$org->id}}>{{$org->name}}</option>
                                                                
                                                        @endforeach 
                                                    </select>
                    
                                                    @if ($errors->has('org_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('org_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                            </div>
                             

                                <div class="form-group row">
                                        <div class="col-md-6 row form-group{{ $errors->has('role_id') ? ' has-error' : '' }}">
                                                <label for="role_id" class="col-md-4 col-form-label ">Role</label>
                                               
                                              
                                                <div class="form-group col-md-8">
                                                    <select id="role_id"  class="form-control" name="role_id" required>
                                                    <option value="0"></option>
                                                    @foreach($roles as $role)
                                                          <!-- <option value="0"></option> -->
                                                          <option value={{$role->id}}>{{$role->name}}</option>
                                                    @endforeach
                                                    </select>
                    
                                                    @if ($errors->has('role_id'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('role_id') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                </div>
                                  
                                   <div class=" form-group row">
                                     <div  id="jurisdiction"   class="col-md-8">

                                     </div>
                                    </div>
                            <input type="submit" class="btn btn-success"/>
                            <br/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <script>
  $( function() {
    $( "#datepicker" ).datepicker();
  } );
  </script> -->
  <!-- <script type="text/javascript">

    $('.date').datepicker({  

       format: 'dd-mm-yyyy'

     });  

</script>-->
@endsection
