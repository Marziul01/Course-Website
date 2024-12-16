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
                    <h4 class="mb-3">আপনার প্রোফাইল ইনফরমেশন</h4>
                        <div class="card card-body mb-3">
                            <div class="row">
                                <form id="update-profile-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="name">আপনার নাম</label>
                                            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="email">আপনার ইমেইল</label>
                                            <input type="email" name="email" class="form-control" value="{{ Auth::user()->email }}" required>
                                        </div>
                                        <div class="col-md-12 mb-3">
                                            <label for="number">আপনার মোবাইল নাম্বার</label>
                                            <input type="number" name="number" class="form-control" value="0{{ Auth::user()->number }}" required>
                                        </div>
                                        <button type="submit" id="submit-btn" class="registerbtn" disabled>আপডেট প্রোফাইল</button>
                                    </div>
                                </form>

                                <!-- Verification Form -->
                                <form id="verification-form" style="display:none;">
                                    @csrf
                                    <input type="hidden" name="email" id="new-email">
                                    <div class="mb-3">
                                        <label for="verification_code" class="form-label">Verification Code</label>
                                        <input type="text" name="verification_code" class="form-control" placeholder="Enter the verification code" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">Verify Code</button>
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
        let initialFormData = {
            name: '{{ Auth::user()->name }}',
            email: '{{ Auth::user()->email }}',
            number: '0{{ Auth::user()->number }}'
        };

        // Enable submit button only when something changes
        $('input').on('input', function () {
            let formDataChanged = false;

            $('input').each(function () {
                if ($(this).val() !== initialFormData[$(this).attr('name')]) {
                    formDataChanged = true;
                }
            });

            if (formDataChanged) {
                $('#submit-btn').prop('disabled', false);
            } else {
                $('#submit-btn').prop('disabled', true);
            }
        });

        // Handle profile form submission
        $('#update-profile-form').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();
            let emailChanged = $('input[name="email"]').val() !== initialFormData.email;

            $.ajax({
                url: '{{ route("update-userprofile") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.emailChanged) {
                        // If email is changed, show verification form
                        $('#update-profile-form').hide();
                        $('#new-email').val(response.newEmail);
                        $('#verification-form').show();

                        toastr.success('Verification code sent to your new email!', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "3000",
                            "progressBar": true
                        });
                    } else {
                        toastr.success('Profile updated successfully!', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "3000",
                            "progressBar": true
                        });
                    }
                },
                error: function (xhr) {
                    toastr.error('An error occurred. Please try again.', '', {
                        "positionClass": "toast-top-right",
                        "timeOut": "3000",
                        "progressBar": true
                    });
                }
            });
        });

        // Handle verification form submission
        $('#verification-form').on('submit', function (e) {
            e.preventDefault();

            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route("verify-email-code") }}',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function (response) {
                    if (response.verified) {
                        toastr.success('Email verified and profile updated!', '', {
                            "positionClass": "toast-top-right",
                            "timeOut": "3000",
                            "progressBar": true
                        });

                        // Redirect or refresh the page
                        setTimeout(function () {
                            location.reload();
                        }, 2000);
                    }
                },
                error: function (xhr) {
                    toastr.error('Verification failed. Please check your code.', '', {
                        "positionClass": "toast-top-right",
                        "timeOut": "3000",
                        "progressBar": true
                    });
                }
            });
        });
    });
</script>


@endsection
