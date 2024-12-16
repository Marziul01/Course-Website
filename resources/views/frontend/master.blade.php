<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>BMI @yield('title') </title>

		

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets') }}/images/favicon.png">

	<!-- Theme Settings Js -->
	<script src="{{ asset('frontend-assets') }}/assets/js/theme-script.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/bootstrap.min.css">

	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/fontawesome/css/all.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css" integrity="sha512-dPXYcDub/aeb08c63jRq/k6GaKccl256JQy/AnOq7CAnEZ9FzSL9wSbcZkMp4R26vBsMLFYH4kQ67/bbV8XaCQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<!-- Owl Carousel CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/owl.carousel.min.css">
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/owl.theme.default.min.css">

	<!-- Feathericon CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/feather/feather.css">

	<!-- Slick CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/slick/slick.css">
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/slick/slick-theme.css">

	<!-- Select2 CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/select2/css/select2.min.css">

	<!-- Swiper CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/swiper/css/swiper.min.css">

	<!-- Aos CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/aos/aos.css">

	<!-- Main CSS -->
	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/style.css">

	<link rel="stylesheet" href="{{ asset('frontend-assets') }}/css/style.css">

</head>

<body class="home-three">

	<!-- Main Wrapper -->
	<div class="main-wrapper">

		<!-- Header -->
		@include('frontend.include.header')
		<!-- Header -->

		@yield('content')

		<!-- Footer -->
		@include('frontend.include.footer')
		<!-- Footer -->

	</div>
	<!-- Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('frontend-assets') }}/assets/js/jquery-3.7.1.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/bootstrap.bundle.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Owl Carousel JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/owl.carousel.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Aos -->
	<script src="{{ asset('frontend-assets') }}/assets/plugins/aos/aos.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- counterup JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/jquery.waypoints.js" type="995ab6f03ab913613ced1001-text/javascript"></script>
	<script src="{{ asset('frontend-assets') }}/assets/js/jquery.counterup.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Select2 JS -->
	<script src="{{ asset('frontend-assets') }}/assets/plugins/select2/js/select2.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Slick Slider -->
	<script src="{{ asset('frontend-assets') }}/assets/plugins/slick/slick.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Swiper Slider -->
	<script src="{{ asset('frontend-assets') }}/assets/plugins/swiper/js/swiper.min.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/script.js" type="995ab6f03ab913613ced1001-text/javascript"></script>

	<script src="{{ asset('frontend-assets') }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="995ab6f03ab913613ced1001-|49" defer></script>
	
	@yield('customJs')

</body>

</html>