@extends('layouts.userBased')

@section('content')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">
                <div class="panel-body">
                    <h3>Edit Module</h3>
                    <form action="{{route('modules.update', ['orgId' => $orgId, 'module' => $module->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" placeholder="Enter name here" class="form-control" value="{{ $module->name }}" />
                            @if($errors->any())
                                <b style="color:red">{{$errors->first()}}</b>
                            @endif
                        </div>
                        <input type="submit" class="btn btn-primary btn-user btn-block" value="Update"/>
                    </form>

                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection