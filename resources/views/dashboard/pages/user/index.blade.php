@extends('dashboard.layouts.master')

@section('title', 'Users')

@section('content')
<style>
 .status-select.pending {
        color: yellow;
    }
    .status-select.rejected {
        color: red;
    }
    .status-select.approved {
        color: green;
    }
</style>
    <div class="row row-sm">
        <div class="col-lg-12">
            <div class="card">
                @if(auth()->user()->type === "super_admin")
                <div class="card-header d-flex justify-content-between flex-wrap align-items-center">
                    <h3 class="card-title">Users Table</h3>
                    <button type="button" class="button btn btn-primary" onclick="window.location='{{ route('dashboard.user.create') }}'">Add User</button>
                </div>
                @endif

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example2" class="border-top-0  table table-bordered text-nowrap border-bottom">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">ID</th>
                                    <th class="border-bottom-0">Name</th>
                                    <th class="border-bottom-0">Email</th>
                                    @if(auth()->user()->type === "super_admin")
                                    <th class="border-bottom-0">Status</th>
                                    @endif
                                    <th class="border-bottom-0">Subscription type</th>
                                    <th class="border-bottom-0">Expiry at</th>
                                    <th class="border-bottom-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($data as $item)
                            @php
                                $last_active_subscription = $item->subscription
                                    ->where('end_date', '>', $today_date)
                                    ->sortByDesc('end_date')
                                    ->first();
                            @endphp
                                <tr>
                                    <td>{{$item->id}}</td>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    @if(auth()->user()->type === "super_admin")
                                    <td>
                                    <select class="form-control status-select {{ $item->status }}" onchange="updateStatus(this.value, {{ $item->id }}, this)">
                                        <option value="pending" style="color: yellow;" {{ $item->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="rejected" style="color: red;" {{ $item->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                        <option value="approved" style="color: green;" {{ $item->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    </select>
                                    </td>
                                    @endif
                                    <td>
                                    @if ($last_active_subscription)
                                        {{ $last_active_subscription->package_type }} <!-- or whatever property you want to display -->
                                    @else
                                        No active subscription
                                    @endif
                                    </td>
                                    <td> @if ($last_active_subscription)
                                        {{ $last_active_subscription->end_date }} <!-- or whatever property you want to display -->
                                    @else
                                        No active subscription
                                    @endif</td>
                                    <td>
                                        <a class="button btn btn-secondary" href="{{ route('dashboard.user.edit',$item->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if(auth()->user()->type === "super_admin")
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
                                                        <form action="{{ route('dashboard.user.delete', $item->id) }}" method="POST" >
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
    <script>

function updateStatus(status, itemId, element) {
        fetch('{{ route('dashboard.user.updateStatus') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                status: status,
                user_id: itemId // Corrected from userId to itemId
            })
        })
        .then(response => {
            if (response.ok) {
                console.log('Status updated successfully');
                // Update the select element's class based on the new status
                var selectElement = element;
                selectElement.classList.remove('pending', 'rejected', 'approved');
                selectElement.classList.add(status);

                // Update the inline style of the select element
                if (status === 'pending') {
                    selectElement.style.color = 'yellow';
                } else if (status === 'rejected') {
                    selectElement.style.color = 'red';
                } else if (status === 'approved') {
                    selectElement.style.color = 'green';
                }
            } else {
                console.error('Failed to update status');
            }
        })
        .catch(error => {
            // Handle network errors here
            console.error('Network error:', error);
        });
    }

    // Initial call to set the correct color based on the current status
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.status-select').forEach(function(selectElement) {
            var status = selectElement.value;
            selectElement.classList.add(status);

            // Set the initial color of the select element
            if (status === 'pending') {
                selectElement.style.color = 'yellow';
            } else if (status === 'rejected') {
                selectElement.style.color = 'red';
            } else if (status === 'approved') {
                selectElement.style.color = 'green';
            }
        });
    });
    </script>
@endsection