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
                    <h3>Create Entity</h3>
                    <form action="{{route('entity.store')}}" method="post">
                           {{csrf_field()}}     
                           <legend></legend>
                             <div class="form-group">
                                 <label for="entityName">Entity Name</label>
                                 <input type="text" name="entityName" placeholder="name of the entity" class="form-control"/>
                                 @if($errors->any())
                                 <b style="color:red">{{$errors->first()}}</b>
                                 @endif
                             </div>    
                             <div class="form-group">
                                <label for="displayName">Display Name</label>
                                <input type="text" name="displayName" placeholder="display name of the entity" class="form-control"/>
                                @if($errors->any())
                                <b style="color:red">{{$errors->first()}}</b>
                                @endif
                            </div>     
                            <div class="form-group">
                                <label for="entityActive">Is active</label>
                                <input type="checkbox" name="active" checked/>
                            </div>                         
                            <input type="submit" class="btn btn-primary btn-user btn-block"/>
                         </form>                        
                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection