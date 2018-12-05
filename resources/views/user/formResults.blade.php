@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))

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
                            <h3 class="col-md-9">Results</h3>

                                    {{-- <a class ="btn btn-success"href="{{route('role.create')}}">survey   <i class="fas fa-plus"></i></a> --}}
                    </div>
                       
                      
                        <table class="table">
                            <tr>
                                <td>User ID</td>
                                <td>Json Response</td>

                            </tr>
                            @foreach($survey_results as $result)
                                <tr>
                                    <td>{{$result->user_id}}</td>
                                    <td><code>{{($result->json)}}</code></td>
                                </tr>
                            @endforeach
                        </table>                           
                </div>
            </div>
        </div>
    </div>
</div>
@endsection