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
                        <h3>Edit Location</h3></br>
                        {{-- {!! Form::model($location, ['route' => [ 'location.update', $location->id ], 'method'=>'PUT', 'id' => 'location-edit-form']) !!} --}}
                        {!! Form::open(['route' => [ 'locations.update', $orgId, $location->id ], 'method'=>'PUT', 'id' => 'location-edit-form']) !!}
                        {{csrf_field()}} 
                        <legend></legend>       
                                        
                             <div class="form-group">
                                    <h4>Name</h4>
                             <input type="text" name="name" value="{{$location->name}}" class="form-control"/>
                             @if($errors->has('name'))
                            <b style="color:red">{{$errors->first('name')}}</b>
                            @endif
                            </div>
                            <div>
                                   <h4>Jurisdiction Type</h4>
                                   <select id="editJurisdiction" name="jurisdictionId" class="form-control">
                                           <option value="0"></option>
                                           
                                           @forelse($jurisdictions as $jurisdiction)
                                               {{ $jurisdictionLevels = "" }}
                                               {{ $i = 1 }}
                                               {{-- @foreach($jurisdiction->type['jurisdiction'] as $type)
                                                   @if($i != 1)
                                                   {{ $types = $types.", ".$type['name'] }}
                                                   @else
                                                   {{ $types = $type['name'] }}
                                                   {{ $i = 0 }}
                                                   @endif                     
                                                @endforeach --}}

                                                @foreach($jurisdiction->jurisdictions as $type)
                                                {{-- Storing each value of jurisdictions array as a comma separated string --}}
                                                    @if($i != 1)
                                                        {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                                    @else
                                                        {{ $jurisdictionLevels = $type }}
                                                        {{ $i = 0 }}
                                                    @endif    
                                                @endforeach

                                                   @if($jurisdiction->id==$location->jurisdictionId)
                                                    <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} selected> {{ $jurisdictionLevels }}</option>                                                                                               
                                                    {{$levels = $jurisdictionLevels}}
                                                   @else
                                                    <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} > {{ $jurisdictionLevels }}</option>                                                                                               
                                                   @endif
                                   {{-- <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} {{($jurisdiction->id==$location->jurisdictionId)?'selected':''}} > {{ $types }}</option>                                                                                                --}}
                                           @endforeach 
                                   </select>  
                                <input type="hidden" name="jurisdictionTypes" value="{{$levels}}"></input>
                                </div>
                            </br>
                            <div id="contentId">
                                @foreach($location->level as $key=>$value)
                                {{-- $key stores values such as state, district, taluka, unit, cluster  & $value stores the names given to them--}}
                                    <h4>{{$key}}</h4>
                                    <input type="text" name="location{{$i}}" value="{{$value}}" class="form-control"></input>  </br>
                                    <?php $i = $i+1; ?>
                                @endforeach     
                            </br> 
                            </div>                             
                               <div id="levelContainer"  class="form-group">                                       
                                </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!}
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection