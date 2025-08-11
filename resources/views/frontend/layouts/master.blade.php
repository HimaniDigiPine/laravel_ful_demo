<!-- Start of Master Page -->
<!doctype html>
<html class="no-js" lang="zxx">
	
	<!-- Head Stat -->
	<head>
	   <meta charset="utf-8">
	   <meta http-equiv="x-ua-compatible" content="ie=edge">
	   <title>Addina - Multipurpose eCommerce HTML Template

	   </title>
	   <meta name="description" content="">
	   <meta name="viewport" content="width=device-width, initial-scale=1">

	   <!-- Place favicon.ico in the root directory -->
	   <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets/imgs/grocery/favicon.png')}}">

	   <!-- CSS here -->
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/bootstrap.min.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/meanmenu.min.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/animate.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/swiper.min.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/slick.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/magnific-popup.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/fontawesome-pro.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/spacing.css')}}">
	   <link rel="stylesheet" href="{{ asset('frontend-assets/css/grocery.css')}}">
	</head>
	<!-- Head End -->

	<body class="hey-grocery">

		<!-- preloader start -->
	   <!--<div id="preloader">
	      <div class="bd-loader-inner">
	         <div class="bd-loader">
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	            <span class="bd-loader-item"></span>
	         </div>
	      </div>
	   </div> -->
	   <!-- preloader start -->

	   <!-- Back to top start -->
	   <div class="backtotop-wrap cursor-pointer">
	      <svg class="backtotop-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
	         <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
	      </svg>
	   </div>
	   <!-- Back to top end -->

	   	<!-- Header Start -->
		@include('frontend.partials.header');
		<!-- Header End -->

		<!-- Content Start -->
		@yield('content')
		<!-- Content Start -->

		<!-- Header Start -->
		@include('frontend.partials.footer');
		<!-- Header End -->
		


		<!-- JS here -->
	   <script src="{{ asset('frontend-assets/js/jquery-3.6.0.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/waypoints.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/bootstrap.bundle.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/meanmenu.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/swiper.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/slick.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/magnific-popup.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/counterup.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/wow.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/ajax-form.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/beforeafter.jquery-1.0.0.min.js')}}"></script>
	   <script src="{{ asset('frontend-assets/js/main.js')}}"></script>
	   <!-- JS here -->

	   <!-- Page-specific scripts -->
		@stack('scripts')



	</body>


</html>
<!-- End of Master Page -->