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
                        <h3 class="col-md-9">Reports</h3>
                        <a class ="btn btn-success"href="{{route('reports.create')}}">Report<i class="fas fa-plus"></i></a>
                    </div>
                    <table class="table">
                        <tr>
                            <th>Name</th>
                            <th>Description</th>
                            <th>URL</th>
                            <th>Category</th>
                            <th>Is Active</th>
                            <th>Action</th>
                        </tr>
                        @forelse($reports as $report)
                        <tr>
                            <td>{{$report->name}}</td>
                            <td>{{$report->description}}</td>
                            <td>{{$report->url}}</td>
                            <td>{{$report->category}}</td>
                            <td>@if ($report->active == 1)
                                    {{'Active'}}
                                @else
                                    {{'Inactive'}}
                                @endif
                            </td>
                            <td>
                                <div class="actions">
                                    <a class="btn btn-primary" href={{route('reports.edit',$report->id)}}><i class="fas fa-pen"></i></a>
                                    <form action="{{ url('reports',$report->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form> 
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td>No Reports Found !!</td></tr>
                        @endforelse
                    </table>   
                </div>
            </div>
        </div>
    </div>
</div>
@endsection