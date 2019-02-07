@extends('layouts.userBased')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading"></div>
                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <h3>Create Report</h3>
                        <form action="{{route('reports.store', $orgId)}}" method="post">
                        {{csrf_field()}}     
                            <legend></legend>
                            <div class="form-group">
                                <label for="name">Report Name</label>
                                <input type="text" name="name" placeholder="Name of the report" class="form-control"/>
                                @if($errors->any())
                                 <b style="color:red">{{$errors->first('name')}}</b>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <input type="text" name="description" placeholder="Description" class="form-control"/>
                            </div>
                            <div class="form-group">
                                <label for="url">URL</label>
                                <input type="text" name="url" placeholder="URL" class="form-control"/>
                                @if($errors->any())
                                 <b style="color:red">{{$errors->first('url')}}</b>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="category">Category</label>
                                <input type="text" name="category" placeholder="Category" class="form-control"/>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" id="report-active" type="checkbox" name="active" value="1" id="defaultCheck1">
                                <label class="form-check-label" for="report-active">
                                    Active
                                </label>
                            </div>
                            <div class="form-group" style="clear:both;"></div>
                            <input type="submit" class="btn btn-success" value="Create"/>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection