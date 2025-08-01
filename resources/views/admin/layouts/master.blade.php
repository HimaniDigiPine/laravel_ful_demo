<!-- Start of Masterpage -->\
<!DOCTYPE html>
<html lang="en">

	<!-- Head Start -->
	<head>

		<base href=""/>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Demo of Laravel Full Example</title>

		<link rel="shortcut icon" href="{{ asset('admin-assets/images/logos/favicon.ico') }}" />

		<!--begin::Fonts(mandatory for all pages)-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<!--end::Fonts-->

		<!--begin::Vendor Stylesheets(used for this page only)-->
		<link href="{{ asset('admin-assets/plugins/custom/fullcalendar/fullcalendar.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin-assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Vendor Stylesheets-->

		<!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
		<link href="{{ asset('admin-assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('admin-assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Stylesheets Bundle-->

		<script>
		    // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
		    if (window.top !== window.self) {
		        window.top.location.replace(window.self.location.href);
		    }
		</script>
		

	</head>
	<!-- Head End -->

	<!-- Body Start -->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">


		<!--begin::App-->
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<!--begin::Page-->
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">

				<!-- Header Start -->
				@include('admin.partials.header');
				<!-- Header End -->

				<!-- Content Start -->

				<!--begin::Wrapper-->
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">

					<!-- Siderbar Start -->
					@include('admin.partials.sidebar')
					<!-- Sidebar End -->


					<!--begin::Main-->
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						

						<!--begin::Content wrapper-->
						<div class="d-flex flex-column flex-column-fluid">

							<!-- Content Start -->
							@yield('content')
							<!-- Content Start -->

					
							<!-- Script Start -->
				    		@yield('scripts')
							<!-- Script End -->

						</div>
						<!--end::Content wrapper-->

						<!-- Footer Start -->
						@include('admin.partials.footer')
						<!-- Footer End -->

					</div>
					<!--end:::Main-->

				</div>
				<!--end::Wrapper-->

				<!-- Content End -->


			</div>
			<!--end::Page-->
		</div>
		<!--end::App-->



		<!--begin::Theme mode setup on page load-->
		<script>
		    var defaultThemeMode = "light";
		    var themeMode;

		    if (document.documentElement) {
		        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
		            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
		        } else {
		            if (localStorage.getItem("data-bs-theme") !== null) {
		                themeMode = localStorage.getItem("data-bs-theme");
		            } else {
		                themeMode = defaultThemeMode;
		            }
		        }

		        if (themeMode === "system") {
		            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
		        }

		        document.documentElement.setAttribute("data-bs-theme", themeMode);
		    }
		</script>
		<!--end::Theme mode setup on page load-->



		<!--begin::Javascript-->
		<script>var hostUrl = "assets/";</script>

		<!--begin::Global Javascript Bundle(mandatory for all pages)-->
		<script src="{{ asset('admin-assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{ asset('admin-assets/js/scripts.bundle.js')}}"></script>
		<!--end::Global Javascript Bundle-->

		<!-- jQuery Validation -->
		<script>
		    if (typeof $ === 'undefined' && typeof jQuery !== 'undefined') {
		        window.$ = jQuery;
		    }
		</script>
		<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>

		<!-- Datatable -->
		<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

		<!--begin::Vendors Javascript(used for this page only)-->
		<script src="{{ asset('admin-assets/plugins/custom/fullcalendar/fullcalendar.bundle.js')}}"></script>
		<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/map.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/continentsLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/usaLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZonesLow.js"></script>
		<script src="https://cdn.amcharts.com/lib/5/geodata/worldTimeZoneAreasLow.js"></script>
		<script src="{{ asset('admin-assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
		<!--end::Vendors Javascript-->

		<!--begin::Custom Javascript(used for this page only)-->
		<script src="{{ asset('admin-assets/js/widgets.bundle.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/widgets.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/apps/chat/chat.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/utilities/modals/upgrade-plan.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/utilities/modals/create-app.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/utilities/modals/new-target.js') }}"></script>
		<script src="{{ asset('admin-assets/js/custom/utilities/modals/users-search.js') }}"></script>
		<!--end::Custom Javascript-->

		<!-- Page-specific scripts -->
		@stack('scripts')

	</body>
	<!-- Body End -->

</html>
<!-- End of Masterpage -->