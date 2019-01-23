@extends('layouts.userBased')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h3>Create Jurisdiction Type</h3>
                    @if (count($jurisdictions))
                        <form action="{{route('jurisdiction-types.store', ['orgId' => $orgId])}}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="jurisdictions">Select Jurisdictions</label>
                                <select multiple name="jurisdictions[]" class="form-control" id="jurisdictions">
                                    @foreach ($jurisdictions as $jurisdiction)
                                        <option value="{{ $jurisdiction->levelName }}">{{ $jurisdiction->levelName }}</option>
                                    @endforeach
                                </select>
                                @if($errors->any())
                                    <b style="color:red">{{$errors->first()}}</b>
                                @endif
                            </div>
                            <input type="submit" class="btn btn-success"/>
                        </form>
                    @else
                        <p>Please create Jurisdiction first to create Jurisdiction Type.</p>
                    @endif
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection