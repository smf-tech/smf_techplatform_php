


@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))
@section('content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/knockout/3.4.0/knockout-min.js"></script>
    <script src="https://surveyjs.azureedge.net/1.0.56/survey.ko.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ace.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.0/ext-language_tools.js" type="text/javascript" charset="utf-8"></script>
    
    <link href="https://surveyjs.azureedge.net/1.0.56/surveyeditor.css" type="text/css" rel="stylesheet"/>
    <script src="https://surveyjs.azureedge.net/1.0.56/surveyeditor.js"></script>
    <!--link rel="stylesheet" href="https://unpkg.com/bootstrap@3.3.7/dist/css/bootstrap.min.css"-->
    <script src="https://surveyjs.azureedge.net/1.0.56/survey.jquery.min.js"></script>
                    <div id="surveyContainer">
                        <div id="editorElement"></div>
                    </div>
        </div>
    </div>
     <!-- Scripts -->
     <!--script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script-->
<script src="{{ asset('js/take_survey.js') }}" jsonText="{{ $json }}" id="json_survey" userID="{{ Auth::user()->id }}" surveyID="{{ $survey_id }}"></script>
@endsection