<!DOCTYPE html>
<html lang="en">



<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
	<title>BMI</title>

	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend-assets') }}/assets/img/favicon.svg">

	<!-- Theme Settings Js -->
	<script src="{{ asset('frontend-assets') }}/assets/js/theme-script.js" type="07d21cd6c819100cabba68e1-text/javascript"></script>

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
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="welcome-login">
						<div class="login-banner">
							<img src="{{ asset('frontend-assets') }}/assets/img/login-img.png" class="img-fluid" alt="Logo">
						</div>
						<div class="mentor-course text-center">
							<h2>Welcome to <br>BMI Courses.</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
					<div class="welcome-login">
						<div class="login-banner">
							<img src="{{ asset('frontend-assets') }}/assets/img/login-img.png" class="img-fluid" alt="Logo">
						</div>
						<div class="mentor-course text-center">
							<h2>Welcome to <br>BMI Courses.</h2>
							<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt
								ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
						</div>
					</div>
				</div>
			</div>
			<!-- /Login Banner -->

			<div class="col-md-6 login-wrap-bg">

				<!-- Login -->
				<div class="login-wrapper">
					<div class="loginbox">
						<div class="w-100">
							<div class="img-logo">
								<img src="{{ asset('frontend-assets') }}/images/logo.png" class="img-fluid" alt="Logo">
								<div class="back-home">
									<a href="{{ route('home') }}">Back to Home</a>
								</div>
							</div>
							<h1>Sign into Your Account</h1>
							<form action="">
								<div class="input-block">
									<label class="form-control-label">Email</label>
									<input type="email" class="form-control" placeholder="Enter your email address">
								</div>
								<div class="input-block">
									<label class="form-control-label">Password</label>
									<div class="pass-group">
										<input type="password" class="form-control pass-input"
											placeholder="Enter your password">
										<span class="feather-eye toggle-password"></span>
									</div>
								</div>
								<div class="forgot">
									<span><a class="forgot-link" href="forgot-password.html">Forgot Password
											?</a></span>
								</div>
								<div class="remember-me">
									<label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Remember me
										<input type="checkbox" name="radio">
										<span class="checkmark"></span>
									</label>
								</div>
								<div class="d-grid">
									<button class="btn btn-primary btn-start" type="submit">Sign In</button>
								</div>
							</form>
						</div>
					</div>
					<div class="google-bg text-center">
						{{-- <span><a href="#">Or sign in with</a></span>
						<div class="sign-google">
							<ul>
								<li><a href="#"><img src="{{ asset('frontend-assets') }}/assets/img/net-icon-01.png" class="img-fluid" alt="Logo"> Sign
										In using Google</a></li>
								<li><a href="#"><img src="{{ asset('frontend-assets') }}/assets/img/net-icon-02.png" class="img-fluid" alt="Logo">Sign
										In using Facebook</a></li>
							</ul>
						</div> --}}
						<p class="mb-0">New User ? <a href="{{ route('register') }}">Create an Account</a></p>
					</div>
				</div>
				<!-- /Login -->

			</div>

		</div>

	</div>
	<!-- /Main Wrapper -->

	<!-- jQuery -->
	<script src="{{ asset('frontend-assets') }}/assets/js/jquery-3.7.1.min.js" type="07d21cd6c819100cabba68e1-text/javascript"></script>

	<!-- Bootstrap Core JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/bootstrap.bundle.min.js" type="07d21cd6c819100cabba68e1-text/javascript"></script>

	<!-- Owl Carousel -->
	<script src="{{ asset('frontend-assets') }}/assets/js/owl.carousel.min.js" type="07d21cd6c819100cabba68e1-text/javascript"></script>

	<!-- Custom JS -->
	<script src="{{ asset('frontend-assets') }}/assets/js/script.js" type="07d21cd6c819100cabba68e1-text/javascript"></script>

<script src="{{ asset('frontend-assets') }}/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="07d21cd6c819100cabba68e1-|49" defer></script>

<!-- Jquery 3.7.1 -->
<script src="{{ asset('frontend-assets') }}/assets/vendor/jquery-3.7.1.min.js"></script>
<!-- Popper js 2.9.2 -->
<script src="{{ asset('frontend-assets') }}/assets/vendor/popper-2.9.2.min.js"></script>
<!-- Bootstrap js 5.0.2 -->
<script src="{{ asset('frontend-assets') }}/assets/vendor/bootstrap-5.0.2.min.js"></script>
<!-- Toastr for notifications -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
    $(document).ready(function () {
        $('#login').on('submit', function (e) {
            e.preventDefault(); // Prevent default form submission

            // Serialize form data
            let formData = $(this).serialize();

            // Perform AJAX request
            $.ajax({
                url: '{{ route("user.login") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        // Show success message
                        toastr.success(response.message || 'Login Successful! Redirecting...');

                        // Redirect after showing the message
                        setTimeout(function () {
                            window.location.href = response.redirect;
                        }, 2000); // Redirect after 2 seconds
                    } else {
                        // Show error message
                        toastr.error(response.message || 'Login failed. Please try again.');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        // Handle validation errors
                        let errors = xhr.responseJSON.errors;
                        let errorMessage = '';

                        $.each(errors, function (key, value) {
                            errorMessage += value[0] + '<br>'; // Display errors
                        });

                        toastr.error(errorMessage);
                    } else if (xhr.status === 401) {
                        // Handle authentication errors
                        toastr.error(xhr.responseJSON.message || 'Invalid email or password.');
                    } else {
                        // Handle other errors
                        toastr.error('An error occurred. Please try again.');
                    }
                }
            });
        });
    });
    </script>

<script>

const togglePassword1 = document.querySelector("#togglePasswordlogin");
const password1 = document.querySelector("#passwordlogin");

togglePassword1.addEventListener("click", function () {
    // Toggle the type attribute
    const type1 = password1.getAttribute("type") === "password" ? "text" : "password";
    password1.setAttribute("type", type1);

    // Toggle the eye slash icon
    this.querySelector("#eyelogin").classList.toggle("fa-eye-slash");
    this.querySelector("#eyelogin").classList.toggle("fa-eye");
});


</script>

<!-- Font Awesome (for the eye icon) -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>

</body>



</html>

