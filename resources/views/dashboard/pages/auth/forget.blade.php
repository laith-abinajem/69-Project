@extends('dashboard.layouts.auth')

@section('title', 'Login')

@section('content')
<div class="page">
    <div class="my-auto page page-h">
        <div class="main-signin-wrapper">
            <div class="main-card-signin d-md-flex">
                <div class="wd-md-50p login d-none d-md-block page-signin-style p-5 text-white" >
                    <div class="my-auto authentication-pages">
                        <div>
                            <img src="{{ asset('assets/img/light_logo-removebg-preview.png') }}" width="150px" class=" m-0 mb-4" alt="logo">
                            <h5 class="mb-4">Responsive Modern Dashboard &amp; Admin Template</h5>
                            <p class="mb-5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                            <a href="index.html" class="btn btn-success">Learn More</a>
                        </div>
                    </div>
                </div>
                <div class="p-5 wd-md-50p">
						<div class="main-signin-header">
							<h2>Forgot Password!</h2>
							<h4>Please Enter Your Email</h4>
							<form action="{{ route('check') }}">
								<div class="form-group">
									<label>Email</label> <input class="form-control" placeholder="Enter your email" type="text">
								</div>
								<button class="btn btn-primary btn-block">Send</button>
							</form>
						</div>
						<div class="main-signup-footer mg-t-10">
							<p>Forget it, <a href="{{route('login')}}"> Send me back</a> to the sign in screen.</p>
						</div>
					</div>
            </div>
        </div>
    </div>
</div>
@endsection