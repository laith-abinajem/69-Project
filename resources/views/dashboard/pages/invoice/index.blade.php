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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                            Filtering
                        </button>
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
                                    <a type="button" class="button btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <div class="modal fade" id="deleteModal{{$item->id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{$item->id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="modal-body">
                                                        Are you sure you want to delete ? 
                                                    </div>
                                                    <form action="{{ route('dashboard.invoices.delete', $item->id) }}" method="POST" >
                                                        @csrf
                                                        <div class="modal-footer mt-3">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-danger">Confirm Delete</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header"  style="background-color: #178cc5">
            <h5 class="modal-title"  style="color: white" id="staticBackdropLabel">Report Details</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('dashboard.invoices.index') }}" method="get" >
                <div class="row">
                    <div class="col-lg-12 d-flex mt-3">
                        <div class="col-6">
                            <h6 class="font" >From</h6>
                            <input type="date" name="from" class="form-control">
                        </div>
                        <div class="col-6">
                            <h6 class="font" >To</h6>
                            <input type="date" name="to" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer mt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
        </form>
        </div>
        
        </div>
    </div>
</div>
@endsection