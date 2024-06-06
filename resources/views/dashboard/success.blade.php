@extends('dashboard.layouts.master')

@section('title', 'Payment Successful')

@section('content')

<div class="row row-sm">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <div class="my-5">
                    <h1>Payment Successful</h1>
                    <p>Redirecting to dashboard in <span id="countdown">5</span> seconds...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let countdown = 5;

    function updateCountdown() {
        if (countdown === 0) {
            window.location.href = "{{ route('dashboard.home.index') }}";
        } else {
            document.getElementById('countdown').textContent = countdown;
            countdown--;
        }
    }

    window.onload = function() {
        updateCountdown();
        setInterval(updateCountdown, 1000);
    }
</script>

@endsection