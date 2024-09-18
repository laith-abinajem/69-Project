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
                            <form action="{{ route('SendCode') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label> <input class="form-control" name="email"  required placeholder="Enter your email" type="text">
                            </div>
                            @if($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
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

@endsection