@extends('dashboard.layouts.master')

@section('title', 'Subscription')

@section('content')


<div class="row row-sm">
    @if(auth()->user()->type !== 'super_admin' )
        <div class="col-lg-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Current Plan</h3>
                </div>
                <div class="card-body">
                    <div class="mb-2">
                        <span class="font-weight-bold">{{$current_sub->package_type ?? 'You dont have any active subscriptions'}}</span> 
                    </div>
                    <div class="my-4">
                        <div class="fs-1">{{$current_sub->price ?? 0}} $</div>
                    </div>
                    <div class="mb-3">
                        You will be charged for ${{$current_sub->price ?? 0}} on {{$current_sub->end_date ?? 0}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 pb-3">
            <div class="card h-100">
                <div class="card-header">
                    <h3 class="card-title">Usage</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="row">
                        <div class="col-8">
                            <p>Money Spent</p>
                            @php
                                $totalMoney = 2000;
                                $moneySpent = $price; 
                                $moneyLeft = $totalMoney - $moneySpent;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $moneySpent }}"
                                    aria-valuemin="0" aria-valuemax="{{ $totalMoney }}" style="width:{{ ($moneySpent / $totalMoney) * 100 }}%">
                                    ${{ $moneySpent }} 
                                </div>
                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{ $moneyLeft }}"
                                    aria-valuemin="0" aria-valuemax="{{ $totalMoney }}" style="width:{{ ($moneyLeft / $totalMoney) * 100 }}%">
                                </div>
                            </div>
                        </div>
                        <div class="col-8 mt-2">
                        <p>Subscribtion times</p>
                            @php
                                $totalMoney = 10;
                                $moneySpent = $count; 
                                $moneyLeft = $totalMoney - $moneySpent;
                            @endphp
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar" aria-valuenow="{{ $moneySpent }}"
                                    aria-valuemin="0" aria-valuemax="{{ $totalMoney }}" style="width:{{ ($moneySpent / $totalMoney) * 100 }}%">
                                    ${{ $moneySpent }} 
                                </div>
                                <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="{{ $moneyLeft }}"
                                    aria-valuemin="0" aria-valuemax="{{ $totalMoney }}" style="width:{{ ($moneyLeft / $totalMoney) * 100 }}%">
                                </div>
                            </div>
                        </div>
                            <div class="col-12 mt-4">
                                <button type="button" class="button btn btn-primary" data-bs-toggle="modal" data-bs-target="#managePlanModal">MANAGE PLAN</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <div class="col-lg-12">
        <div class="card">
        @if(auth()->user()->type === 'super_admin')
            <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">Table Subscription</h3>
                <button type="button" class="button btn btn-primary" data-bs-toggle="modal" data-bs-target="#managePlanModal2">Add Subscription</button>
            </div>
        @else
        <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                <h3 class="card-title">History Subscription</h3>
            </div>
        @endif

            <div class="card-body">
                <div class="table-responsive">
                    <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">ID</th>
                                <th class="border-bottom-0">Subscription Type</th>
                                <th class="border-bottom-0">Expiry date</th>
                                @if(auth()->user()->type === 'super_admin')
                                <th class="border-bottom-0">User</th>
                                <th class="border-bottom-0">Action</th>
                                @else
                                <th class="border-bottom-0">Price</th>
                                @endif

                            </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>
                                    @if($item->package_type === 'trial')
                                        {{$item->package_type}} 7 Days
                                    @else
                                        {{$item->package_type}} Months
                                    @endif
                                
                                </td>
                                <td>{{$item->end_date}}</td>
                               
                                @if(auth()->user()->type === 'super_admin')
                                <td>{{$item->user->name}}</td>
                                @else
                                <td>{{$item->price}}</td>
                                @endif
                                @if(auth()->user()->type === 'super_admin')
                                <td>
                                        <a class="button btn btn-secondary" data-bs-toggle="modal" data-bs-target="#managePlanModal" data-user-id="{{$item->id}}">
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
                                                        <form action="{{ route('dashboard.subscription.delete', $item->id) }}" method="POST" >
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
                                    @endif
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="managePlanModal" tabindex="-1" aria-labelledby="managePlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="managePlanModalLabel">Manage Plan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="subscription-form" action="{{ route('process-payment') }}" method="post">
                    @csrf
                    <div class="row row-sm">
                        @php
                            $today = \Carbon\Carbon::now()->toDateString();
                        @endphp
                        <input type="hidden" id="userIdInput" name="user_id" value="">
                            @if(auth()->user()->subscription && auth()->user()->subscription->where('end_date', '>', $today)->count() > 0)
                                <div class="col-4  mt-2">
                                    <div class="form-group mg-b-0">
                                        <label class="form-label">Previous subscription </label>
                                        <input value="{{ $current_sub->package_type }}" class="form-control" readonly name="name" placeholder="Enter name" required="" type="text">
                                    </div>
                                </div>
                                <div class="col-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-label">Start date: </label>
                                        <input value="{{ $current_sub->start_date }}" class="form-control" readonly placeholder="Enter Address" required="" type="text">
                                    </div>
                                </div>
                                <div class="col-4  mt-2">
                                    <div class="form-group">
                                        <label class="form-label">End date: </label>
                                        <input value="{{ $current_sub->end_date }}" class="form-control"  readonly placeholder="Enter Address" required="" type="text">
                                    </div>
                                </div>
                            @else
                                <div class="col-12">
                                    <span> Note: Your Subscription is expierd   </span>
                                </div>
                            @endif
                            <div class="col-12">
                                <span> </span>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="form-label">Subscription Type ( To upgrade plan : please select Subscription Type) : <span class="tx-danger">*</span></label>
                                    <select name="package_id" id="package_id" required class="form-control paintProtectionFil select2" >
                                        @foreach($packages as $package)
                                            <option value="{{$package->id}}">{{$package->name}} - {{$package->price}} $</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-end mt-2">
                            <button id="payment-button" type="submit" class="button btn btn-primary">Continue to payment</button>
                            @if(auth()->user()->type === 'super_admin')
                            <button id="trial-button" type="submit" class="button btn btn-primary">Continue without payment (trial sub)</button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="managePlanModal2" tabindex="-1" aria-labelledby="managePlanModalLabel2" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="managePlanModalLabel2">Add subscribtion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="subscription-form2" action="{{ route('process-payment') }}" method="post">
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
                            <button id="payment-button2" type="submit" class="button btn btn-primary">Continue to payment</button>
                            @if(auth()->user()->type === 'super_admin')
                            <button id="trial-button2" type="submit" class="button btn btn-primary">Continue without payment (trial sub)</button>
                            @endif
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('payment-button').addEventListener('click', function() {
        document.getElementById('subscription-form').action = "{{ route('process-payment') }}";
    });

    document.getElementById('trial-button').addEventListener('click', function() {
        document.getElementById('subscription-form').action = "{{ route('dashboard.subscription.store') }}";
    });
</script>
<script>
    document.getElementById('payment-button2').addEventListener('click', function() {
        document.getElementById('subscription-form2').action = "{{ route('process-payment') }}";
    });

    document.getElementById('trial-button2').addEventListener('click', function() {
        document.getElementById('subscription-form2').action = "{{ route('dashboard.subscription.store') }}";
    });

    document.addEventListener('DOMContentLoaded', function() {
    var managePlanModal = document.getElementById('managePlanModal');

    managePlanModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget; // Button that triggered the modal
        var userId = button.getAttribute('data-user-id'); // Extract user ID from data-* attribute
        var userIdInput = managePlanModal.querySelector('#userIdInput');
        
        // Update the value of the hidden input field
        userIdInput.value = userId;
    });

    // Other scripts for handling form submission or status update
});
</script>
@endsection