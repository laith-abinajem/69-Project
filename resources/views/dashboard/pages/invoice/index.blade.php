@extends('dashboard.layouts.master')

@section('title', 'work orders')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Work orders Table</h3>
            </div>
                <form action="{{ route('dashboard.invoices.index') }}" method="GET">
                    @csrf
                    <div class="col-md-3 col-lg-4 mb-2">
                        <label class="form-control-label">Filter by:</label>
                       
                    </div>

                    <div class="col-md-2 col-lg-1 mb-2">
                        <button type="submit" class="btn btn-primary ms-2px">Filter</button>
                    </div>
                </form>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">Name</th>
                                <th class="border-bottom-0">Phone</th>
                                <th class="border-bottom-0">Car</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->name}}</td>
                                <td>{{$item->phone}}</td>
                                <td>{{$item->make}} - {{$item->year}} - {{$item->model}}</td>
                                <td>
                                    <a class="button btn btn-secondary" href="{{ route('pdf',$item->id) }}" target="_blank">
                                        Worksheet
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection