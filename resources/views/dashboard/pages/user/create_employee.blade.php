@extends('dashboard.layouts.master')

@section('title', 'Create User')

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
                <h3 class="tile-title">{{ __('Create User') }}</h3>
                <div class="row row-sm">
                    <div class="col-12">
                        <h5>Adding a new employee will cost you $10 per month. The amount will be deducted directly from your card </h5>
                        <input type="checkbox" id="approveCost" name="approveCost">
                        <label for="approveCost">I approve</label>
                    </div>
                </div>
                <form action="{{ route('dashboard.user.storeEmployee') }}" method="post" id="userForm" enctype="multipart/form-data" style="display:none;">
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
                                <label class="form-label">Email: <span class="tx-danger">*</span></label>
                                <input value="{{ old('email') }}" class="form-control" name="email" placeholder="Enter Email" required="" type="email">
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group position-relative">
                                <label class="form-label">Password: <span class="tx-danger">*</span></label>
                                <input value="{{ old('password') }}" id="password" class="form-control" name="password" placeholder="Enter password" required="" type="password">
                                <i class="bi bi-eye-slash position-absolute" id="togglePassword" onclick="showPassword()"></i>
                            </div>
                        </div>
                    </div>
                    <div class="form-group text-end mt-2">
                        <button type="submit" id="submit" class="button btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" onclick="window.location='{{ route('dashboard.user.index') }}'">Cancel</button>
                    </div>
                </form>
            </div> <!-- end card-body -->
        </div> <!-- end card-->
    </div> <!-- end col -->
</div>
<script>
    document.getElementById('approveCost').addEventListener('change', function() {
        var form = document.getElementById('userForm');
        if (this.checked) {
            form.style.display = 'block';
        } else {
            form.style.display = 'none';
        }
    });

    function showPassword() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

@endsection
