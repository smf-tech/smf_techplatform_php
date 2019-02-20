@extends('layouts.userBased',compact(['orgId'=>$orgId]))

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
                        <h3>Location</h3></br></br>
                    <form action="{{route('locations.store',['orgId' => $orgId])}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                            <div>
                                <h4>Jurisdiction Type</h4>
                                <select id="jurisdictionType" name="jurisdictionTypeId" class="form-control">
                                       <option value="0"></option>

                                        @foreach($jurisdictions as $jurisdiction)
                                           {{ $jurisdictionLevels = "" }}
                                           {{ $i = true }}
                                           {{ $first = $loop->first }}

                                           @foreach($jurisdiction->jurisdictions as $type)
                                           {{-- Storing each value of jurisdictions array as a comma separated string --}}
                                               @if($i != true)
                                               {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                               @else
                                               {{ $jurisdictionLevels = $type }}
                                               {{ $i = false }}
                                               @endif
                                           @endforeach
                                               <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} {{ $first ? 'selected="selected"' : '' }}> {{ $jurisdictionLevels }}</option>
                                        @endforeach
                                </select>
                                <br>
                            </div>
                            </br>
                            <button id="deleteRow">Delete Selected Row</button>
                        </br>
                            <table id="location" class="display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>id</th>
                                        <th>State</th>
                                        <th>District</th>
                                        <th>Taluka</th>
                                        <th>Village</th>
                                    </tr>
                                </thead>
                            </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('css')
<!--    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.4/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/select/1.2.7/css/select.dataTables.min.css">-->
    <link rel="stylesheet" href="http://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
@endpush

@push('scripts')
<!--    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script>-->
    <script src="http://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('js/location.js') }}"></script>
@endpush