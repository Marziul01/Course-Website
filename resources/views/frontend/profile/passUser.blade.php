@extends('frontend.master')

@section('title')
    | User Profile
@endsection


@section('content')

    <div class="section py-5">
        <div class="row">
            <div class="col-md-4 usersDashNav">
                <a href="{{ route('user.dashboard') }}" class="menu_item btn registerbtn {{ Route::currentRouteName() == 'user.dashboard' ? 'active' : '' }}">ড্যাশবোর্ড</a>
                <a href="{{ route('user.orders') }}" class="menu_item btn registerbtn {{ Route::currentRouteName() == 'user.orders' ? 'active' : '' }}">অর্ডার স্ট্যাটাস</a>
                <a href="{{ route('user.profile') }}" class="menu_item btn registerbtn {{ Route::currentRouteName() == 'user.profile' ? 'active' : '' }}">প্রোফাইল বিস্তারিত</a>
                <a href="{{ route('user.changePass') }}" class="menu_item btn registerbtn {{ Route::currentRouteName() == 'user.changePass' ? 'active' : '' }}">পাসওয়ার্ড পরিবর্তন করুন</a>
                <a href="{{ route('user.logout') }}" class="menu_item btn registerbtn {{ Route::currentRouteName() == 'user.logout' ? 'active' : '' }}">লগআউট</a>
            </div>
            <div class="col-md-8">

                <div class="card card-body">
                    <h4 class="mb-3">আপনার পাসওয়ার্ড পরিবর্তন করুন</h4>
                        <div class="card card-body mb-3">
                            <div class="row">
                                <form id="update-password-form" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="password">আপনার নতুন পাসওয়ার্ড</label>
                                            <input type="password" name="password" class="form-control" id="password" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="password_confirmation">কনফার্ম পাসওয়ার্ড</label>
                                            <input type="password" name="password_confirmation" class="form-control" id="confirm-password" required>
                                        </div>
                                        <button type="submit" id="submit-btn" class="registerbtn" disabled>আপডেট পাসওয়ার্ড</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('customJs')

<script>
    $(document).ready(function () {
        // Enable submit button only when inputs are filled
        $('#password, #confirm-password').on('keyup', function () {
            let password = $('#password').val();
            let confirmPassword = $('#confirm-password').val();
            if (password && confirmPassword) {
                $('#submit-btn').prop('disabled', false);
            } else {
                $('#submit-btn').prop('disabled', true);
            }
        });

        // Submit the form using AJAX
        $('#update-password-form').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize(); // Collect form data

            $.ajax({
                url: '{{ route("update-password") }}', // Your route
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        toastr.success('Password updated successfully!', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "3000",
                            "progressBar": true,
                        });
                        $('#update-password-form')[0].reset(); // Reset form
                        $('#submit-btn').prop('disabled', true); // Disable the submit button again
                    }
                },
                error: function (xhr) {
                    let errors = xhr.responseJSON.errors;
                    let errorMessage = '';

                    // Display validation errors
                    $.each(errors, function (key, value) {
                        errorMessage += value[0] + '<br>';
                    });

                    toastr.error(errorMessage, 'Validation Error', {
                        "positionClass": "toast-top-right",
                        "timeOut": "5000",
                        "progressBar": true,
                    });
                }
            });
        });
    });
</script>

@endsection
