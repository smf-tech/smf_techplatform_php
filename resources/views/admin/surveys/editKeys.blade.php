@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))
@section('content')
<div>
        <form action="{{url('form/storeKeys')}}" method="post">
                {{csrf_field()}}     
        <h2>Selecting Primary Keys</h2></br>
        @for($i=0;$i<$numberOfKeys;$i++)
        
        @if(in_array($keys[$i],$primaryKeySet))
            <label><b>                
                <input type="checkbox" value="{{$keys[$i]}}" name="form_keys[]" checked/>&nbsp;&nbsp;{{$keys[$i]}}
            <b></label>
        @else
            <label><b>                
                <input type="checkbox" value="{{$keys[$i]}}" name="form_keys[]"/>&nbsp;&nbsp;{{$keys[$i]}}
            <b></label>
        @endif
             </br>
        @endfor
            <input type="hidden" name="surveyID" value="{{$survey_id}}" />
            {{-- <button type="button">Submit</button> --}}
            <input type="submit" class="btn btn-success"/>
    </form>
    
</div>

@endsection
