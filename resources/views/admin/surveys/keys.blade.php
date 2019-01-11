@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))
@section('content')
{{-- <head>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $("button").click(function(){
                    var primaryKeys = [];
                    var number = 1;
                    $.each($("input[name="number"]:checked"), function(){            
                        primaryKeys.push($(this).val());
                        number = number + 1;
                    });
                    alert("Primary Keys are: " + primaryKeys.join(", "));
                });
            });
        </script>
<head> --}}
<div>
        <form action="{{url('form/storeKeys')}}" method="post">
                {{csrf_field()}}     
        <h2>Selecting Primary Keys</h2></br>
        @for($i=0;$i<$numberOfKeys;$i++)
            <label><b>                
                <input type="checkbox" value="{{$keys[$i]}}" name="primaryKeys[]"/>&nbsp;&nbsp;{{$keys[$i]}}
            <b></label>
            {{-- 
             echo Form::checkbox('multiple_entry','',false, ['id'=>'multiple_entry']); 
             ?>     --}}
             {{-- <label><b>{{$keys[$i]}}</b></label> --}}
             </br>
        @endfor
            <input type="hidden" name="surveyID" value="{{$survey_id}}" />
            {{-- <button type="button">Submit</button> --}}
            <input type="submit" class="btn btn-success"/>
    </form>
    
</div>

@endsection
