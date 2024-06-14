@extends('dashboard.layouts.master')

@section('title', 'Edit Package')

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
                <h3 class="tile-title">{{ __('Edit Package') }}</h3>
                <form action="{{ route('dashboard.package.update', $data->id) }}" id="userForm" method="post" enctype="multipart/form-data">
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
                                <label class="form-label">Price: <span class="tx-danger">*</span></label>
                                <input value="{{ $data->price }}" class="form-control" name="price" placeholder="Enter Price" required="" type="text">
                            </div>
                        </div>
                        <div class="form-group col-6">
                            <label class="form-label">interval<span class="tx-danger">*</span></label>
                            <select name="interval" id="interval" required class="form-control paintProtectionFil select2" >
                                <option value="WEEKLY">WEEKLY</option>
                                <option selected value="MONTHLY">Weekly Plan</option>
                                <option value="THREE_MONTHS">Monthly Plan</option>
                                <option value="SIX_MONTHS">Quarterly Plan</option>
                                <option value="ANNUAL">Annual Plan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" class="button btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.subscription.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection