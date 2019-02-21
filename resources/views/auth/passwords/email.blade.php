@extends('layouts.app')

@section('content')

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-xl-10 col-lg-12 col-md-9">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-6 d-none d-lg-block"></div>
              <div class="col-lg-6">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                    <!-- <p class="mb-4">We get it, stuff happens. Just enter your email address below and we'll send you a link to reset your password!</p> -->
                  </div>
                  @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                  @endif
                  <form class="user" method="POST" action="{{ route('password.email') }}">
                  {{ csrf_field() }}
                    <div class="form-group">
                      <input type="email" name="email" class="form-control form-control-user" id="email" aria-describedby="emailHelp" value="{{ old('email') }}" required placeholder="Enter Email Address...">
                      @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                      @endif
                    </div>
                    <button type="submit" class="btn btn-primary btn-user btn-block">Send Password Reset Link</button>
                  </form>
                  <hr>
                  <div class="text-center">
                    @if (Route::has('register'))
                        <a class="small" href="{{ route('register') }}">{{ __('Register') }}</a>
                    @endif
                  </div>
                  <div class="text-center">
                    <!-- <a class="small" href="login.html">Already have an account? Login!</a> -->
                    <a class="small" href="{{ route('login') }}">{{ __('Login') }}</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>
@endsection