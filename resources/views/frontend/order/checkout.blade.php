@extends('frontend.master')

@section('title')
    | Checkout
@endsection

@section('content')
<div class="section py-5">
    <h2 class=" mb-5">চেকআউট</h2>
    <form id="checkout-form">
        @csrf
        <div class="d-flex justify-content-between column-gap-3 align-items-start chekoutmaindiv">
            <!-- Shipping Details -->
            <div class="card card-body col-md-6 infos">
                <h4>আপনার ইনফর্মেশন </h4>
                <div class="mt-4">
                    <label for="name">নাম</label>
                    <input type="text" name="name" id="name" class="form-control" required value="{{ Auth::user()->name }}">
                </div>
                <div class="py-3">
                    <label for="email">ইমেইল</label>
                    <input type="email" name="email" id="email" class="form-control" required value="{{ Auth::user()->email }}">
                </div>
                <div class="">
                    <label for="address">ফোন</label>
                    <input type="number" name="phone" id="address" class="form-control" required value="{{ Auth::user()->number }}">
                </div>
            </div>

            <div class="card card-body col-md-6">
                <h4>অর্ডার বিস্তারিত </h4>
                <table class="table">
                    <thead>
                        <tr>
                            <th>কোর্স</th>
                            <th>মূল্য</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->course->title }}</td>
                                <td class="convert-number">৳{{ $item->course->sale_price ?? $item->course->price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="card card-body float-end">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>মোট</td>
                                <td class="convert-number text-end">৳{{ $total }}</td>
                            </tr>
                            <tr>
                                <td>কুপন ডিসকাউন্ট</td>
                                <td class="convert-number text-end" id="coupon-discount">৳{{ session('coupon_discount', 0) }}</td>
                            </tr>
                            <tr>
                                <td>সর্বমোট</td>
                                <td id="new-total-amount" class="convert-number text-bold text-end">৳{{ $total - session('coupon_discount', 0) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Coupon Form -->
                <div class="mt-4" >
                    <h4>কুপন প্রয়োগ করুন</h4>
                    <form id="apply-coupon-form">
                        <div class="d-flex w-100 justify-content-between align-items-center column-gap-2">
                            <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="কুপন কোড লিখুন">
                            <button type="submit" id="apply-coupon-btn" class="btn btn-primary w-25 couponmobilebtnn">কুপন এড করুন</button>
                        </div>
                    </form>
                </div>

                <div class="mt-4">
                    <h4>পেমেন্ট অপশন সিলেক্ট করুন</h4>
                    <div class="cehckout-payment">
                        <div class="d-flex align-items-center column-gap-3 mb-3">
                            @foreach ($payment_methods as $payment_method)
                                <div>
                                    <input type="radio" id="{{ $payment_method->id }}" name="payment_method_id" value="{{ $payment_method->id }}" class="payment-radio">
                                    <label for="{{ $payment_method->id }}" data-bs-toggle="collapse" data-bs-target="#collapseExample{{ $payment_method->id }}" role="button" aria-expanded="false" aria-controls="collapseExample{{ $payment_method->id }}">{{ $payment_method->name }}</label>
                                </div>
                            @endforeach
                        </div>
                        
                        @foreach ($payment_methods as $payment_method)
                            <div class="collapse" id="collapseExample{{ $payment_method->id }}">
                                <div class="card card-body">
                                    <p><strong class="">" 0{{ $payment_method->number }}"</strong> এই নাম্বারে সেন্ড মানি করে নিচে আপনার পেরিত "{{ $payment_method->name }}" নাম্বার এবং ট্রানজেকশন আইডি দিন।</p>
                                </div>
                            </div>
                        @endforeach
                        
                        <div class="card card-body show-payment-form" style="display:none;">
                            <input type="number" name="payment_number" placeholder="আপনার প্রেরিত অ্যাকাউন্ট নাম্বার" class="form-control my-3">
                            <input type="text" name="transaction_id" placeholder="পেমেন্ট ট্রানজেকশন আইডি" class="form-control">
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <button type="submit" id="checkout-btn" class="btn mt-3 registerbtn">অর্ডার করুন</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('customJs')

<script>
    // Handle coupon form submission
    $('#apply-coupon-btn').click(function(e) {
        e.preventDefault();  // Prevents the default form submission behavior

        var couponCode = $('#coupon_code').val();  // Get the coupon code value

        $.ajax({
            url: '{{ route("checkout.applyCoupon") }}',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                coupon_code: couponCode,
            },
            success: function(response) {
                if (response.success) {
                    toastr.success(response.message);  // Show success message
                    $('#new-total-amount').text('৳' + response.new_total);
                    $('#coupon-discount').text('৳' + response.discount);  // Update total amount dynamically
                    $('#coupon_code').val('');  // Clear the coupon code input field after successful application
                } else {
                    toastr.error(response.message);  // Show error message
                }
            }
        });
    });

    function showLoading() {
        $('#loadingOverlay').show();
    }

    // Hide loading spinner
    function hideLoading() {
        $('#loadingOverlay').hide();
    }

    // Handle checkout form submission
    $('#checkout-btn').click(function(e) {
    e.preventDefault();  // Prevents the default form submission behavior
    showLoading(); // Show spinner when form is submitted
    $.ajax({
        url: '{{ route("checkout.process") }}',
        method: 'POST',
        data: $('#checkout-form').serialize(),  // Serialize and send the checkout form data
        success: function(response) {
            hideLoading(); // Hide spinner after response
            if (response.success) {
                toastr.success(response.message);  // Show success message
                window.location.href = "{{ route('user.orders') }}";  // Redirect to home page after successful checkout
            } else {
                toastr.error(response.message);  // Show error message
            }
        },
        error: function(response) {
            const errors = response.responseJSON.errors;
            for (const error in errors) {
                toastr.error(errors[error][0]);  // Show validation error
            }
        }
    });
});
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('.payment-radio');
        const collapses = document.querySelectorAll('.collapse');

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                // Hide all collapses
                collapses.forEach(collapse => {
                    collapse.classList.remove('show');
                });

                // Show the collapse corresponding to the selected radio input
                const targetCollapse = document.querySelector(`#collapseExample${this.value}`);
                targetCollapse.classList.add('show');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const radios = document.querySelectorAll('.payment-radio');
        const collapses = document.querySelectorAll('.collapse');
        let previousForm = null;

        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                // If there's a previously opened form, reset its inputs
                if (previousForm) {
                    previousForm.reset();
                }

                // Hide all collapses
                collapses.forEach(collapse => {
                    collapse.classList.remove('show');
                });

                // Show the collapse corresponding to the selected radio input
                const targetCollapse = document.querySelector(`#collapseExample${this.value}`);
                targetCollapse.classList.add('show');

                // Set the current form as the previousForm for the next radio button change
                previousForm = targetCollapse.querySelector('form');
            });
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    // Select all radio inputs with the class 'payment-radio'
    const paymentRadios = document.querySelectorAll('.payment-radio');

    // Add change event listener to each radio input
    paymentRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Show the payment form when any radio input is selected
            const paymentForm = document.querySelector('.show-payment-form');
            paymentForm.style.display = 'block';
        });
    });
});
</script>

@endsection
