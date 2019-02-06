@extends('layouts.userBased',compact(['orgId'=>$orgId,'modules'=>$modules]))

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
                        <h3>Create Associate</h3></br></br>
                    <form action="{{route('associates.store',['orgId' => $orgId])}}" method="post">
                           {{csrf_field()}}     
                        <legend></legend>
                             <div class="form-group">
                                
                                <h4>Name : </h4>
                                    <input type ="text" name="name" class="form-control"></input>
                                </br>
                                
                                <h4>Type : </h4>
                                <select name="type" class="form-control">
                                        <option value="0"></option>
                                        <option value="donor"> Donor </option>                                                                                               
                                        <option value="vendor"> Vendor </option>                                                                                               
                                        <option value="partner"> Partner </option>                                                                                               
                                </select>    
                                </br>

                                <h4>Contact Person : </h4>
                                    <input type ="text" name="contact_person" class="form-control"></input>
                                </br>

                                <h4>Contact Number : </h4>
                                    <input type ="text" name="contact_number" class="form-control"></input>
                                </br>
                                                           
                            </div>
                            
                            <input type="submit" class="btn btn-success"/>

                         </form>                        
                </div>
            </div>
        </div>
    </div>
</div>
@endsection