@extends('layout.ar_website')
@section('home_content')
 <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb" style="float: right">
                        <li class="breadcrumb-item active" aria-current="page">مشاركة مدونة</li>
                        <li class="breadcrumb-item"><a href="{{ route('eshop.ar') }}"><i class="icon-home"></i></a></li>

                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <br>
                <br>
                <br>
                <div class="row">
                    <div class="col-lg-9">
                        <article class="entry single">
                            <div class="entry-media">
                                <div class="">
                                    <img src="{{ asset('/') }}{{ $blog->blog_image }}" alt="Post">

                                </div><!-- End .entry-slider -->
                            </div><!-- End .entry-media -->

                            <div class="entry-body">
                                <div class="entry-date">
                                    <span class="day">{{ date('d', strtotime($blog->created_at)) }}</span>
                                    <span class="month">{{ date('M', strtotime($blog->created_at)) }}</span>
                                </div><!-- End .entry-date -->

                                <h2 class="entry-title">
                                    {{ $blog->blog_title_ar }}
                                </h2>

                                <div class="entry-meta">
                                    <span><i class="icon-calendar"></i>{{ date('M d, Y', strtotime($blog->created_at)) }}</span>
                                    <span><i class="icon-user"></i>By <a href="#">مسؤل</a></span>

                                </div><!-- End .entry-meta -->

                                <div class="entry-content">
                                    <p>{{ $blog->blog_ar }}</p>

                                </div><!-- End .entry-content -->

                                <div class="entry-share">
                                    <h3>
                                        <i class="icon-forward"></i>
                                        شارك هذا المنشور
                                    </h3>

                                    <div class="social-icons">
                                        <a href="#" class="social-icon social-facebook" target="_blank" title="Facebook">
                                            <i class="icon-facebook"></i>
                                        </a>
                                        <a href="#" class="social-icon social-twitter" target="_blank" title="Twitter">
                                            <i class="icon-twitter"></i>
                                        </a>
                                        <a href="#" class="social-icon social-linkedin" target="_blank" title="Linkedin">
                                            <i class="icon-linkedin"></i>
                                        </a>
                                        <a href="#" class="social-icon social-gplus" target="_blank" title="Google +">
                                            <i class="icon-gplus"></i>
                                        </a>
                                        <a href="#" class="social-icon social-mail" target="_blank" title="Email">
                                            <i class="icon-mail-alt"></i>
                                        </a>
                                    </div><!-- End .social-icons -->
                                </div><!-- End .entry-share -->




                            </div><!-- End .entry-body -->
                        </article><!-- End .entry -->

                        <div class="related-posts">
                            <h4 class="light-title">متعلق ب<strong>المشاركات</strong></h4>
                            <div class="owl-carousel owl-theme related-posts-carousel">
                            	@foreach($blogs as $row)
                                <article class="entry">
                                    <div class="entry-media">
                                        <a href="{{ route('blog-post.ar', $row->id) }}">
                                            <img src="{{ asset('/') }}{{ $row->blog_image }}" alt="Post">
                                        </a>
                                    </div><!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">{{ date('d', strtotime($row->created_at)) }}</span>
                                            <span class="month">{{ date('M', strtotime($row->created_at)) }}</span>
                                        </div><!-- End .entry-date -->

                                        <h2 class="entry-title">
                                            <a href="{{ route('blog-post.ar', $row->id) }}">{{ $row->blog_title_ar }}</a>
                                        </h2>

                                        <div class="entry-content">
                                            <p>{{ \Illuminate\Support\Str::limit($row->blog_ar, 250, '..........') }}</p>

                                            <a href="{{ route('blog-post.ar', $row->id) }}" class="read-more">اقرأ أكثر <i class="icon-angle-double-right"></i></a>
                                        </div><!-- End .entry-content -->
                                    </div><!-- End .entry-body -->
                                </article>
                                @endforeach

                            </div><!-- End .owl-carousel -->
                        </div><!-- End .related-posts -->
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar col-lg-3">
                        <div class="sidebar-wrapper">
                            <div class="widget">
                                <h4 class="widget-title">المشاركات الاخيرة</h4>

                                <ul class="simple-entry-list">
                                	@foreach($recent_blog as $row)
                                    <li>
                                        <div class="entry-media">
                                            <a href="{{ route('blog-post.ar', $row->id) }}">
                                                <img src="{{ asset('/') }}{{ $row->blog_image }}" alt="Post">
                                            </a>
                                        </div><!-- End .entry-media -->
                                        <div class="entry-info">
                                            <a href="{{ route('blog-post.ar', $row->id) }}">{{ $row->blog_title_ar }}</a>
                                            <div class="entry-meta">
                                                {{ date('M d, Y', strtotime($blog->created_at)) }}
                                            </div><!-- End .entry-meta -->
                                        </div><!-- End .entry-info -->
                                    </li>
                                    @endforeach
                                </ul>
                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-wrapper -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->


@endsection
