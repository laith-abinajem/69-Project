<!-- main-header -->
<div class="main-header side-header sticky nav nav-item">
    <div class="container-fluid main-container ">
        <button class="navbar-toggler nav-link icon navresponsive-toggler vertical-icon ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent-4" aria-controls="navbarSupportedContent-4" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fe fe-more-vertical header-icons navbar-toggler-icon"></i>
        </button>
        <div class="mb-0 navbar navbar-expand-lg navbar-nav-right responsive-navbar navbar-dark p-0  mg-lg-s-auto">
            <div class="collapse navbar-collapse" id="navbarSupportedContent-4">
                <div class="main-header-right">
                    
                    <li class="dropdown nav-item main-layout">
                        <a class="new theme-layout nav-link-bg layout-setting" >
                            <span class="dark-layout"><i class="fe fe-moon"></i></span>
                            <span class="light-layout"><i class="fe fe-sun"></i></span>
                        </a>
                    </li>
                    <div class="nav nav-item  navbar-nav-right mg-lg-s-auto">
                        <div class="nav-item full-screen fullscreen-button">
                            <a class="new nav-link full-screen-link"   href="javascript:void(0);"><i class="fe fe-maximize"></i></span></a>
                        </div>
                        <div class="dropdown main-profile-menu nav nav-item nav-link">
                            <a class="profile-user d-flex" href=""><img src="{{ asset('assets/img/light_logo-removebg-preview.png') }}" alt="user-img" class="rounded-circle mCS_img_loaded"><span></span></a>

                            <div class="dropdown-menu">
                                <div class="main-header-profile header-img">
                                    <h6>{{auth()->user()->name}}</h6>
                                </div>
                                <a class="dropdown-item" href="{{ route('dashboard.user.edit',auth()->user()->id) }}"><i class="far fa-user"></i> My Profile</a>
                                <a href="{{ route('dashboard.logout') }}" class="dropdown-item">
                                <i class="fas fa-sign-out-alt"></i>
                                    <span>Logout</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /main-header -->

<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
<div class="sticky">
    <aside class="app-sidebar sidebar-scroll">
        <div class="main-sidemenu">
            <div class="main-sidebar-loggedin">
                <div class="app-sidebar__user">
                    <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                            <img src="{{ asset('assets/img/light_logo-removebg-preview.png') }}" alt="user-img" class="rounded-circle mCS_img_loaded">
                        </div>
                        <div class="user-info">
                            <h6 class=" mb-0 text-dark">{{auth()->user()->name}}</h6>
                            <span class="text-muted app-sidebar__user-name text-sm">{{auth()->user()->type}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="sidebar-navs">
                <ul class="nav  nav-pills-circle">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="Logout">
                      
                    </li>
                </ul>
            </div>
            <ul class="side-menu ">
                @canany(['edit user', 'delete user', 'view user'])
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.home.index') }}" ><i class="side-menu__icon fe fe-airplay"></i><span class="side-menu__label">Dashboard</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-briefcase "></i><span class="side-menu__label">Services</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Services</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.tint.filter') }}">Tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.light.filter') }}">Light tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.ppf.filter') }}">Ppf</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.detailing.filter') }}">Detailing</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.addons.filter') }}">Add-ons</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.subscription.index') }} "><i class="side-menu__icon fe fe-dollar-sign "></i><span class="side-menu__label">Subscription</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('dashboard.package.index') }} "><i class="side-menu__icon fe fe-package "></i><span class="side-menu__label">Package</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.user.index') }}"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Users</span></a>
                </li>
                @endcanany
                @canany(['owne tint brand'])
                @php
                    $today = \Carbon\Carbon::now()->toDateString();
                @endphp
               
                @if(auth()->user()->subscription && auth()->user()->subscription->where('end_date', '>', $today)->count() > 0)
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-briefcase "></i><span class="side-menu__label">Services</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Services</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.tint.index') }}">Tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.light.index') }}">Light tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.ppf.index') }}">Ppf</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.detailing.index') }}">Detailing</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.addons.index') }}">Add-ons</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.user.index') }}"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Accounts</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.invoices.index') }}"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">Work orders</span></a>
                </li>
                @endif
                <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.subscription.index') }} "><i class="side-menu__icon fe fe-dollar-sign "></i><span class="side-menu__label">Plan & Billing</span></a>
                </li>
                @endcanany

                @canany(['employee'])
                @php
                    $today = \Carbon\Carbon::now()->toDateString();
                    $id = auth()->user()->id;
                @endphp
               
                @if(auth()->user()->subscription && auth()->user()->subscription->where('end_date', '>', $today)->count() > 0)
                <!-- <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.user.edit',$id) }}"><i class="side-menu__icon fe fe-user"></i><span class="side-menu__label">My account</span></a>
                </li> -->
                <li class="slide">
                    <a class="side-menu__item" data-bs-toggle="slide"   href="javascript:void(0);"><i class="side-menu__icon fe fe-briefcase"></i><span class="side-menu__label">Services</span><i class="angle fe fe-chevron-down"></i></a>
                    <ul class="slide-menu">
                        <li class="side-menu__label1"><a href="javascript:void(0);">Services</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.tint.index') }}">Tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.light.index') }}">Light tint</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.ppf.index') }}">Ppf</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.detailing.index') }}">Detailing</a></li>
                        <li><a class="slide-item" href="{{ route('dashboard.addons.index') }}">Add-ons</a></li>
                    </ul>
                </li>
                @endif
                <!-- <li class="slide">
                    <a class="side-menu__item" href="{{ route('dashboard.subscription.index') }} "><i class="side-menu__icon fe fe-dollar-sign "></i><span class="side-menu__label">Plan & Billing</span></a>
                </li> -->
                @endcanany
                <li class="slide">
                    <a class="side-menu__item"  href="{{ route('dashboard.game') }}"><i class="side-menu__icon fe fe-play "></i><span class="side-menu__label">Game</span></a>
                </li>
            </ul>

        </div>
    </aside>
</div>
<!-- main-sidebar -->