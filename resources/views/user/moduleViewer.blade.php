@extends('layouts.userBased',compact('orgId'))

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
                        <div class="row">
                        <h3 class="col-md-9">{{$module_name[0]->name}}</h3>
                        <div class="col">
                            <a class ="btn btn-success" href="/{{$orgId}}/{{$module_name[0]->name}}/create">{{$module_name[0]->name}}   <i class="fas fa-plus"></i></a>
                        </div>
                        
                        </div>
                        <table class="table">
                                <tr>
                                    @foreach($fields as $field)
                                         <th>{{$field}}</th>
                                    @endforeach
                                </tr>
                                @foreach($module_content as $item)
                                        <tr>
                                            @foreach($fields as $field)
                                                 <td>{{$item->$field}}</td>
                                            @endforeach
                                        </tr>
                               @endforeach 
                        </table>   
                        
                </div>
            </div>
        </div>
       
    </div>
</div>
@endsection