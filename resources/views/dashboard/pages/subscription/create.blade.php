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
                <form id="subscription-form" action="{{ route('process-payment') }}" method="post">
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
                                    <select name="package_id" id="package_id" required class="form-control paintProtectionFil select2" >
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}">{{$package->name}} - {{$package->price}} $</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @if(auth()->user()->type === 'super_admin')
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="form-label">User<span class="tx-danger">*</span></label>
                                    <select name="user_id" id="user_id" required class="form-control paintProtectionFil select2" >
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}">{{$user->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @endif
                        </div>
                        <div class="form-group text-end mt-2">
                            <button id="payment-button" type="submit" class="button btn btn-primary">Continue to payment</button>
                            @if(auth()->user()->type === 'super_admin')
                            <button id="trial-button" type="submit" class="button btn btn-primary">Continue without payment (trial sub)</button>
                            @endif
                            <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.subscription.index') }}'">Cancel</button>
                        </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<script>
    document.getElementById('payment-button').addEventListener('click', function() {
        document.getElementById('subscription-form').action = "{{ route('process-payment') }}";
    });

    document.getElementById('trial-button').addEventListener('click', function() {
        document.getElementById('subscription-form').action = "{{ route('dashboard.subscription.store') }}";
    });
</script>
@endsection