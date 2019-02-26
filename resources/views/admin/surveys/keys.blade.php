@extends('layouts.userBased',compact('orgId'))
@section('content')
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                        <div class="panel-body">
                            <form action="{{url('form/storeKeys')}}" method="post">
                                {{csrf_field()}}     
                                <h2>Selecting Primary Keys</h2><br/>
                                @for($i=0;$i<$numberOfKeys;$i++)
                                <label><b>                
                                <input type="checkbox" value="{{$keys[$i]}}" name="primaryKeys[]"/>&nbsp;&nbsp;{{$keys[$i]}}
                                <b></label>
                                <br/>
                                @endfor
                                <input type="hidden" name="surveyID" value="{{$survey_id}}" />
                                <input type="submit" class="btn btn-success"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
