@extends('layouts.userBased')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Edit Jurisdiction Type</h3>
                    @if (count($jurisdictions))
                        <form action="{{route('jurisdiction-types.update', ['orgId' => $orgId, 'jurisdiction_type' => $jurisdictionType->id])}}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="jurisdictions">Select Jurisdictions</label>
                                <select multiple name="jurisdictions[]" class="form-control" id="jurisdictions">
                                    @foreach ($jurisdictions as $jurisdiction)
                                        <option value="{{ $jurisdiction->levelName }}" {{in_array($jurisdiction->levelName, $jurisdictionType->jurisdictions) ? 'selected="selected"' : ''}}>{{ $jurisdiction->levelName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->any())
                                    <b style="color:red">{{$errors->first()}}</b>
                                @endif
                            </div>
                            <input type="submit" class="btn btn-success"/>
                        </form>
                    @else
                        <p>Please create Jurisdiction first to edit Jurisdiction Types.</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection