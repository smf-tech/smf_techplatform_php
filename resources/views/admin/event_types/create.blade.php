@extends('layouts.userBased')

@section('content')
<div class="container">
<div class="card o-hidden border-0 shadow-lg my-5">
    <div class="card-body p-0">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default" style="padding-left:50px;padding-top:40px;padding-bottom:75px;">

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <h3>Create Event Type</h3>
                    <form action="{{route('event-type.store')}}" method="post">
                           {{csrf_field()}}
                           <div class="form-group">
                                <label for="eventTypeName">Name</label>
                                <input type="text" name="name" placeholder="Event type Name" class="form-control"/>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        {{$errors->first()}}
                                    </div>
                                @endif
                            </div>
                                   
                             <div class="form-group">
                                    <label for="assocForms">Forms</label>
                                    <select name="associatedForms[]" class="form-control" multiple="multiple">
                                            @foreach($forms as $form)
                                            <option value="{{$form->id}}" >{{$form->name['default']}}</option>
                                            @endforeach                                                                                                                                        
                                    </select>                                       
                                </div>                        
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                         </form>                        
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
</div>
@endsection