<!DOCTYPE html> 
<html lang="en">
	

<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>BMI</title>
		
		<!-- Favicon -->
		<link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets') }}/assets/img/favicon.svg">

		<!-- Theme Settings Js -->
		<script src="{{ asset('frontend-assets') }}/assets/js/theme-script.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>
		
		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Owl Carousel CSS -->
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/owl.carousel.min.css">
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/owl.theme.default.min.css">
		
		<!-- Feathericon CSS -->
        <link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/plugins/feather/feather.css">

		<!-- Main CSS -->
		<link rel="stylesheet" href="{{ asset('frontend-assets') }}/assets/css/style.css">
	
	</head>
	<body>

		<!-- Main Wrapper -->
		<div class="main-wrapper log-wrap">
		
			<div class="row">
			
				<!-- Login Banner -->
				<div class="col-md-6 login-bg">
					<div class="owl-carousel login-slide owl-theme">
						<div class="welcome-login">
							<div class="login-banner">
								<img src="{{ asset('frontend-assets') }}/assets/img/login-img.png" class="img-fluid" alt="Logo">
							</div>
							<div class="mentor-course text-center">
								<h2>Welcome to <br>BMI Courses.</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
						<div class="welcome-login">
							<div class="login-banner">
								<img src="{{ asset('frontend-assets') }}/assets/img/login-img.png" class="img-fluid" alt="Logo">
							</div>
							<div class="mentor-course text-center">
								<h2>Welcome to <br>BMI Courses.</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
						<div class="welcome-login">
							<div class="login-banner">
								<img src="{{ asset('frontend-assets') }}/assets/img/login-img.png" class="img-fluid" alt="Logo">
							</div>
							<div class="mentor-course text-center">
								<h2>Welcome to <br>BMI Courses.</h2>
								<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
							</div>
						</div>
					</div>
				</div>
				<!-- /Login Banner -->
				
				<div class="col-md-6 login-wrap-bg">		
				
					<!-- Login -->
					<div class="login-wrapper">
						<div class="loginbox">
							<div class="img-logo">
								<img src="{{ asset('frontend-assets') }}/images/logo.png" class="img-fluid" alt="Logo">
								<div class="back-home">
									<a href="{{ route('home') }}">Back to Home</a>
								</div>
							</div>
							<h1>Sign up</h1>
							<form action="">
								<div class="input-block">
									<label class="form-control-label">Full Name</label>
									<input type="text" class="form-control" placeholder="Enter your Full Name">
								</div>
								<div class="input-block">
									<label class="form-control-label">Email</label>
									<input type="email" class="form-control" placeholder="Enter your email address">
								</div>
								<div class="input-block">
									<label class="form-control-label">Password</label>
									<div class="pass-group" id="passwordInput">																	
										<input type="password" class="form-control pass-input" placeholder="Enter your password">
										<span class="toggle-password feather-eye"></span>
										<span class="pass-checked"><i class="feather-check"></i></span>
									</div>
									<div  class="password-strength" id="passwordStrength">
										<span id="poor"></span>
										<span id="weak"></span>
										<span id="strong"></span>
										<span id="heavy"></span>
									</div>
									<div id="passwordInfo"></div>	
								</div>

								<div class="form-check remember-me">
									<label class="form-check-label mb-0">
									  <input class="form-check-input" type="checkbox" name="remember"> I agree to the <a href="term-condition.html">Terms of Service</a> and <a href="privacy-policy.html">Privacy Policy.</a>
									</label>
								</div>
								<div class="d-grid">
									<button class="btn btn-primary btn-start" type="submit">Create Account</button>
								</div>
							</form>
						</div>
						<div class="google-bg text-center">
							{{-- <span><a href="#">Or sign in with</a></span>
							<div class="sign-google">
								<ul>
									<li><a href="#"><img src="{{ asset('frontend-assets') }}/assets/img/net-icon-01.png" class="img-fluid" alt="Logo"> Sign In using Google</a></li>
									<li><a href="#"><img src="{{ asset('frontend-assets') }}/assets/img/net-icon-02.png" class="img-fluid" alt="Logo">Sign In using Facebook</a></li>
								</ul>
							</div> --}}
							<p class="mb-0">Already have an account? <a href="{{ route('login') }}">Sign in</a></p>
						</div>
					</div>
					<!-- /Login -->
					
				</div>
				
			</div>
		   
	   </div>
	   <!-- /Main Wrapper -->

		<!-- jQuery -->
		<script src="{{ asset('frontend-assets') }}/assets/js/jquery-3.7.1.min.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="{{ asset('frontend-assets') }}/assets/js/bootstrap.bundle.min.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>

		<!-- Owl Carousel -->
		<script src="{{ asset('frontend-assets') }}/assets/js/owl.carousel.min.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>	
		
		<!-- Validation-->
		<script src="{{ asset('frontend-assets') }}/assets/js/validation.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>	
		
		<!-- Custom JS -->
		<script src="{{ asset('frontend-assets') }}/assets/js/script.js" type="2456a14b71ac858c22d8f60f-text/javascript"></script>
		
			
	<script src="{{ asset('frontend-assets') }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="2456a14b71ac858c22d8f60f-|49" defer></script>

    <script>

        function showLoading() {
            $('#loadingOverlay').show();
        }
    
        // Hide loading spinner
        function hideLoading() {
            $('#loadingOverlay').hide();
        }
    
        $(document).ready(function () {
        // Submit the registration form
        $('#sign-up').on('submit', function (e) {
            e.preventDefault();
            showLoading(); // Show spinner when form is submitted
            let formData = $(this).serialize();
    
            $.ajax({
                url: '{{ route("sendVerificationCode") }}', // Update with the correct route
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    hideLoading(); // Hide spinner after response
                    if (response.success) {
                        toastr.success(response.message);
    
                        // Hide the registration form and show the verification code form
                        $('#sign-up').hide();
                        $('#emailCodeVerifyForm').val(response.email);
                        $('#verification-form').show();
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });
                    toastr.error(errorMessage);
                }
            });
        });
    
        // Submit the verification code form
        $('#verification-form').on('submit', function (e) {
            e.preventDefault();
    
            let formData = $(this).serialize();
    
            $.ajax({
                url: '{{ route("verifyCode") }}', // Update with the correct route
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
    
                        // Redirect to home after successful registration
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                },
                error: function (xhr) {
                    // Handle errors
                    let errorMessage = xhr.responseJSON.message || 'Verification failed.';
                    toastr.error(errorMessage);
                }
            });
        });
    });
    
    </script>
    
    <script>
        function showLoading() {
            $('#loadingOverlay').show();
        }
    
        // Hide loading spinner
        function hideLoading() {
            $('#loadingOverlay').hide();
        }
    
       $(document).ready(function () {
        $('#affsign-up').on('submit', function (e) {
            e.preventDefault();
            showLoading(); // Show spinner when form is submitted
            let formData = $(this).serialize();
    
            $.ajax({
                url: '{{ route("affiliateRegister") }}', // Affiliate registration route
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        hideLoading(); // Hide spinner after response
                        // Hide the registration form and show the verification form
                        $('#affsign-up').hide();
                        $('#verification-form-affi').show();
    
                        // Set the email value in the hidden input of the verification form
                        $('#email2affi').val(response.email);
    
                        // Show success notification using Toastr
                        toastr.success('A verification code has been sent to your email.', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "5000",
                            "progressBar": true,
                        });
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';
                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + '<br>';
                        });
                        toastr.error(errorMessage, 'Validation Error', {
                            "positionClass": "toast-top-right",
                            "timeOut": "5000",
                            "progressBar": true,
                        });
                    } else {
                        toastr.error('An unexpected error occurred.', '', {
                            "positionClass": "toast-top-right",
                            "backgroundClass": 'bg-danger',
                        });
                    }
                }
            });
        });
    
        // Handle verification form submission
        $('#verification-form-affi').on('submit', function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
    
            $.ajax({
                url: '{{ route("affiverifyCode") }}', // Verification route
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success('Verification successful! You are now registered as an affiliate.', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "5000",
                            "progressBar": true,
                        });
    
                        // Redirect or show a success message after successful verification
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000);
                    } else {
                        toastr.error('The verification code is incorrect.', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "5000",
                            "progressBar": true,
                        });
                    }
                },
                error: function () {
                    toastr.error('An unexpected error occurred during verification.', '', {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000",
                        "progressBar": true,
                    });
                }
            });
        });
    });
    </script>

</body>


</html>

