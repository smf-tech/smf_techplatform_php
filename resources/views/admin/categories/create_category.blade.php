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
                    <h3>Create Category</h3>
                    <form action="{{route('category.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                 <label for="categoryName">Name</label>
                                 <input type="text" name="categoryName" placeholder="name of the category" class="form-control"/>
                                 @if($errors->any())
                                 <b style="color:red">{{$errors->first()}}</b>
                                 @endif
                             </div>      
                             <div class="form-group">
                                    <label for="categoryType">Type</label>
                                    <select name="categoryType" class="form-control">
                                            <option value="0"></option>
                                            <option value="Form"> Form </option>                                            
                                            <option value="Reports"> Reports </option>                                                                                                                                           
                                    </select>                                       
                                </div>                        
                            <input type="submit" class="btn btn-success"/>
                         </form>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection