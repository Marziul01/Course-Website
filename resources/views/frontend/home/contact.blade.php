@extends('frontend.master')

@section('title')
    Sign Up
@endsection


@section('content')
<div class="section home-hero-bg">

    <div class="d-flex flex-column row-gap-3 justify-content-center w-50 h-100">
        <div class="" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="row">
                    <div class="col-md-4 p-2">
                        <div class="conatctDetasisl ">
                            <i class="fa-solid fa-envelope"></i>
                            <p>{{ $siteSettings->email }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 p-2">
                        <div class="conatctDetasisl">
                            <i class="fa-solid fa-phone"></i>
                            <p>{{ $siteSettings->phone }}</p>
                        </div>
                    </div>
                    <div class="col-md-4 p-2">
                        <div class="conatctDetasisl">
                            <i class="fa-solid fa-map-location-dot"></i>
                            <p>{{ $siteSettings->address }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-dialog w-100">
                    <div class="modal-content p-3">
                      <div class="modal-header border-0 mb-4">
                        <h5 class="modal-title" id="registerModalLabel"> আমাদের সাথে যোগাযোগ করুন </h5>
                      </div>
                      <div class="modal-body border-0">
                        <!-- Login Form -->
                        <form id="contact" class="pb-4">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">নাম</label>
                                <input type="text" name="name" class="form-control" placeholder="আপনার নাম লিখুন" required>
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">ফোন</label>
                                <input type="number" name="phone" class="form-control" placeholder="আপনার ফোন নম্বর লিখুন" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">ইমেইল ঠিকানা</label>
                                <input type="email" name="email" class="form-control" placeholder="আপনার ইমেইল লিখুন" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">আপানার মেসেজ লিখুন</label>
                                <textarea name="message" id="" class="form-control" placeholder="আপানার মেসেজ লিখুন"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">সাবমিট করুন</button>
                        </form>
                      </div>

                    </div>
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
    $(document).ready(function() {
        $('#contact').on('submit', function(e) {
            e.preventDefault(); // Prevent default form submission

            $.ajax({
                url: "{{ route('contact.submit') }}", // The route to handle form submission
                method: 'POST',
                data: $(this).serialize(), // Serialize form data
                success: function(response) {
                    if(response.success) {
                        toastr.success(response.message); // Show success message
                        $('#contact')[0].reset(); // Reset the form
                    }
                },
                error: function(xhr) {
                    if(xhr.status === 422) {
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            toastr.error(value[0]); // Show validation errors
                        });
                    } else {
                        toastr.error('Something went wrong. Please try again.'); // Handle other errors
                    }
                }
            });
        });
    });
</script>


@endsection
