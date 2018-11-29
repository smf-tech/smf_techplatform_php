@extends('layouts.app')

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
                                        <div>
                                        {{-- <div id="survey_id" class = "{{ $survey->json }}"> --}}
                                            {{-- <a class ="btn btn-success"href="{{ route('take_survey') }}">Take Survey</a> --}}

                                            {{-- <form action="/getSurvey" method="post">
                                                    <input type="submit" name="upvote" value="Take Survey" />
                                            </form> --}}
                                        {{-- <a class ="btn btn-success"href="{{url('/getSurvey',[$survey->json])}}">Take Survey</a> --}}
                                        <form method="post">
                                            @csrf           
                                            <input type="hidden" name="surveyID" value="{{$survey->id}}" id="survey_id">                                 
                                            <input type="hidden" name="json" value="{{$survey->json}}" id="json_value">
                                            <input type="submit" id="submit" formaction="/getSurvey" value="Take Survey" />
                                        </form>
                                        {{-- <a class ="btn btn-success"href="{{url('/getSurvey')}}">Take Survey</a> --}}
                                        </div>
                                    </td>
                                    <td>
                                            {{-- <div class="actions">
                                                    <a class="btn btn-primary" href={{route('role.edit',$survey->id)}}><i class="fas fa-pen"></i></a>
                                                {!!Form::open(['action'=>['RoleController@destroy',$survey->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                            
                                                <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                                {!!Form::close()!!}
                                            </div> --}}
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