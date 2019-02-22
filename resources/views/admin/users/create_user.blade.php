@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
    <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
               
                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Create User</h3>
                    <form action="{{route('users.store')}}" method="post" class="form-horizontal">
                           {{csrf_field()}}     
                        <div class="form-group row">
                            <label  class="col-md-3" for="name"  >Name</label>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <input id="name" type="text" class="form-control form-control-user" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                                @if ($errors->has('name'))
                                <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                <!-- </div> -->
                <div class="form-group row">
                <label for="email" class="col-md-3" >Email</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  <input id="email" type="email" class="form-control form-control-user" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    </div>
                </div>
                <div class="form-group row">
                <label for="password" class="col-md-3">Password</label>
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input id="password" type="password" class="form-control form-control-user" name="password" required placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                 
                </div>
                <div class="form-group row">
                <label class="col-md-3"  for="phone">{{ __('Phone Number') }}</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                <input id="phone" type="text" class="form-control form-control-user" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                  @if ($errors->has('phone'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('phone') }}</strong>
                  </span>
                  @endif
                  </div>
                </div>
                <div class="form-group row date" data-provide="datepicker">
                
                <label for="dob" class="col-md-3 col-form-label">{{ __('Date Of Birth') }}</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input  name="dob" class="form-control form-control-user" placeholder="Date Of Birth">
                    
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                    @if ($errors->has('dob'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="form-group row">
                 <label for="gender" class="col-md-3 col-form-label">{{ __('Gender') }}</label>
                 <div class="col-sm-6 mb-3 mb-sm-0">
                    <select name="gender" class="form-control" type="select" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <option value="male">Male</option>
                      <option value="female">Female</option>
                      <option value="other">Other</option>
                    </select>
                    </div>
                    @if ($errors->has('gender'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('gender') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group row">
                <label for="org_id" class="col-md-3 col-form-label">Organisation</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                  
                    <select id="org_id" name="org_id" class="form-control"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                      <option value=0></option>
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
                <div class="form-group row">
                <label for="role_id" class="col-md-3 col-form-label">Role</label>
                <div class="col-sm-6 mb-3 mb-sm-0">
                
                    <select id="role_id"  class="form-control" name="role_id" required>
                    </select>
                    @if ($errors->has('role_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('role_id') }}</strong>
                      </span>
                    @endif  
                    
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">Submit</button>
                
                </form>
                        
                </div>
            </div>
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
