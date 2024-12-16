@extends('frontend.master')

@section('title')
    | Blogs
@endsection


@section('content')

    <div class="section courseSection blog-page">
        <p class="pretitle"><i class="fa-solid fa-book"></i>
            নিয়মিত ব্লগ পড়ুন, নিজেকে আপডেট রাখুন।</p>
        <h1 class="title mt-3">সর্বশেষ ব্লগ</h1>
        <div>
            <ul class="nav nav-tabs border-0 sort-style-1" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                  <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fa-brands fa-microsoft"></i></button>
                </li>
                <li class="nav-item" role="presentation">
                  <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false"><i class="fa-solid fa-list"></i></button>
                </li>

              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active allblogs-hometab" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="Testimonialwrapper">
                        <ul class="Testimonialcarousel">
                            @foreach ($blogs as $blog)
                            <li class="Testimonialcard p-2 h-100">
                                <div class="TestimonialcardInner h-100">
                                    <div class="testimonial-item w-100">
                                        <div class="img">
                                           <a href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}"><img src="{{ asset($blog->image) }}" class="d-block" alt="Testimonial Image"></a>
                                        </div>
                                        <div class="w-100 text-left mainTestiText">
                                            <p class="mb-0 convert-number"><i class="fa-regular fa-clock"></i> {{ $blog->created_at->format('d M, Y') }} </p>
                                            <p class="textDesc">{{ $blog->title }}</p>
                                            <a class="" href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}">আরো বিস্তারিত পড়ুন <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="tab-pane fade sort-style-1 allblogs-profiletab mb-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="Testimonialwrapper mt-4">
                        <ul class="Testimonialcarousel">
                            @foreach ($blogs as $blog)
                            <li class="Testimonialcard p-2 h-100">
                                <div class="TestimonialcardInner h-100">
                                    <div class="testimonial-item w-100">
                                        <div class="img">
                                           <a href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}"><img src="{{ asset($blog->image) }}" class="d-block" alt="Testimonial Image"></a>
                                        </div>
                                        <div class="w-100 text-left mainTestiText">
                                            <p class="mb-0 convert-number"><i class="fa-regular fa-clock"></i> {{ $blog->created_at->format('d M, Y') }} </p>
                                            <p class="textDesc">{{ $blog->title }}</p>
                                            <a class="" href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}">আরো বিস্তারিত পড়ুন <i class="fa-solid fa-arrow-right-long"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
              </div>

        </div>

    </div>
@endsection


@section('customJs')


@endsection
