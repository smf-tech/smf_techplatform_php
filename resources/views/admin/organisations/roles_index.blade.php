@extends('layouts.userBased')

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

                    <div class="row">
                            <h3 class="col-md-9">Organisation Roles</h3> 
                  </div>
                        
                    
                        <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                           @forelse($roles as $role)
                                <tr>
                                    <td>{{$role->display_name}}</td>
                                    <td> 
                                        <div>
                                            <a class="btn btn-info"  href='/{{$orgId}}/roles/{{$role->id}}'>Configure</a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>No Roles Found</td></tr>
                            @endforelse  
                        </table>   
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection