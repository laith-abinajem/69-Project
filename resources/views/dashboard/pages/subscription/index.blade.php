@extends('dashboard.layouts.master')

@section('title', 'Subscription')

@section('content')
<style> 

.visa-container {
  position: relative;
  background-size: cover;
  padding: 25px;
  border-radius: 28px;
  max-width: 380px;
  width: 100%;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
}
.visa-container header,
.visa-container .logo {
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.visa-container .logo img {
  width: 48px;
  margin-right: 10px;
}
.visa-container h5 {
  font-size: 16px;
  font-weight: 400;
  color: #fff;
}
.visa-container header .chip {
  width: 60px;
}
.visa-container h6 {
  color: #fff;
  font-size: 10px;
  font-weight: 400;
}
.visa-container h5.number {
  margin-top: 4px;
  font-size: 18px;
  letter-spacing: 1px;
}
.visa-container h5.name {
  margin-top: 20px;
}
.visa-container .card-details {
  margin-top: 40px;
  display: flex;
  justify-content: space-between;
  align-items: flex-end;
}
.visa-container{
    background-image: url('{{ asset('assets/img/pg.png') }}');
}
</style>

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
                                <div class="d-flex flex-wrap">
                                    <button type="button" class="button btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#managePlanModal">MANAGE PLAN</button>
                                    <!-- <form action="route" method="POST">
                                        <input type="hidden" name="customer_id" />
                                        <button type="submit" class="button btn btn-danger"></button>
                                    </form> -->
                                    @if($current_sub)

                                    <a type="button" class="button btn btn-danger float-right" data-bs-toggle="modal" data-bs-target="#deleteModal{{$current_sub->subscription_id}}">
                                        CANCEL SUBSCRIPTION
                                    </a>
                                    <div class="modal fade" id="deleteModal{{$current_sub->subscription_id}}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="deleteModalLabel{{$current_sub->subscription_id}}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Confirmation</h4>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="modal-body">
                                                        Are you sure you want to delete the subscription ? 
                                                    </div>
                                                    <form action="{{ route('dashboard.deleteSubscribtion', $current_sub->subscription_id) }}" method="POST" >
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
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
        <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Payment Method</h3>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <!-- add if user has card -->
                     
                         @if($card)
                        <div class="row">
                            <div class="col-lg-6 col-12">
                                <div class="my-3">
                                    <span class="font-weight-bold">Visa ending {{$card->last_4}}</span>
                                </div>
                                <div class="mb-3">
                                    <span>Expiration: {{$card->exp_month}} / {{$card->exp_year}}</span>
                                </div>
                                <div class="mb-3">
                                    <span>Card Brand: VISA</span>
                                </div>
                            </div>
                            <div class="col-lg-6 col-12">
                                <div class="visa-container" style="">
                                    <header>
                                        <span class="logo">
                                            <img src="{{ asset('assets/img/logo.png') }}" alt="" />
                                        </span>
                                        <img src="{{ asset('assets/img/chip.png') }}" alt="" class="chip" />
                                    </header>
                                    <div class="card-details">
                                        <div class="name-number">
                                            <h6>Card Number</h6>
                                            <h5 class="number">**** **** **** {{$card->last_4}}</h5>
                                            <h5 class="name">{{$card->cardholder_name}}</h5>
                                        </div>
                                        <div class="valid-date">
                                            <h6>Valid Thru</h6>
                                            <h5>{{$card->exp_month}} / {{$card->exp_year}}</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <!-- add else -->
                        <div id="form-container">
                            <div id="card-container"></div>
                            <button class="button btn btn-primary me-3" id="card-button">Save Card</button>
                        </div>
                        @endif
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
            <form id="subscription-form" action="{{ route('dashboard.subscription.update') }}" method="post">
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
                            <button  type="submit" class="button btn btn-primary">Change plan</button>
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
            <form id="subscription-form2" action="{{ route('dashboard.process-payment') }}" method="post">
                    @csrf
                    <div class="row row-sm">
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
                            @if(auth()->user()->type === 'super_admin')
                            <button id="trial-button2" type="submit" class="button btn btn-primary">Continue without payment</button>
                            @else
                            <button id="payment-button2" type="submit" class="button btn btn-primary">Continue to payment</button>
                            @endif
                            
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://sandbox.web.squarecdn.com/v1/square.js"></script>
<script>
    async function initializeSquarePayments() {
        const payments = Square.payments('sandbox-sq0idb-YUWObSyjVpaI6A4yV6iX9A', 'sandbox'); // or 'production'
        const card = await payments.card();
        await card.attach('#card-container');
        const customerId = @json(auth()->user()->square_customer_id);
        document.getElementById('card-button').addEventListener('click', async () => {
            const { token, error } = await card.tokenize();
            if (error) {
                console.error(error);
                return;
            }
            console.log(token)
            const response = await fetch('/processPayment', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                body: JSON.stringify({
                    nonce: token,
                    customer_id:customerId
                })
            });

            if (response.ok) {
                const cardData = await response.json();
                console.log('Card added:', cardData);
            } else {
                const errorData = await response.json();
                console.error('Error adding card:', errorData);
            }
        });
    }

    initializeSquarePayments();
</script>
<script>
    document.getElementById('payment-button').addEventListener('click', function() {
        document.getElementById('subscription-form').action = "{{ route('dashboard.process-payment') }}";
    });
    var trial_btn = document.getElementById('trial-button');
    if(trial_btn){
        trial_btn.addEventListener('click', function() {
            document.getElementById('subscription-form').action = "{{ route('dashboard.subscription.store') }}";
        });
    }
   
</script>
<script>
    document.getElementById('payment-button2').addEventListener('click', function() {
        document.getElementById('subscription-form2').action = "{{ route('dashboard.process-payment') }}";
    });
    var trial_btn2 = document.getElementById('trial-button2');
    if(trial_btn2){
        trial_btn2.addEventListener('click', function() {
            document.getElementById('subscription-form2').action = "{{ route('dashboard.subscription.store') }}";
        });
    }
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