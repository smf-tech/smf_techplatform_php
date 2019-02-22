@extends('layouts.app1')

@section('content')
  <!-- <div class="container"> -->

    <!-- Outer Row -->
    <div class="row-login">

      <div class="col-xl-10-login col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <!-- <div class="col-lg-6 d-none d-lg-block"></div> -->
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Login!</h1>
                  </div>
                  <form class="user" method="POST" action="{{ route('login') }}">
                  {{ csrf_field() }}
                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                      <!-- <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..."> -->
                      <input id="email" type="text" class="form-control form-control-user" name="email" value="{{ old('email') }}" aria-describedby="emailHelp" placeholder="Enter Username...">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                      <!-- <input type="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password"> -->
                      <input id="password" type="password" class="form-control form-control-user" name="password" required placeholder="Password">
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                      <div class="custom-control custom-checkbox small">
                        <input type="checkbox" class="custom-control-input" id="customCheck">
                        <label class="custom-control-label" for="customCheck">Remember Me</label>
                      </div>
                    </div>
                    
                    <div style="text-align:center;padding-left:205px;">
                      <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                    </div>
                  </form>
                  
                  <!-- <div class="text-center">
                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                  </div> -->
                  
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  <!-- </div> -->

@endsection
