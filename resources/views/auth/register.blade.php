@extends('layouts.app1')

@section('content')

  <div class="container">

    <div class="card o-hidden border-0 shadow-lg my-5">
      <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
          <!-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> -->
          <!-- <div class="col-lg-5 d-none d-lg-block"></div> -->
          <!-- <div class="col-lg-7"> -->
          <div col-lg-5 d-none d-lg-block>
            <div class="p-5">
              <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Register!</h1>
              </div>
              <form class="user" method="POST" action="{{ route('register') }}">
              {{ csrf_field() }}
                <!-- <div class="form-group row"> -->
                  <div class="form-group">
                    <input id="name" type="text" class="form-control form-control-user" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                  </div>
                <!-- </div> -->
                <div class="form-group">
                  <input id="email" type="email" class="form-control form-control-user" name="email" value="{{ old('email') }}" required placeholder="E-Mail Address">
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input id="password" type="password" class="form-control form-control-user" name="password" required placeholder="Password">
                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                  <div class="col-sm-6">
                    <input id="password-confirm" type="password" class="form-control form-control-user" name="password_confirmation" required placeholder="Confirm Password">
                  </div>
                </div>
                <div class="form-group row">
                <input id="phone" type="text" class="form-control form-control-user" name="phone" value="{{ old('phone') }}" required placeholder="Phone Number">
                  @if ($errors->has('phone'))
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('phone') }}</strong>
                  </span>
                  @endif
                </div>
                <div class="form-group row date" data-provide="datepicker">
                  <!-- <div class="form-group row date" data-provide="datepicker"> -->
                    <input  name="dob" class="form-control form-control-user" placeholder="Date Of Birth">
                    
                    <div class="input-group-addon">
                      <span class="glyphicon glyphicon-th"></span>
                    </div>
                    @if ($errors->has('dob'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('dob') }}</strong>
                    </span>
                    @endif
                  <!-- </div> -->
                </div>
                <div class="form-group row">
                 <div class="dropdown mb-4">
                    <select name="gender" class="btn btn-primary dropdown-toggle" type="select" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <option value="">Gender</option>
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
                  <div class="dropdown mb-4">
                    <select id="org_id" name="org_id" class="btn btn-primary dropdown-toggle"  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" required>
                      <option value=0>Organisation</option>
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
                  <div class="dropdown mb-4">
                    <select id="role_id"  class="btn btn-primary dropdown-toggle" name="role_id" required>
                    </select>
                    @if ($errors->has('role_id'))
                      <span class="help-block">
                          <strong>{{ $errors->first('role_id') }}</strong>
                      </span>
                    @endif  
                  </div>
                </div>

                <button type="submit" class="btn btn-primary btn-user btn-block">Register Account</button>
                <hr>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
@endsection