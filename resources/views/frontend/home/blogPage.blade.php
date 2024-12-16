@extends('frontend.master')

@section('title')
    | {{ $blog->title }}
@endsection


@section('content')
    <div class="section py-5">
        <div class="row">
            <div class="col-xxl-8 col-lg-7 blogspagediv">

                <div
                    class="post-35 post type-post status-publish format-gallery has-post-thumbnail hentry category-finance category-health category-technology tag-solution tag-students post_format-post-format-gallery th-blog blog-single">
                    <div class="blog-img th-blog-carousel slick-initialized slick-slider">
                        <div class="slick-list draggable">
                            <div class="slick-track" style="">
                                <img
                                    src="{{ asset($blog->image) }}" class="slick-slide slick-current slick-active"
                                    style="width: 100%; border-radius: 10px; margin-bottom: 20px" >
                                </div>
                        </div>
                    </div>
                    <h2 class="post-title mb-3">{{$blog->title}}</h2>
                    <div class="blog-content"><!-- Blog Meta -->
                        <div class="blog-meta mb-3">
                            <a href="" style="color: black">
                                <time datetime="2023-07-11T04:59:42+00:00">{{ $blog->created_at->format('d M, Y') }}</time>
                            </a>
                        </div>
                        <div class="blogsagesdesc">
                            {!! $blog->desc !!}
                        </div>
                    </div>
                    <div class="share-links clearfix">
                        <div class="row justify-content-between">
                            <div class="col-sm-auto">

                            </div>
                            {{-- <div class="col-md-auto text-xl-end"><span class="share-links-title">Share:</span>
                                <ul class="social-links">
                                    <li><a href=""
                                            target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a href=""
                                            target="_blank"><i class="fab fa-twitter"></i></a></li>
                                    <li><a href=""
                                            target="_blank"><i class="fab fa-linkedin-in"></i></a></li>
                                    <li><a href=""
                                            target="_blank"><i class="fab fa-instagram"></i></a></li>
                                </ul>
                            </div> --}}
                        </div>
                    </div>
                </div><!-- Comments -->
                {{-- <div class="th-comments-wrap">
                    <h2 class="blog-inner-title h5">
                        Comments (3) </h2>
                    <ul class="comment-list">
                        <li class="comment even thread-even depth-1 th-comment-item">
                            <div id="comment-46" class="th-post-comment">
                                <!-- Author Image -->
                                <div class="comment-avater">
                                    <img src="https://secure.gravatar.com/avatar/?s=96&amp;d=mm&amp;r=g"
                                        alt="?s=96&amp;d=mm&amp;r=g">
                                </div>

                                <!-- Comment Content -->
                                <div class="comment-content">

                                    <h3 class="name">Edura</h3>
                                    <span class="commented-on"> <i class="fas fa-calendar-alt"></i> August 3, 2023 </span>
                                    <p>Through this blog, we aim to inspire readers to embrace education as a lifelong
                                        journey and to advocate for quality education that empowers individuals and
                                        communities.</p>
                                    <div class="reply_and_edit">
                                        <a rel="nofollow" class="comment-reply-link reply-btn"
                                            href="https://themeholy.com/wordpress/edura/gain-insights-into-how-parents-can-support-childs-education-at-home-copy/?replytocom=46#respond"
                                            data-commentid="46" data-postid="35" data-belowelement="comment-46"
                                            data-respondelement="respond" data-replyto="Reply to Edura"
                                            aria-label="Reply to Edura"><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Content -->
                            <ul class="children">
                                <li class="comment odd alt depth-2 th-comment-item">
                                    <div id="comment-47" class="th-post-comment">
                                        <!-- Author Image -->
                                        <div class="comment-avater">
                                            <img src="https://secure.gravatar.com/avatar/?s=96&amp;d=mm&amp;r=g"
                                                alt="?s=96&amp;d=mm&amp;r=g">
                                        </div>

                                        <!-- Comment Content -->
                                        <div class="comment-content">

                                            <h3 class="name">Edura</h3>
                                            <span class="commented-on"> <i class="fas fa-calendar-alt"></i> August 3, 2023
                                            </span>
                                            <p>Education News and Trends: We provide updates on the latest developments and
                                                trends in the education sector, including educational research,</p>
                                            <div class="reply_and_edit">
                                                <a rel="nofollow" class="comment-reply-link reply-btn"
                                                    href="https://themeholy.com/wordpress/edura/gain-insights-into-how-parents-can-support-childs-education-at-home-copy/?replytocom=47#respond"
                                                    data-commentid="47" data-postid="35" data-belowelement="comment-47"
                                                    data-respondelement="respond" data-replyto="Reply to Edura"
                                                    aria-label="Reply to Edura"><i class="fas fa-reply"></i> Reply</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Comment Content -->
                                </li><!-- #comment-## -->
                            </ul><!-- .children -->
                        </li><!-- #comment-## -->
                        <li class="comment even thread-odd thread-alt depth-1 th-comment-item">
                            <div id="comment-48" class="th-post-comment">
                                <!-- Author Image -->
                                <div class="comment-avater">
                                    <img src="https://secure.gravatar.com/avatar/?s=96&amp;d=mm&amp;r=g"
                                        alt="?s=96&amp;d=mm&amp;r=g">
                                </div>

                                <!-- Comment Content -->
                                <div class="comment-content">

                                    <h3 class="name">Edura</h3>
                                    <span class="commented-on"> <i class="fas fa-calendar-alt"></i> August 3, 2023 </span>
                                    <p>We discuss strategies to help students make informed decisions about their
                                        educational and career paths, ensuring they are prepared for success in the
                                        workforce.</p>
                                    <div class="reply_and_edit">
                                        <a rel="nofollow" class="comment-reply-link reply-btn"
                                            href="https://themeholy.com/wordpress/edura/gain-insights-into-how-parents-can-support-childs-education-at-home-copy/?replytocom=48#respond"
                                            data-commentid="48" data-postid="35" data-belowelement="comment-48"
                                            data-respondelement="respond" data-replyto="Reply to Edura"
                                            aria-label="Reply to Edura"><i class="fas fa-reply"></i> Reply</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Comment Content -->
                        </li><!-- #comment-## -->
                    </ul>
                </div> --}}

                <!-- End of Comments -->

                <!-- Comment Form -->
                {{-- <div id="comments" class="th-comment-form">
                    <div id="respond" class="comment-respond">
                        <div class="form-title">
                            <h3 class="blog-inner-title h5">Leave A Comment <small><a rel="nofollow"
                                        id="cancel-comment-reply-link"
                                        href="/wordpress/edura/gain-insights-into-how-parents-can-support-childs-education-at-home-copy/#respond"
                                        style="display:none;">Cancel reply</a></small></h3>
                        </div>
                        <form action="https://themeholy.com/wordpress/edura/wp-comments-post.php" method="post"
                            id="commentform" class="comment-form" novalidate="">
                            <p class="text-theme mb-4">Your email address will not be published. Required fields are marked
                                *</p>
                            <div class="row">
                                <div class="col-md-12 form-group">
                                    <textarea rows="10" class="form-control" name="comment" placeholder="Write Comment *" required=""></textarea><i class="far fa-pencil-alt"></i>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-group"><input class="form-control" type="text"
                                        name="author" placeholder="Your Name *" value="" required=""><i
                                        class="fal fa-user"></i></div>
                                <div class="col-md-6 form-group"><input class="form-control" type="email"
                                        name="email" value="" placeholder="E-mail Address *" required=""><i
                                        class="fal fa-envelope"></i></div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="custom-checkbox notice mb-20"><input id="wp-comment-cookies-consent"
                                            name="wp-comment-cookies-consent" type="checkbox" value="yes"><label
                                            for="wp-comment-cookies-consent"> Save my name, email, and website in this
                                            browser for the next time I comment.<span class="checkmark"></span> </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 form-group mb-0"><button type="submit" name="submit" id="submit"
                                    class="th-btn"> Post Comment<i class="fas fa-arrow-right ms-1"></i></button> <input
                                    type="hidden" name="comment_post_ID" value="35" id="comment_post_ID">
                                <input type="hidden" name="comment_parent" id="comment_parent" value="0">
                            </div>
                        </form>
                    </div><!-- #respond -->
                </div><!-- End of Comment Form --> --}}
            </div>
            <div class="col-xxl-4 col-lg-5">
                <aside class="sidebar-area">

                    <div id="edura_recent_posts_widget-1" class="widget widget">
                        <h3 class="widget_title">Recent Posts</h3>
                        <div class="recent-post-wrap">
                            @foreach ($blogs->take(3) as $blog)
                            <div class="recent-post">
                                <div class="media-img w-30"><a
                                        href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}"><img
                                            src="{{ asset($blog->image) }}"
                                            ></a></div>
                                <div class="media-body w-70">
                                    <h4 class="post-title"><a class="text-inherit"
                                            href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}">{{$blog->title}}</a></h4>
                                    <div class="recent-post-meta"><a
                                            href="{{ route('blogsPage', ['title' => $blog->title , 'id' => $blog->id]) }}">{{ $blog->created_at->format('d M, Y') }}</a></div>
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div>

                </aside>
            </div>
        </div>
    </div>
@endsection


@section('customJs')
@endsection
