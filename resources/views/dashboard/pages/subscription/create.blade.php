@extends('dashboard.layouts.master')

@section('title', 'Create Subscription')

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
                <h3 class="tile-title">{{ __('Create Subscription') }}</h3>
                <form action="{{ route('process-payment') }}" method="post">
                    @csrf
                    <div class="row row-sm">
                            <div class="col-6">
                                <div class="form-group mg-b-0">
                                    <label class="form-label">Name: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('name') }}" class="form-control" name="name" placeholder="Enter name" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Address: <span class="tx-danger">*</span></label>
                                    <input value="{{ old('address') }}" class="form-control" name="address" placeholder="Enter Address" required="" type="text">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">Subscription Type: <span class="tx-danger">*</span></label>
                                    <select name="type" id="sub_type" required class="form-control paintProtectionFil select2" >
                                        <option value="1">1 Months</option>
                                        <option selected value="3">3 Months</option>
                                        <option value="6">6 Months</option>
                                        <option value="12">1 Year</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-6">
                            <div class="form-group">
                                <label class="form-label">Amount:</label>
                                <input value="50" class="form-control" id="amount" name="amount" readonly type="text">
                            </div>
                        </div>
                        </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" class="button btn btn-primary">Continue to payment</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.subscription.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>

@endsection