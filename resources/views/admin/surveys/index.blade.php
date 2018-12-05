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
                            <h3 class="col-md-9">Surveys</h3>
                            <a class ="btn btn-success" href="/{{$orgId}}/surveys/create">Surveys<i class="fas fa-plus"></i></a>

                                    {{-- <a class ="btn btn-success"href="{{route('role.create')}}">survey   <i class="fas fa-plus"></i></a> --}}
                    </div>
                       
                      
                        <table class="table">
                            <tr>
                                <th>Name</th>
                            </tr>
                            @forelse($surveys as $survey)
                                <tr>
                                    <td>
                                        {{$survey->name}}
                                    </td>
                                    <td>
                                           <form method="post">
                                            @csrf           
                                            <input type="hidden" name="surveyID" value="{{$survey->id}}" id="survey_id">                                 
                                            <input type="hidden" name="json" value="{{$survey->json}}" id="json_value">
                                            <input  class="btn btn-primary" type="submit" id="submit" formaction="/{{$orgId}}/{{$survey->id}}/getSurvey" value="Take Survey" />
                                           </form>
                                    </td>
                                    <td>
                                            <form method="post">
                                              @csrf           
                                             <input type="hidden" name="surveyID" value="{{$survey->id}}" id="survey_id">                                 
                                             <input  class="btn btn-success" type="submit" id="submit" formaction="/{{$orgId}}/{{$survey->id}}/results" value="View Survey Results" />
                                             </form>

                                    </td>
                                          
                                </tr>
                                @empty
                                <tr><td>no Surveys</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $surveys->links() }}
            </div>
        </div>
    </div>
</div>
@endsection