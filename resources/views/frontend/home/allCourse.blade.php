@extends('frontend.master')

@section('title')
    | All Courses
@endsection


@section('content')

    <div class="section courseSection blog-page">
        <p class="pretitle"><i class="fa-solid fa-book"></i>
            জনপ্রিয় কোর্স</p>
        <h1 class="title mt-3">আমাদের জনপ্রিয় অনলাইন কোর্স</h1>
        <ul class="nav nav-pills mb-3 d-flex justify-content-center column-gap-2 row-gap-2" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">সকল কোর্স</button>
            </li>
            @foreach ($categories as $category)
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile{{ $category->id }}" type="button" role="tab" aria-controls="pills-profile{{ $category->id }}" aria-selected="false">{{ $category->name }}</button>
              </li>
            @endforeach
            @if( ($courses->where('combo',1))->isNotEmpty() )
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact3" type="button" role="tab" aria-controls="pills-contact3" aria-selected="false">কম্ব কোর্স</button>
            </li>
            @endif
          </ul>
          <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                <div class="row gy-4">
                    @if(!is_null($courses))
                    @foreach ($courses as $course)
                    <div class="col-md-6 col-xxl-3 col-lg-4 d-flex">
                        <!-- Ensure that the card takes full height and uses flexbox -->
                        <div class="course-box style2 h-100 d-flex flex-column">
                            <div class="course-img position-relative">
                                <span class="courseCategoryHome">{{ $course->combo == 1 ? 'Combo Package' : $course->category->name }}</span>
                                <a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}">
                                    <img fetchpriority="high" decoding="async" width="327" height="250" src="{{ asset($course->image) }}" class="w-100 wp-post-image" alt="">
                                </a>
                            </div>
                            <div class="course-content flex-grow-1 d-flex flex-column">
                                <h3 class="course-title"><a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}" tabindex="-1">{{ $course->title }}</a></h3>
                                <div class="course-meta">
                                    <span><i class="fa-regular fa-file convert-number"></i> পাঠ {{ $course->modules->count() }}</span>
                                </div>
                                <div class="course-author mt-auto">
                                    <div class="offer-tag">
                                        @if(!is_null($course->sale_price))
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->sale_price }} </span>
                                        <span class="woocommerce-Price-currencySymbol sale convert-number">৳ {{ $course->price }} </span>
                                        @else
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->price }} </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @foreach ($categories as $category)
            <div class="tab-pane fade" id="pills-profile{{ $category->id }}" role="tabpanel" aria-labelledby="pills-profile-tab{{ $category->id }}">
                <div class="row gy-4">
                    @if(!is_null($courses))
                    @foreach ($courses->where('category_id' , $category->id) as $course)
                    <div class="col-md-6 col-xxl-3 col-lg-4 d-flex">
                        <!-- Ensure that the card takes full height and uses flexbox -->
                        <div class="course-box style2 h-100 d-flex flex-column">
                            <div class="course-img position-relative">
                                <span class="courseCategoryHome">{{ $course->combo == 1 ? 'Combo Package' : $course->category->name }}</span>
                                <a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}">
                                    <img fetchpriority="high" decoding="async" width="327" height="250" src="{{ asset($course->image) }}" class="w-100 wp-post-image" alt="">
                                </a>
                            </div>
                            <div class="course-content flex-grow-1 d-flex flex-column">
                                <h3 class="course-title"><a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}" tabindex="-1">{{ $course->title }}</a></h3>
                                <div class="course-meta">
                                    <span><i class="fa-regular fa-file convert-number"></i> পাঠ {{ $course->modules->count() }}</span>
                                </div>
                                <div class="course-author mt-auto">
                                    <div class="offer-tag">
                                        @if(!is_null($course->sale_price))
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->sale_price }} </span>
                                        <span class="woocommerce-Price-currencySymbol sale convert-number">৳ {{ $course->price }} </span>
                                        @else
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->price }} </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            @endforeach

            
            <div class="tab-pane fade" id="pills-contact3" role="tabpanel" aria-labelledby="pills-contact-tab3">
                <div class="row gy-4">
                    @if(!is_null($courses) && !is_null($courses->where('combo',1)))
                    @foreach ($courses->where('combo',1) as $course)
                    <div class="col-md-6 col-xxl-3 col-lg-4 d-flex">
                        <!-- Ensure that the card takes full height and uses flexbox -->
                        <div class="course-box style2 h-100 d-flex flex-column">
                            <div class="course-img position-relative">
                                <span class="courseCategoryHome">{{ $course->combo == 1 ? 'Combo Package' : $course->category->name }}</span>
                                <a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}">
                                    <img fetchpriority="high" decoding="async" width="327" height="250" src="{{ asset($course->image) }}" class="w-100 wp-post-image" alt="">
                                </a>
                            </div>
                            <div class="course-content flex-grow-1 d-flex flex-column">
                                <h3 class="course-title"><a href="{{ route('course', ['title' => $course->slug, 'id' =>  $course->id]) }}" tabindex="-1">{{ $course->title }}</a></h3>
                                <div class="course-meta">
                                    <span><i class="fa-regular fa-file convert-number"></i> পাঠ {{ $course->modules->count() }}</span>
                                </div>
                                <div class="course-author mt-auto">
                                    <div class="offer-tag">
                                        @if(!is_null($course->sale_price))
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->sale_price }} </span>
                                        <span class="woocommerce-Price-currencySymbol sale convert-number">৳ {{ $course->price }} </span>
                                        @else
                                        <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->price }} </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
            </div>
            
          </div>
        <div>
            {{-- <div class="row gy-4">
                @if(!is_null($courses))
                @foreach ($courses as $course)
                <div class="col-md-6 col-xxl-3 col-lg-4 d-flex">
                    <!-- Ensure that the card takes full height and uses flexbox -->
                    <div class="course-box style2 h-100 d-flex flex-column">
                        <div class="course-img position-relative">
                            <span class="courseCategoryHome">{{ $course->combo == 1 ? 'Combo Package' : $course->category->name }}</span>
                            <a href="{{ route('course', ['title' => $course->title, 'id' =>  $course->id]) }}">
                                <img fetchpriority="high" decoding="async" width="327" height="250" src="{{ asset($course->image) }}" class="w-100 wp-post-image" alt="">
                            </a>
                        </div>
                        <div class="course-content flex-grow-1 d-flex flex-column">
                            <h3 class="course-title"><a href="{{ route('course', ['title' => $course->title, 'id' =>  $course->id]) }}" tabindex="-1">{{ $course->title }}</a></h3>
                            <div class="course-meta">
                                <span><i class="fa-regular fa-file convert-number"></i> পাঠ {{ $course->modules->count() }}</span>
                            </div>
                            <div class="course-author mt-auto">
                                <div class="offer-tag">
                                    <span class="woocommerce-Price-currencySymbol convert-number">৳ {{ $course->sale_price }} </span>
                                    <span class="woocommerce-Price-currencySymbol sale convert-number">৳ {{ $course->price }} </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div> --}}

        </div>

    </div>
@endsection


@section('customJs')


@endsection
