@extends('layouts.userBased',compact('orgId'))

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
                                        
                             {{-- <div class="form-group">
                                    <h4>Name</h4>
                             <input type="text" name="name" value="{{$location->name}}" class="form-control"/>
                             @if($errors->has('name'))
                            <b style="color:red">{{$errors->first('name')}}</b>
                            @endif
                            </div> --}}
                            <div>
                                   <h4>Jurisdiction Type</h4>
                                   <select id="editJurisdictionType" name="jurisdictionTypeId" class="form-control">
                                           <option value="0"></option>
                                           
                                           @forelse($jurisdictions as $jurisdiction)
                                               {{ $jurisdictionLevels = "" }}
                                               {{ $i = 1 }}
                                               
                                                @foreach($jurisdiction->jurisdictions as $type)
                                                {{-- Storing each value of jurisdictions array as a comma separated string --}}
                                                    @if($i != 1)
                                                        {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                                    @else
                                                        {{ $jurisdictionLevels = $type }}
                                                        {{ $i = 0 }}
                                                    @endif    
                                                @endforeach

                                                   @if($jurisdiction->id==$location->jurisdiction_type_id)
                                                    <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} selected> {{ $jurisdictionLevels }}</option>                                                                                               
                                                    {{$levels = $jurisdictionLevels}}
                                                   @else
                                                    <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} > {{ $jurisdictionLevels }}</option>                                                                                               
                                                   @endif
                                           @endforeach 
                                   </select>                                  
                                </br>
                            <input type ="button" id="addJurisdictionTypeForEdit" value="add" ></input>    &nbsp;&nbsp;
                                <input type ="button" id="removeJurisdictionTypeForEdit" value="remove"></input>    

                                </div>
                            </br>
                            <div id="jurisdictionTypes">
                                    <?php $j = 0 ?>
                                @foreach($location->level as $level)                                    
                                </br> 
                                <div id="jurisdictionTypeContainer">
                                    @foreach($level as $key=>$value)
                                    @if($i == 0 && $j == 0)
                                        <?php $jurisdictions = $key ?>
                                    @elseif($j == 0)
                                        <?php $jurisdictions =  $jurisdictions.",".$key ?>
                                    @endif
                                {{-- $key stores values such as state, district, taluka, unit, cluster  & $value stores the names given to them--}}
                                    <h4>{{$key}}</h4>
                                <input type="text" name="level{{$j}}_location{{$i}}" value="{{$value}}" class="form-control"></input>  </br>
                                    <?php $i = $i+1; ?>                                    
                                    @endforeach                                    
                                </div>
                                    <?php $j = $j+1 ?>
                                    <?php $i = 0 ?>                                    
                                @endforeach     
                            </br>
                            <input type="hidden" name="jurisdictionTypes" value="{{$jurisdictions}}" class="form-control"></input>
                            </div>                             
                               <div id="jurisdictionTypeContainer2"  class="parent">
                                    <input type="hidden" name="noOfJurisdictionTypes" value={{$j}}></input>
                               </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!}
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection