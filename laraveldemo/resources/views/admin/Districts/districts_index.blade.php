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
                        <h3 class="col-md-9">Districts</h3>
                        {{-- <div class="col"> --}}
                                <a class ="btn btn-success"href="{{route('district.create')}}">District   <i class="fas fa-plus"></i></a>
                        {{-- </div> --}}
                        </div>
                        <table class="table">
                            <tr>
                                <th>District ID</th>
                                <th>District Name</th>
                                <th>State Name</th>
                                <th>Action</th>
                            </tr>
                            @forelse($dis as $d)
                                <tr>
                                    <td>{{$d->id}}</td>
                                    <td>{{$d->Name}}</td>
                                    <td>{{$d->state->Name}}</td>
                                    <td><div class="actions">
                                        <a class="btn btn-primary" href={{route('district.edit',$d->id)}}><i class="fas fa-pen"></i></a>
                                        {!!Form::open(['action'=>['DistrictController@destroy',$d->id],'method'=>'DELETE','class'=>'pull-right' ])!!}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                            {{-- {{Form::submit('Delete',['class'=>'btn btn-danger'])}} --}}
                                         {!!Form::close()!!}
                                        {{-- </form>     --}}
                                    </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td>no Districts</td></tr>
                            @endforelse
                        </table>                           
                </div>
                {{ $dis->links() }}
            </div>
        </div>
       
    </div>
</div>
@endsection