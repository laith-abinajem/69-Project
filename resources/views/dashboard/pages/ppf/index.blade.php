@extends('dashboard.layouts.master')

@section('title', 'ppfs')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Ppf Brand Table</h3>
                <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.ppf.create') }}'">Add Ppf</button>
            </div>
            @if(auth()->user()->type === "super_admin")
                <form action="{{ route('dashboard.ppf.index') }}" method="GET">
                    @csrf
                    <div class="col-md-3 col-lg-4 mb-2">
                        <label class="form-control-label">Filter by:</label>
                        <select name="user_id" id="user_id" class="form-control paintProtectionFil select2">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 col-lg-1 mb-2">
                        <button type="submit" class="btn btn-primary ms-2px">Filter</button>
                    </div>
                </form>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">Ppf brand</th>
                                <th class="border-bottom-0">Ppf description</th>
                                <th class="border-bottom-0">User</th>
                                <th class="border-bottom-0">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->ppf_brand}}</td>
                                <td>{{$item->ppf_description}}</td>
                                <td>{{$item->user->name}}</td>
                                <td>
                                    <a class="button btn btn-secondary" href="{{ route('dashboard.ppf.edit',$item->id) }}">
                                        <i class="fas fa-edit"></i>
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
                                                    <form action="{{ route('dashboard.ppf.delete', $item->id) }}" method="POST" >
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