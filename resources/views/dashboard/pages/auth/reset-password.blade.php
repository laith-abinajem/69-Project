@extends('dashboard.layouts.auth')

@section('title', 'Login')

@section('content')

<link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">

<section class="custom-login-section page-template-template-login">
    <div class="container mt-5">
        <!-- Nav Tabs -->
        <ul class="nav-tabs-custom" id="signupTabs">
            <li class="tab-item active" data-tab="sign-in">Forgot Password!</li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Sign In Tab -->
            <div class="tab-pane active" id="sign-in">
                <div class="row cstm-row-align-center">
                    <div class="col-md-6">
                        <div class="sign-in-form">
                            <h4 class="login-primary-title">
                            Forgot Password!
                                <span class="tets">
                                    <img src="https://69simulator.com/wp-content/uploads/2024/09/69-simulator.png"
                                        alt="69 Simulator"  >
                                </span>
                            </h4>
                            <form action="{{ route('checkPassword') }}">
                                @csrf
								<div class="form-group">
                                    <label>New Password</label> <input class="form-control" name="password"  required placeholder="Enter your password" type="password">
                                </div>
                                <button class="btn btn-primary btn-block">Send</button>
							</form>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="sign-in-image">
                            <img src="https://69simulator.com/wp-content/uploads/2024/09/image-min.jpg"
                                alt="Simulator Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- <div class="page">
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
                        <form action="{{ route('checkPassword') }}">
                            <div class="form-group">
                                <label>New Password</label> <input class="form-control" name="password"  required placeholder="Enter your password" type="password">
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
</div> -->
@endsection