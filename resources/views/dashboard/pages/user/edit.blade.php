@extends('dashboard.layouts.master')

@section('title', 'Edit User')

@section('content')

<div class="row row-sm">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger" role="alert"> There is something wrong
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </div>
                @endif
                <h3 class="tile-title">{{ __('Edit User') }}</h3>
                <form action="{{ route('dashboard.user.edit', $data->id) }}" method="PUT">
                    @csrf
                    <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->name }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                    <input value="{{ $data->email }}" class="form-control" name="email" placeholder="Enter Email" required="" type="email">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Password: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('password') }}"  class="form-control" name="password" placeholder="Enter password" required="" type="password">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">User Type: <span class="tx-danger">*</span></label>
                                    <select name="type" id="type" required class="form-control paintProtectionFil select2 select2-no-search" >
                                        <option value="super_admin" {{ $data->type == 'super_admin' ? 'selected' : '' }}>Super admin</option>
                                        <option value="subscriber" {{ $data->type == 'subscriber' ? 'selected' : '' }}>Subscriber</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-6">
                                <label class="form-label">User status: <span class="tx-danger">*</span></label>
                                <select name="status" id="status" required class="form-control paintProtectionFil select2 select2-no-search" >
                                    <option value="approved" {{ $data->status == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="pending" {{ $data->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ $data->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                        </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" class="button btn btn-primary">Edit</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.user.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection