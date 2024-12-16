@extends('frontend.master')

@section('title')
    | User Orders
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
                    <h4 class="mb-3">অর্ডার স্ট্যাটাস </h4>
                    @if (isset($orders))
                    @foreach ($orders as $order)
                        <div class="card card-body mb-3">
                            <div class="row">
                                <div class="col-md-3">
                                    <h6>Order Number : #{{ $order->id }}</h6>
                                </div>
                                <div class="col-md-6">
                                    @foreach ($order->items as $item)
                                        @if (isset($item->course))
                                           <p> {{ $item->course->title }}</p><br>
                                            @else
                                            Course has been removed from the site
                                        @endif
                                    @endforeach
                                </div>
                                <div class="col-md-3">
                                    @if ($order->status == 1)
                                    <a  class="btn btn-primary">Pending</a>
                                    @elseif ($order->status == 2)
                                    <a  class="btn btn-success">Success</a>
                                    @else
                                    <a  class="btn btn-danger">Canceled</a>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach
                    @else
                    <div class=" card card-body">
                        <h4>আপনি নথিভুক্ত করার জন্য কোন কোর্স নেই !</h4>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
@endsection


@section('customJs')


@endsection
