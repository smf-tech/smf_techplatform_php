
@extends('layouts.app1')

@section('content')
<div class="jumbotron text-center">
    <h1>{{$pagetitle}}</h1>
    <p>this is index page</p>
    <p>you can login to portal using <a href="/login" class="btn btn-primary btn-lg" >Login</a>. To Register click here <a href="/register" class="btn btn-success btn-lg" href="/login">Register</a></p>
</div>
@endsection

