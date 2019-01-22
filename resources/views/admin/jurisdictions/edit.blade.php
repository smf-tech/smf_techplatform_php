@extends('layouts.userBased')

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
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <h3>Edit Jurisdiction</h3>
                        {!! Form::model($juris, ['route' => ['jurisdictions.update', $juris->id ], 'method'=>'PUT', 'id' => 'jurisdiction-edit-form']) !!}
                        
                        {{csrf_field()}} 
                        <legend></legend>
                            <div class="form-group">
                                <label for="levelName">Level Name</label>
                                <input type="text" name="levelName" placeholder="Level name"class="form-control" value="{{$juris->levelName}}"/>
                            </div>
                            <input type="submit" class="btn btn-success"/>
                    
                        {!! Form::close() !!} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection