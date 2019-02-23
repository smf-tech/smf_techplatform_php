@extends('layouts.userBased')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Locations</h1>
    <p class="mb-4">
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
    </p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            &nbsp;
        </div>
        <div class="card-body">
            <div class="table-responsive">
            <form action="{{route('locations.store',['orgId' => $orgId])}}" method="post">
                {{csrf_field()}}     
                <legend></legend>
                    <div>
                        <h4>Jurisdiction Type</h4>
                        <select id="jurisdictionType" name="jurisdictionTypeId" class="form-control">
                                <option value="0"></option>

                                @foreach($jurisdictions as $jurisdiction)
                                    {{ $jurisdictionLevels = "" }}
                                    {{ $i = true }}
                                    {{ $first = $loop->first }}

                                           @foreach($jurisdiction->jurisdictions as $type)
                                           {{-- Storing each value of jurisdictions array as a comma separated string --}}
                                               @if($i != true)
                                               {{ $jurisdictionLevels = $jurisdictionLevels.", ".$type }}
                                               @else
                                               {{ $jurisdictionLevels = $type }}
                                               {{ $i = false }}
                                               @endif
                                           @endforeach
                                               <option id={{$jurisdiction->id}} value={{$jurisdiction->id}} {{ $first ? 'selected="selected"' : '' }}> {{ $jurisdictionLevels }}</option>
                                        @endforeach
                                </select>
                                <br>
                            </div>
                            <div>
                            <button id="deleteRow" class="btn btn-primary btn-icon-split btn-sm"><span class="icon text-white-50">
                            <i class="fas fa-trash"></i></span><span class="text">Delete Selected Row</span></button>
                            </div>
                            <div>&nbsp;</div>
                            <table id="location" class="display table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>id</th>
                                    <th>State</th>
                                    <th>District</th>
                                    <th>Taluka</th>
                                    <th>Village</th>
                                </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th></th>
                                <th>id</th>
                                <th>State</th>
                                <th>District</th>
                                <th>Taluka</th>
                                <th>Village</th>
                            </tr>
                            </tfoot>
                            <!-- <tbody>
                            </tbody> -->
                        </table>
                </form>
                </div>
            </div>
        </div>
    

</div>
<!-- /.container-fluid -->
@endsection

<!-- @push('scripts')
<script src="{{ asset('js/location.js') }}"></script>
@endpush -->