
<!DOCTYPE html>
<html lang="en" data-theme-mode="dark" data-header-styles="gradient" data-menu-styles="dark">
	<head>

		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="Description" content="Bootstrap Responsive Admin Web Dashboard HTML5 Template">
		<meta name="Author" content="Spruko Technologies Private Limited">
		<meta name="Keywords" content="admin,admin dashboard,admin dashboard template,admin panel template,admin template,admin theme,bootstrap 4 admin template,bootstrap 4 dashboard,bootstrap admin,bootstrap admin dashboard,bootstrap admin panel,bootstrap admin template,bootstrap admin theme,bootstrap dashboard,bootstrap form template,bootstrap panel,bootstrap ui kit,dashboard bootstrap 4,dashboard design,dashboard html,dashboard template,dashboard ui kit,envato templates,flat ui,html,html and css templates,html dashboard template,html5,jquery html,premium,premium quality,sidebar bootstrap 4,template admin bootstrap 4"/>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<!-- Title -->
		<title>@yield('title', 'Default Title')</title>

		<!--- Favicon --->
		<link rel="icon" href="{{ asset('assets/img/light_logo-removebg-preview.png') }}" type="image/x-icon"/>

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

        @include('dashboard.partials.header')

		@include('sweetalert::alert')

		<div class="main-content app-content">
			<div class="main-container container-fluid">
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div>
						<h4 class="content-title mb-2">@yield('title', 'Default Title')</h4>
						<nav aria-label="breadcrumb">
							<ol class="breadcrumb">
								<li class="breadcrumb-item"><a   href="javascript:void(0);">Dashboard</a></li>
								<li class="breadcrumb-item active" aria-current="page">Project</li>
							</ol>
						</nav>
					</div>
					@canany(['edit user', 'delete user', 'view user'])
					<div class="d-flex my-auto">
						<!-- <div class=" d-flex right-page">
							<div class="d-flex justify-content-center me-5">
								<div class="">
									<span class="d-block">
										<span class="label ">EXPENSES</span>
									</span>
									<span class="value">
										$53,000
									</span>
								</div>
								<div class="ms-3 mt-2">
									<span class="sparkline_bar"></span>
								</div>
							</div>
							<div class="d-flex justify-content-center">
								<div class="">
									<span class="d-block">
										<span class="label">PROFIT</span>
									</span>
									<span class="value">
										$34,000
									</span>
								</div>
								<div class="ms-3 mt-2">
									<span class="sparkline_bar31"></span>
								</div>
							</div>
						</div> -->
					</div>
					@endcanany
				</div>
				<!-- /breadcrumb -->
				@yield('content')
			</div>
		</div>

        @include('dashboard.partials.footer')

		<!--- JQuery min js --->
		<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>

		<!--- Datepicker js --->
		<script src="{{ asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>

		<!--- Bootstrap Bundle js --->
		<script src="{{ asset('assets/plugins/bootstrap/popper.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

		<!-- Select2 js-->
		<script src="{{ asset('assets/plugins/select2/js/select2.min.js') }}"></script>
		<script src="{{ asset('assets/js/select2.js') }}"></script>

		<!--- Ionicons js --->
		<script src="{{ asset('assets/plugins/ionicons/ionicons.js') }}"></script>

		<!--- Chart bundle min js --->
		<script src="{{ asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

		<!--- JQuery sparkline js --->
		<script src="{{ asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js') }}"></script>

		<!--- Internal Sampledata js --->
		<script src="{{ asset('assets/js/chart.flot.sampledata.js') }}"></script>

		<!-- jQuery Peity js -->
		<script src="{{ asset('assets/plugins/peity/jquery.peity.min.js') }}"></script>

		<!-- Peity js -->
		<script src="{{ asset('assets/js/chart.peity.js') }}"></script>

		<!--- Eva-icons js --->
		<script src="{{ asset('assets/js/eva-icons.min.js') }}"></script>

		<!--- Moment js --->
		<script src="{{ asset('assets/plugins/moment/moment.js') }}"></script>

		<!--- Perfect-scrollbar js --->
		<script src="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/perfect-scrollbar/p-scroll.js') }}"></script>

		<!--- Sidebar js --->
		<script src="{{ asset('assets/plugins/side-menu/sidemenu.js') }}"></script>

		<!--- sticky js --->
		<script src="{{ asset('assets/js/sticky.js') }}"></script>

		<!-- right-sidebar js -->
		<script src="{{ asset('assets/plugins/sidebar/sidebar.js') }}"></script>
		<script src="{{ asset('assets/plugins/sidebar/sidebar-custom.js') }}"></script>

		<!-- Morris js -->
		<script src="{{ asset('assets/plugins/raphael/raphael.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/morris.js/morris.min.js') }}"></script>

		<!--- Internal Jquery.steps js --->
		<script src="{{ asset('assets/plugins/jquery-steps/jquery.steps.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>

		<!--- Internal Form-wizard js --->
		<script src="{{ asset('assets/js/form-wizard.js') }}"></script>

		<!--- Fileuploads js --->
		<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
        <script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>

		<!--- Fancy uploader js --->
		<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
        <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
        <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
        <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
        <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>

		<!--- Internal Accordion Js -->
		<script src="{{ asset('assets/plugins/accordion/accordion.min.js') }}"></script>
		<script src="{{ asset('assets/js/accordion.js') }}"></script>

		<!--- Scripts js --->
		<script src="{{ asset('assets/js/script.js') }}"></script>

		<!--- Index js --->
		<script src="{{ asset('assets/js/index.js') }}"></script>

		<!--themecolor js-->
		<script src="{{ asset('assets/js/themecolor.js') }}"></script>

		<!--swither-styles js-->
		<script src="{{ asset('assets/js/swither-styles.js') }}"></script>

		<!--- Custom js --->
		<script src="{{ asset('assets/js/custom.js') }}"></script>

		<script src="{{ asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.bootstrap5.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/buttons.bootstrap5.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/pdfmake/pdfmake.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/pdfmake/vfs_fonts.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('assets/plugins/datatable/responsive.bootstrap5.min.js') }}"></script>
		<script src="{{ asset('assets/js/table-data.js') }}"></script>

		<!-- Example for including SweetAlert scripts -->
		<script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
		<!-- Optionally, include the Swal styles -->
		<!-- <link rel="stylesheet" href="{{ asset('vendor/sweetalert/sweetalert.css') }}"> -->

		<script type="text/javascript">
			
			$(document).ready(function(){
				var front_ws;
				var front_two;
				var back_half;
				var moonroof;
				var full_car;
				$(document).on('click', '.copy', function(){
					var parentElement = $(this).closest('.prices_container');
					front_ws = parentElement.find('.front-w-s').val();
					front_two = parentElement.find('.front-two').val();
					back_half = parentElement.find('.back-half').val();
					moonroof = parentElement.find('.moonroof').val();
					full_car = parentElement.find('.full-car').val();
					$('.paste').show();
				});
				$(document).on('click', '.paste', function(){
					var parentElement = $(this).closest('.prices_container');
					parentElement.find('.front-w-s').val(front_ws);
					parentElement.find('.front-two').val(front_two);
					parentElement.find('.back-half').val(back_half);
					parentElement.find('.moonroof').val(moonroof);
					parentElement.find('.full-car').val(full_car);
				})
				$(document).on('click', '.wizard .actions a[href="#finish"]', function(e){
					e.preventDefault();
					
					// Check if all required fields are filled
					if(validateForm()) {
						$('#tintform').submit();
					} else {
						alert('Please fill out all required fields.');
					}
				});

				function validateForm() {
					var isValid = true;
					
					// Check each required field
					$('#tintform input[required], #tintform textarea[required], #tintform select[required]').each(function(){
						if($(this).val() == '') {
							isValid = false;
							return false; // exit loop if a required field is empty
						}
					});

				return isValid;
				}
			
			})
		</script>


	</body>
</html>