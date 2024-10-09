@extends('dashboard.layouts.master')

@section('title', 'Detailing')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Detailing Table</h3>
                <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.detailing.create') }}'">Add detailing package</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">Brand</th>
                                <th class="border-bottom-0">Type</th>
                                <th class="border-bottom-0">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->detailing_brand}}</td>
                                <td>{{$item->detailing_type}}</td>
                                <td>
                                    <a class="button btn btn-secondary square" href="{{ route('dashboard.detailing.edit',$item->id) }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a type="button" class="button btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#deleteModal{{$item->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <!-- Delete Modal -->
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
                                                    <form action="{{ route('dashboard.detailing.delete', $item->id) }}" method="POST" >
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

@endsection