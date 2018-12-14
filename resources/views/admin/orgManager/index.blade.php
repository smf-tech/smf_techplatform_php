
@extends('layouts.app')

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
                            <h3 class="col-md-5">Modules</h3>
                            
                            <form action="{{route('orgManager.store')}}" method="post" class="col row">
                                {{csrf_field()}}     
                            <input class="form-control col-md-7" name="mName"/>
                            <input name="orgId" type="hidden" value={{$id}}>
                            <span class="col-md-1"></span>
                            <button type="submit" class ="btn btn-success com-md-4">Module<i class="fas fa-plus"></i></button>
                            </form>
                    </div>
                       
                     
                        <table class="table">
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                               
                            </tr>
                            @forelse($modules as $module)
                            <tr>
                                <td>{{$module['_id']}}</td>
                                <td>{{$module['name']}}</td>
                            </tr>
                            @empty
                            <tr><td>no modules</td></tr>
                           @endforelse   
                        </table>   
                        
                </div>
            </div>
        </div>
        
    </div>
</div>



 

@endsection