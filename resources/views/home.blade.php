@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"><h3>Welcome to the Dashboard</h3></div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                {{--   @role('superuser')
                <div class="pull-xs-right">
                    <a class="btn btn-primary" href="{{ url('/role') }}" role="button">
                      Manage Roles
                    </a>
                </div>
                <div class="pull-xs-right">
                        <a class="btn btn-success" href="{{ url('/users') }}" role="button">
                          Manage Users
                        </a>
                    </div>
                @endrole
                --}}

        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
