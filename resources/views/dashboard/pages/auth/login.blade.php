@extends('dashboard.layouts.auth')

@section('title', 'Login')

@section('content')
<link href="{{ asset('assets/css/login.css') }}" rel="stylesheet">

<section class="custom-login-section page-template-template-login">
    <div class="container mt-5">
        <!-- Nav Tabs -->
        <ul class="nav-tabs-custom" id="signupTabs">
            <li class="tab-item active" data-tab="sign-in">Sign In</li>
        </ul>
        <!-- Tab Content -->
        <div class="tab-content">
            <!-- Sign In Tab -->
            <div class="tab-pane active" id="sign-in">
                <div class="row cstm-row-align-center">
                    <div class="col-md-6">
                        <div class="sign-in-form">
                            <h4 class="login-primary-title">
                                Sign in to
                                <span class="tets">
                                    <img src="https://69simulator.com/wp-content/uploads/2024/09/69-simulator.png"
                                        alt="69 Simulator"  >
                                </span>
                            </h4>
                            <form method="POST" action="{{ route('submitLogin') }}">
                            @csrf
                                <div class="field-wrapper">
                                    <label for="email">Email</label>
                                    <input type="text" id="email" name="email" class="field" placeholder="Enter email">
                                </div>
                                <div class="field-wrapper">
                                    <label for="password">Password</label>
                                    <input type="password" name="password" id="password" class="field"
                                        placeholder="Enter password">
                                </div>
                                <div class="field-wrapper">
                                    <a href="{{ route('forget-password') }}" class="forgot-password">Forgot password?</a>
                                </div>
                                <div class="submit-btn-wrapper">
                                    <input type="hidden" name="action" value="custom_login">
                                    <input type="submit" class="submit-btn" value="Sign in">
                                </div>
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
@endsection
