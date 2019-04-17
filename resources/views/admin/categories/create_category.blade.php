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
                    <h3>Create Category</h3>
                    <form action="{{route('category.store')}}" method="post">
                           {{csrf_field()}}
							<h4>Name</h4>
							@foreach ($locale as $localeIdentifier => $localeLabel)
							<div class="form-group ml-4">
								<label for="{{$localeIdentifier}}">{{$localeLabel}}</label>
								<input type="text" name="name[{{$localeIdentifier}}]" id="{{$localeIdentifier}}" class="form-control" value="{{old('name.'.$localeIdentifier)}}"/>
							</div>
							@endforeach
							@if ($errors->any())
								 <div class="alert alert-danger">
									 {{$errors->first()}}
								 </div>
							@endif
                                   
                             <div class="form-group">
                                    <label for="categoryType">Type</label>
                                    <select name="categoryType" class="form-control">
                                            <option value="0"></option>
                                            <option value="Form"> Form </option>                                            
                                            <option value="Reports"> Reports </option>                                                                                                                                           
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