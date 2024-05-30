<!DOCTYPE html>
<html lang="en">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>

		<!-- Title -->
		<title>@yield('title', 'Default Title')</title>

		<!--- Favicon --->
		<link rel="icon" href="{{ asset('assets/img/brand/favicon.png') }}" type="image/x-icon"/>

		<!-- Bootstrap css -->
		<link href="{{ asset('assets/plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet" id="style"/>

		<!--- Icons css --->
		<link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet">

		<!--- Style css --->
		<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
		<link href="{{ asset('assets/css/plugins.css') }}" rel="stylesheet">

		<!--- Animations css --->
		<link href="{{ asset('assets/css/animate.css') }}" rel="stylesheet">

	</head>
	<body class="main-body bg-light  login-img">

		<!-- Loader -->
		<div id="global-loader">
			<img src="{{ asset('assets/img/loaders/loader-4.svg') }}" class="loader-img" alt="Loader">
		</div>
		<!-- /Loader -->
        
		<div>
            @yield('content')
        </div>

		<!--- JQuery min js --->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

		<!--- Bootstrap Bundle js --->
		<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!--- Ionicons js --->
		<script src="{{ asset('assets/plugins/ionicons/ionicons.js') }}"></script>

		<!--- Moment js --->
		<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

		<!--- Eva-icons js --->
		<script src="{{ asset('assets/js/eva-icons.min.js') }}"></script>

		<!--themecolor js-->
		<script src="{{ asset('assets/js/themecolor.js') }}"></script>

		<!--- Custom js --->
		<script src="{{ asset('assets/js/custom.js') }}"></script>

	</body>
</html>