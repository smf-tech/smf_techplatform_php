@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                        <h3>Create Role</h3>
                    <form action="{{route('role.store')}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                 <label for="name">Role Name</label>
                                 <input type="text" name="name" placeholder="name of the role"class="form-control"/>
                             </div>
                             <div class="form-group">
                                    <label for="display_name">Display Name</label>
                                    <input type="text" name="display_name" placeholder="Display Name"class="form-control"/>
                            </div>
                             <div class="form-group">
                                <label for="description">Description</label>
                                 <input type="text" name="description" placeholder="description"class="form-control"/>
                            </div>
                            <div class="form-group sub-con">
                            <div  class="form-group" >
                            <h4>Organisation</h4>
                                <select name="org_id" id ="orgid" class="form-control">
                                    <option value=""></option>
                                    @foreach($orgs as $org)
                                        <option value={{$org->id}}>{{strtoupper($org->name)}}</option>
                                    @endforeach 
                                </select>
                                </br>
                                <h4>Projects</h4>
                                <select name="project_id" id="project_id" class="form-control">
                                    <option value=""></option>
                                </select>
                        </div>
                        </div>
                            <input type="submit" class="btn btn-success"/>
                         </form>
                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection