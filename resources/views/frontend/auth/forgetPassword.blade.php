@extends('frontend.master')

@section('title')
    Forget Password
@endsection


@section('content')

    <div class="section home-hero-bg">
        <div class="d-flex flex-column row-gap-3 justify-content-center w-50 h-100">
            <div class="">
                <div class=" ">
                    <div class="mx-5">
                        <div class="text-center">
                            <h3 class="title mb-5">পাসওয়ার্ড রিসেট করুন !</h3>
                        </div>
                        <form id="forgot-password-form" class="login-form">
                            @csrf
                            <div class="mb-3">
                                <label for="email">ইমেইল</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="আপনার ইমেইল লিখুন" required />
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-common btn-block mt-4 signConfBtn">ইমেল যাচাই করুন</button>
                            </div>
                        </form>

                        <!-- Initially hidden forms for code verification and password reset -->
                        <form id="code-verification-form" class="login-form" style="display:none;">
                            @csrf
                            <div class="mb-3">
                                <label for="code">যাচাইকরণ কোড</label>
                                <input type="text" class="form-control" id="code" name="code" placeholder="কোড লিখুন" required />
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-common btn-block mt-4 signConfBtn">কোড যাচাই করুন</button>
                            </div>
                        </form>

                        <form id="reset-password-form" method="POST" style="display:none;">
                            @csrf
                            <!-- Hidden inputs for email and code -->
                            <input type="hidden" id="prevemail" name="prevemail" value="">
                            <input type="hidden" id="prevcode" name="prevcode" value="">

                            <div class="mb-3">
                                <label for="password">নতুন পাসওয়ার্ড</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="নতুন পাসওয়ার্ড লিখুন" required />
                            </div>
                            <div class="mb-3">
                                <label for="password_confirmation">পাসওয়ার্ড নিশ্চিত করুন</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="নতুন পাসওয়ার্ড নিশ্চিত করুন" required />
                            </div>
                            <div class="">
                                <button type="submit" class="btn btn-primary signConfBtn">পাসওয়ার্ড রিসেট করুন</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-center w-50 h-100">
            <img src="{{ asset('frontend-assets/imgs/hero_thumb_2_1.png') }}" alt="" width="75%">
        </div>
    </div>

@endsection

@section('customJs')

<script>
    function showLoading() {
        $('#loadingOverlay').show();
    }

    // Hide loading spinner
    function hideLoading() {
        $('#loadingOverlay').hide();
    }

    $(document).ready(function () {
        // Step 1: Handle Email Submission
        $('#forgot-password-form').submit(function (e) {
            e.preventDefault();
            showLoading(); // Show spinner when form is submitted
            $.ajax({
                url: '{{ route("password.email") }}',
                method: 'POST',
                data: $(this).serialize(),
                success: function (response) {
                    hideLoading(); // Hide spinner after response
                    toastr.success(response.message);
                    $('#forgot-password-form').hide();
                    $('#code-verification-form').show();
                    $('#prevemail').val(response.email); // Pass email to next step
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });

        // Step 2: Handle Code Verification
        $('#code-verification-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("password.verifyCode") }}',
                method: 'POST',
                data: $(this).serialize() + '&email=' + $('#prevemail').val(),
                success: function (response) {
                    toastr.success(response.message);
                    $('#code-verification-form').hide();
                    $('#reset-password-form').show();
                    $('#prevcode').val(response.code); // Pass code to the next step
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });

        // Step 3: Handle Password Reset
        $('#reset-password-form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route("password.reset") }}',
                method: 'POST',
                data: $(this).serialize() + '&email=' + $('#prevemail').val() + '&code=' + $('#prevcode').val(),
                success: function (response) {
                    toastr.success(response.message);
                    window.location.href = "{{ route('home') }}"; // Redirect to home
                },
                error: function (xhr) {
                    toastr.error(xhr.responseJSON.message);
                }
            });
        });
    });
</script>

@endsection
