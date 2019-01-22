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
                        <h3>Create Location</h3></br></br>
                    <form action="{{route('locations.store',['orgId' => $orgId])}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                        <div>
                           <h4>Name</h4>
                           <input type="text" name="name" class="form-control"></input></br>
                            @if($errors->has('name'))
                            <b style="color:red">{{$errors->first('name')}}</b>
                            @endif
                        {{-- </br></br></br> --}}
                        </div>
                             <div>
                                <h4>Jurisdiction Type</h4>
                                <select id="jurisdictionType" name="jurisdictionId" class="form-control">
                                        <option value="0"></option>
                                        
                                        @forelse($jurisdictions as $jurisdiction)
                                            {{ $jurisdictionLevels = "" }}
                                            {{ $i = true }}
                                            
                                            
                                            {{-- @foreach($jurisdiction->type['jurisdiction'] as $type)
                                                @if($i != true)
                                                {{ $types = $types.", ".$type['name'] }}
                                                @else
                                                {{ $types = $type['name'] }}
                                                {{ $i = false }}
                                                @endif    
                                            @endforeach --}}




                                            @foreach($jurisdiction->jurisdictions as $type)
                                            {{-- Storing each value of jurisdictions array as a comma separated string --}}
                                                @if($i != true)
                                                {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                                @else
                                                {{ $jurisdictionLevels = $type }}
                                                {{ $i = false }}
                                                @endif    
                                            @endforeach                                            
                                                <option id={{$jurisdiction->id}} value={{$jurisdiction->id}}> {{ $jurisdictionLevels }}</option>                                                                                               
                                        @endforeach 
                                </select>                               
                            </div>
                            </br>
                            <div id="levelContainer"  class="form-group">                                       
                            </div>
                            <input type="submit" class="btn btn-success"/>
                         </form>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection