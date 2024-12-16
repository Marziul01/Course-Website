@extends('frontend.master')

@section('title')
    | User Dashboard
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
                @if(Auth::user()->role_name == 'affiliate')
                <div class="d-flex justify-content-between align-items-strech column-gap-3 flex-wrap">
                    <div class="w-33 card card-body mb-3">
                        <h6>টোটাল অ্যাফিলিয়েট ইউজার</h6>
                        @if (Auth::user()->coupon == null)
                        <h4 style="color: #024d9f">0  </h4>
                        @else
                            @php
                                $couponId = Auth::user()->coupon->id ;
                                $orderCount = $couponId ? $orders->where('coupon_id', $couponId)->count() : 0;
                            @endphp
                                <h4 style="color: #024d9f">{{ $orderCount }}  </h4>
                        @endif
                    </div>
                    <div class="w-33 card card-body mb-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>টোটাল কমিশন</h6>
                        </div>

                        @if (Auth::user()->coupon !== null)
                            @php
                                $couponId = Auth::user()->coupon->id;

                                // Filter the orders collection based on the coupon_id
                                $filteredOrders = $orders->filter(function ($order) use ($couponId) {
                                    return $order->coupon_id === $couponId;
                                });

                                // Sum the commission from the filtered orders
                                $totalCommission = $filteredOrders->sum('commission');
                            @endphp

                            <h4 style="color: #024d9f">{{ $totalCommission }}</h4>
                        @else
                            <h4 style="color: #024d9f">0</h4>
                        @endif
                    </div>
                    <div class="w-33 card card-body mb-3">
                        <div class="d-flex justify-content-between align-items-center paymentquestdiv">
                            <h6>টোটাল কমিশন পেমেন্ট বাকি </h6>
                            <a href="javascript:void(0)" class="btn btn-sm btn-success" id="sendPaymentRequest">Send Payment Request</a>
                        </div>
                        <h4 style="color: #024d9f">{{ Auth::user()->commission }}</h4>

                    </div>
                    <div class="w-33 card card-body mb-3">
                        <h6>আপনার অ্যাফিলিয়েট কুপন</h6>
                        <h4 style="color: #024d9f">{{ Auth::user()->coupon->coupon ?? 'No Coupon Created Yet!' }}</h4>
                    </div>
                </div>
                <div class="card card-body mb-3">
                    <h4 class="mb-3">অ্যাফিলিয়েট ইউজার </h4>
                    @if (Auth::user()->coupon !== null)
                        @php
                            $couponId = Auth::user()->coupon->id ;
                            $filteredOrders = $orders->filter(function ($order) use ($couponId) {
                                return $order->coupon_id === $couponId;
                            });

                        @endphp
                        @if ($filteredOrders->isNotEmpty())
                            @foreach ($filteredOrders as $order)
                                <div class="card card-body mb-3">
                                    <div class="row row-gap-3">
                                        <div class="col-md-3">
                                            <p>User Name:</p><br>
                                            <h5>{{ $order->name }}</h5>
                                        </div>
                                        <div class="col-md-6">
                                            <p>User Total Order</p><br>
                                            <h5>{{ $order->grand_total }}</h5>
                                        </div>
                                        <div class="col-md-3">
                                            <p>Your Commission</p><br>
                                            <h5>{{ $order->commission ?? 0}}</h5>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @else
                            <div class="card card-body">
                                <p>দুঃখিত ! আপনার কুপন এখনও কেউ ব্যাবহার করেনি </p>
                            </div>
                        @endif
                    @else
                        <div class="card card-body">
                            <p>দুঃখিত ! আপনার কুপন এখনও কেউ ব্যাবহার করেনি </p>
                        </div>
                    @endif

                </div>
                @endif
                <div class="card card-body">
                    <h4 class="mb-3">আপনার নথিভুক্ত কোর্সসমূহ </h4>
                    @if ($enrolls && $enrolls->isNotEmpty())
                        @foreach ($enrolls as $enroll)
                            <div class="card card-body mb-3">
                                <div class="row row-gap-2">
                                    <div class="col-md-3">
                                        <img src="{{ asset($enroll->courses->image) }}" alt="" width="100px" height="100px">
                                    </div>
                                    <div class="col-md-6">
                                        <h5>{{ $enroll->courses->title }}</h5>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="{{ route('user.courseEnroll', ['title' => $enroll->courses->slug, 'id' => $enroll->courses->id]) }}" class="registerbtn">কোর্স দেখুন</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card card-body">
                            <p>আপনি নথিভুক্ত করার জন্য কোন কোর্স নেই !</p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection


@section('customJs')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        $('#sendPaymentRequest').click(function(e) {
            e.preventDefault();

            if (confirm("Are you sure you want to send the payment request?")) {
                let userId = {{ auth()->user()->id }}; // Pass authenticated user's ID

                // AJAX request
                $.ajax({
                    url:  "{{ route('send.payment.request', ['user' => auth()->user()->id]) }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // Add CSRF token
                        user_id: userId
                    },
                    success: function(response) {
                        if (response.success) {
                            toastr.success(response.message);
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function(xhr, status, error) {
                        toastr.error('An error occurred while sending the request.');
                        console.error(error);
                    }
                });
            }
        });
    });
</script>


@endsection
