@extends('frontend.master')

@section('title')
    | {{ $course->title }}
@endsection


@section('content')

    <div class="section py-5">
        <div class="course-single-section">
            <div class="col-xxl-9 col-lg-8 courseenrooll">
                <div class="course-single">
                    <div class="course-single-bottom">
                        <div class="course-tab-wrap tutor-course-details-tab">

                            <ul class="nav course-tab" id="courseTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                        href="#Coursedescription" role="tab" aria-controls="Coursedescription"
                                        aria-selected="true">
                                        <i class="fa-regular fa-bookmark"></i>
                                         পাঠ্যক্রম </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link " id="curriculum-tab" data-bs-toggle="tab" href="#curriculum"
                                        role="tab" aria-controls="curriculum" aria-selected="false">
                                        <i class="fa-solid fa-book-open"></i>
                                        ওভারভিউ </a>
                                </li>

                            </ul>

                            <div class="tab-content" id="productTabContent">
                                <div class="tab-pane fade show active" id="Coursedescription" role="tabpanel"
                                    aria-labelledby="description-tab">
                                    <div class="course-description">

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
                                                                <p>{{ $module->desc }}</p>
                                                                <br>

                                                                <video id="my-video-1" class="video-js" controls preload="auto" data-setup='{"fluid": true}' width="100%">
                                                                    <source src="{{ asset('admin-assets/courses/modules/videos/'.$module->video) }}" type="application/x-mpegURL" />
                                                                    <p class="vjs-no-js">
                                                                        To view this video please enable JavaScript, and consider upgrading to a
                                                                        web browser that
                                                                        <a href="https://videojs.com/html5-video-support/" target="_blank">supports HTML5 video</a>
                                                                    </p>
                                                                </video>

                                                                @if(!empty($module->pdf) && is_string($module->pdf))
                                                                    @php
                                                                        $pdfs = json_decode($module->pdf, true);
                                                                    @endphp

                                                                    @if(is_array($pdfs))
                                                                        <p class="mt-2">PDFs:
                                                                            @foreach($pdfs as $pdf)
                                                                                <a href="{{ asset($pdf) }}" download>{{ basename($pdf) }}</a>
                                                                                <br>
                                                                            @endforeach
                                                                        </p>
                                                                    @endif
                                                                @endif


                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade " id="curriculum" role="tabpanel"
                                    aria-labelledby="curriculum-tab">
                                    {!! $course->desc !!}
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div class="col-xxl-3 col-lg-4">
                <aside class="sidebar-area">
                    <div class="widget widget_info  ">

                        <div class="course-about">

                            <div class="course-infos">
                                <h3 class="widget_title 2">কোর্সের তথ্য</h3>
                                <img class="mb-3" src="{{ asset($course->image) }}" alt="" width="50%">
                                <h5 class="course-title mb-3">{{ $course->title }}</h5>
                                <div class="info-list">
                                    <ul class="mb-0">
                                        <li>
                                            <strong>বিভাগ:</strong>
                                            <span><span class="tutor-meta-level"> {{ $course->category->name }} </span>
                                        </li>
                                        <li>
                                            <strong>শেষ আপডেট:</strong>
                                            <span class="convert-number">{{ $course->updated_at->format('d M, Y') }} </span>
                                        </li>
                                        <li>
                                            <strong>মডিউল:</strong>
                                            <span>{{ $course->modules->count() }}</span>
                                        </li>
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

<script src="https://unpkg.com/video.js/dist/video.js"></script>
<script src="https://unpkg.com/@videojs/http-streaming/dist/videojs-http-streaming.js"></script>
    <!--  Initialize Video.js after the DOM is fully loaded -->
    <script>

            var player = videojs('my-video-1');
    </script>


@endsection
