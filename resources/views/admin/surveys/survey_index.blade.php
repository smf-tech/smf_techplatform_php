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
                            <h3 class="col-md-9">Forms</h3>
                            <a class ="btn btn-success" href="/{{$orgId}}/forms/create">Forms<i class="fas fa-plus"></i></a>
                            {{-- <a class ="btn btn-success"href="{{route('role.create')}}">survey   <i class="fas fa-plus"></i></a> --}}
                    </div>
                    <table class="table">
                            <tr>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Project</th>                                
                                <th>Microservice</th>
                                <th>Entity</th>
                            </tr>
                            @forelse($surveys as $survey)
                                <tr>
                                    <td>
                                        {{ $survey->name }}
                                    </td>
                                    <td>
                                        {{ $survey->category['name'] }}
                                    </td>
                                     <td>
                                            {{ $survey->project['name'] }}
                                            {{-- {{$survey->project_id}} --}}
                                    </td>                                    
                                    <td>
                                            {{ $survey->microservice['name'] }}
                                    </td>
                                    <td>
                                        {{ $survey->entity['display_name'] }}
                                    </td>
                                    <td><div class="actions">
                                            {{-- {!!Form::open(['action'=>['SurveyController@editForm',$survey->id],'method'=>'EDIT','class'=>'pull-right' ])!!}
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-pen"></i></button> --}}
                                    <a class="btn btn-primary"  href="/{{$orgId}}/editForm/{{$survey->id}}"><i class="fas fa-pen"></i></a>
                                {!!Form::open(['action'=>array('SurveyController@destroy',$survey->id),'method'=>'DELETE','class'=>'pull-right' ])!!}
                                    <button type="submit" class="btn btn-danger"{{-- id="id" value="{{$orgId}}"--}}><i class="fas fa-trash-alt"></i></button>
                                {!!Form::close()!!}
                                </div>
                                </td>                                   
                                    {{-- <td>
                                           <form method="post">
                                            @csrf           
                                            <input type="hidden" name="surveyID" value="{{$survey->id}}" id="survey_id">                                 
                                            <input type="hidden" name="json" value="{{$survey->json}}" id="json_value">
                                            <!--input  class="btn btn-primary" type="submit" id="submit" formaction="/{{$orgId}}/{{$survey->id}}/getSurvey" value="Take Survey" /-->
                                           </form>
                                    </td>
                                    <td>
                                            <form method="post">
                                              @csrf           
                                             <input type="hidden" name="surveyID" value="{{$survey->id}}" id="survey_id">                                 
                                             <!--input  class="btn btn-success" type="submit" id="submit" formaction="/{{$orgId}}/{{$survey->id}}/results" value="View Survey Results" /-->
                                             </form>

                                    </td> --}}
                                          
                                </tr>
                                @empty
                                <tr><td>no Forms</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $surveys->links() }}
            </div>
        </div>
    </div>
</div>
@endsection