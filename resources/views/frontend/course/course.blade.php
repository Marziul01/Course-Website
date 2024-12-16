@extends('frontend.master')

@section('title')
    | {{ $course->title }}
@endsection


@section('content')
    <div class="section py-5">
        <div class="course-single-section">
            <div class="col-xxl-9 col-lg-8">
                <div class="course-single">
                    <div class="course-single-top">
                        <div class="course-img">
                            <img src="{{ asset($course->image) }}" alt="" width="100%">
                        </div>
                        <h2 class="course-title">{{ $course->title }}</h2>
                        @if ($course->combo == 0 )
                        <ul class="course-single-meta">
                            <li>
                                <i class="fa-solid fa-layer-group"></i>
                                <div>
                                    <span>বিভাগ :</span>
                                    <span>{{ $course->category->name }}</span>
                                </div>
                            </li>
                            <li>
                                <i class="fa-solid fa-person-chalkboard"></i>
                                <div>
                                    <span>মডিউল :</span>
                                    <span class="convert-number"> {{ $course->modules->count() }}</span>
                                </div>
                            </li>
                        </ul>
                        @endif

                    </div>


                    @if ($course->combo == 0 )
                    <div class="course-single-bottom">
                        <div class="course-tab-wrap tutor-course-details-tab">

                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        href="#Coursedescription" role="tab" aria-controls="Coursedescription"
                                        aria-selected="true">
                                        <i class="fa-regular fa-bookmark"></i>
                                        ওভারভিউ </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="curriculum-tab" data-bs-toggle="tab" href="#curriculum"
                                        role="tab" aria-controls="curriculum" aria-selected="false">
                                        <i class="fa-solid fa-book-open"></i>
                                        পাঠ্যক্রম </a>
                                </li>

                            </ul>

                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="Coursedescription" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="course-description">
                                        {!! $course->desc !!}
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="curriculum" role="tabpanel"
                                    aria-labelledby="curriculum-tab">
                                    <div class="course-curriculam">
                                        <h5 class="h5 mb-3">
                                            কোর্স কারিকুলাম :
                                        </h5>
                                        <div class="accordion" id="accordionPanelsStayOpenExample">
                                            @foreach ($course->modules as $module)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="panelsStayOpen-heading{{ $module->id }}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse{{ $module->id }}" aria-expanded="false" aria-controls="panelsStayOpen-collapse{{ $module->id }}">
                                                            {{ $module->name }}
                                                        </button>
                                                    </h2>
                                                    <div id="panelsStayOpen-collapse{{ $module->id }}" class="accordion-collapse collapse" aria-labelledby="panelsStayOpen-heading{{ $module->id }}">
                                                        <div class="accordion-body">
                                                            <strong> কোর্স এর কারিকুলাম সমূহ দেখতে কোর্স টি কিনুন ! </strong>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    @endif


                </div>

            </div>

            <div class="col-xxl-3 col-lg-4 mobile-full">
                <aside class="sidebar-area">
                    <div class="widget widget_info  ">

                        <div class="course-about">
                            <div class="course-cart" >
                                <div class="d-flex justify-content-start column-gap-3 align-items-start" >
                                    <div class="">
                                        <p class="h4 course-price convert-number mb-0">৳ {{ isset($course->sale_price) ? $course->sale_price :  $course->price}}</p>
                                        @if(isset($course->sale_price))
                                        <p class="convert-number" style="text-decoration: line-through; color: red">৳ {{ $course->price }}</p>
                                        @endif
                                    </div>

                                    @if(isset($course->sale_price))
                                        <p class="offer-percent convert-number">৳ {{ round((($course->price - $course->sale_price) / $course->price) * 100, 2) }}% Off</p>
                                    @endif
                                </div>
                                @if (Auth::check())

                                <form action="" method="post" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="course_id" value="{{ $course->id }}">
                                    <button type="submit" class="th-btn tutor-btn-primary tutor-btn-lg tutor-btn-block tutor-add-to-cart-button" data-course-id="{{ $course->id }}">
                                        <span class="btn-icon tutor-icon-cart-filled"></span>
                                        <span>কার্টে যোগ করুন</span>
                                    </button>
                                </form>

                                @else
                                <a class="btn tutor-add-to-cart-button" data-bs-toggle="modal" data-bs-target="#registerModal">কার্টে যোগ করুন</a>
                                @endif

                            </div>

                            <div class="course-infos">
                                <h3 class="widget_title 2">@if($course->combo == 1) কম্বো @endif কোর্সের তথ্য</h3>
                                <div class="info-list">
                                    <ul class="mb-0">
                                        @if($course->combo == 0)
                                        <li>
                                            <strong>বিভাগ:</strong>
                                            <span><span class="tutor-meta-level"> {{ $course->category->name }} </span>
                                        </li>
                                        @else
                                        <li>
                                            <strong>কম্বো কোর্সে সমূহ:</strong>
                                            @foreach ($course->comboCourses as $comboCourse )
                                            <p>{{ $comboCourse->course->title }}</p>
                                            @endforeach

                                        </li>
                                        @endif
                                        <li>
                                            <strong>শেষ আপডেট:</strong>
                                            <span class="convert-number">{{ $course->updated_at->format('d M, Y') }} </span>
                                        </li>
                                        @if($course->combo == 0)
                                        <li>
                                            <strong>মডিউল:</strong>
                                            <span>{{ $course->modules->count() }}</span>
                                        </li>
                                        @endif
                                        <li>
                                            <strong>তালিকাভুক্তির বৈধতা:</strong>
                                            <span>আজীবন</span>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            {{-- <div id="tutor-course-share-opener" class="tutor-modal">

                                <div class="tutor-modal-window">
                                    <div class="tutor-modal-content tutor-modal-content-white">
                                        <div class="tutor-modal-body">

                                            <div>
                                                <div class="tutor-color-black tutor-fs-6 tutor-fw-medium tutor-mb-16">
                                                    Share On Social Media </div>
                                                <div class="tutor-social-share-wrap"
                                                    >
                                                    <button class="tutor_share s_facebook" style="background:#3877EA"
                                                        href=""><i
                                                            class="tutor-valign-middle tutor-icon-brand-facebook"></i>
                                                        <span>Facebook</span>
                                                    </button><button class="tutor_share s_twitter"
                                                        style="background:#4CA0EB"
                                                        href=""><i
                                                            class="tutor-valign-middle tutor-icon-brand-twitter"></i>
                                                        <span>Twitter</span>
                                                    </button><button class="tutor_share s_linkedin"
                                                        style="background:#3967B6"
                                                        href=""><i
                                                            class="tutor-valign-middle tutor-icon-brand-linkedin"></i>
                                                        <span>Linkedin</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    {{-- <div class="widget widget_info tutor-mt-24">
                        <div class="tutor-course-details-widget">
                            <h3
                                class="tutor-course-details-widget-title tutor-fs-5 tutor-fw-bold tutor-color-black tutor-mb-16">
                                Tags </h3>
                            <div class="tutor-course-details-widget-tags">
                                @php
                                    $tagsArray = explode(',', $course->tags);
                                @endphp
                                <ul class="tutor-tag-list px-0">
                                    @foreach($tagsArray as $tag)
                                        <a href=""> {{ $tag }} </a>
                                    @endforeach

                                </ul>
                            </div>
                        </div>
                    </div> --}}

                </aside>
            </div>
        </div>
    </div>
@endsection


@section('customJs')

<script>
    $(document).ready(function () {
        $('.tutor-add-to-cart-button').on('click', function (e) {
            e.preventDefault();

            var courseId = $(this).data('course-id'); // Get the course ID

            $.ajax({
                url: '{{ route("cart.add") }}', // Change to your route
                method: 'POST',
                data: {
                    course_id: courseId,
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.success) {
                        toastr.success(response.message);
                        // Optionally update cart count
                        updateCartCount();
                    } else {
                        toastr.error(response.message);
                    }
                },
                error: function () {
                    toastr.error('An error occurred. Please try again.');
                }
            });
        });

        function updateCartCount() {
            $.ajax({
                url: '{{ route("cart.count") }}', // Change to your route
                method: 'GET',
                success: function (count) {
                    $('#cart-count').text(count); // Update the cart count display
                    $('#cart-count-mobile').text(count);
                }
            });
        }
    });
</script>


@endsection
