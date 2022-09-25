@extends('layout.website')
@section('home_content')

     <style>
         .feature-box-simple h3 { font-size: 20px;}
         h3, .h3 {   font-size: 3rem; }

         @media only screen and (min-width: 600px) {
          .info-box h4 {   font-size: 2rem; }
          .info-box{ padding-top: 3.7rem;  padding-bottom: 3.7rem; }

        }
        @media only screen and (max-width: 600px) {
          .parent-img{ max-width: 65px; }
          .nav.nav-tabs .nav-item+.nav-item {
               text-align: -webkit-center;
            }
          .mobile_close{
              top:5px;
              right:5px;
              position: fixed;
          }
        }
         .close {
             font-size: 3.2rem !important;
         }
        @media only screen and (min-width: 600px) {
          .parent-img{ max-width: 150px; }
        }

        .home-product-tabs .tab-content {
            padding-bottom: 0;
            border-bottom: none;
        }
        .home-product-tabs .tab-content {
            border-top: 0.2rem solid #efefef;
        }
        .show-all{
            float: right;
            margin-top: -25px;
            background: none;
            color: #d1223e;
            font-weight: bold;
            padding: 5px;
            min-width: 90px;
            font-size:1rem;
            display: none;
        }
        .owl-carousel .owl-item {

            width: 175px;
        }
        .product-default{
            text-align: -webkit-center;
        }

         .ajaxplist{

             float: left;
             width: 25%;
         }


     </style>


        <main class="main">
            <div class="home-slider-container">
                <div class="home-slider owl-carousel">
                    <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="{{ asset('/') }}public/assets/frontend/images/slider/slide-1.jpg"></div><!-- End .slide-bg -->
                        <div class="home-slide-content container" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 offset-md-6 col-lg-5 offset-lg-7">
                                    <h4>Premium</h4>
                                    <h1>Headphones</h1>
                                    <h3>Only <strong>199 USD</strong></h3>
                                    <a href="category.html" class="btn btn-primary">Shop Now</a>
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .home-slide-content -->
                    </div><!-- End .home-slide -->
                    <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="{{ asset('/') }}public/assets/frontend/images/slider/slide-2.jpg"></div><!-- End .slide-bg -->
                        <div class="home-slide-content container" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 offset-md-6 col-lg-5 offset-lg-7">
                                    <h4>Premium</h4>
                                    <h1>Headphones</h1>
                                    <h3>Only <strong>199 USD</strong></h3>
                                    <a href="category.html" class="btn btn-primary">Shop Now</a>
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .home-slide-content -->
                    </div><!-- End .home-slide -->
                </div><!-- End .home-slider -->
            </div><!-- End .home-slider-container -->

            <div class="tab-pane fade show " id="skin_care_section" role="tabpanel" aria-labelledby="featured-products-tab">
            <div class="company-section">
                <div class="container">
                    <div class="row align-items-lg-center">
                        <div class="col-lg-12" style="text-align:center; margin-top:50px;">
                            <h2 style="color:#d1223e; font-size:25px;">START YOUR SKIN CARE JOURNEY</h2>
                            <h4 style="line-height: 30px;">Skin care is a personal journey and we're here to guide you along the way. <br>Live chat our skin care experts for more help.</h4>
                        </div><!-- End .col-lg-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .company-section -->

            <!-- Category tab starts -->
            <div class="home-product-tabs" style="margin-top:50px;">
                <div class="container">
                    <ul class="nav nav-tabs" style="justify-content:center;" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#skintype-category" role="tab" aria-controls="featured-products" aria-selected="true">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/routine.png') }}"  alt="Routine">
                                <h4 style="text-align:center;">ROUTINE</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#skinconcern-category" role="tab" aria-controls="latest-products" aria-selected="false">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/ingredient.png') }}"  alt="Ingredients">
                                <h4 style="text-align:center;">INGREDIENTS</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#routine-category" role="tab" aria-controls="latest-products" aria-selected="false">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/skin-issue.png') }}"  alt="Skin Issue">
                                <h4 style="text-align:center;">Skin Issue</h4>
                            </a>
                        </li>
                    </ul>
                </div><!-- End .container -->
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="skintype-category" role="tabpanel" aria-labelledby="featured-products-tab">
                        <div class="container">
                             <div class="new-products owl-carousel owl-theme" id="tag_productlist">
                        @foreach($routine_tags as $row)
                        <div class="product-default">
                                   <a class='prodata' data-id='{{$row->id}}' href="#tag_productlist">
                                    <img class="img-fluid rounded-circle mb-1" src="{{ $row->image }}" alt="concern" style="max-width:150px;">
                                    <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name }}</h4>
                                </a>
                        </div>
                      @endforeach
                    </div><!-- End .news-proucts -->
                     </div><!-- End .container -->
                  </div><!-- End .tab-pane -->
                    <div class="tab-pane fade" id="skinconcern-category" role="tabpanel" aria-labelledby="latest-products-tab">
                        <div class="container">
                            <div class="new-products owl-carousel owl-theme">
                                @foreach($ingredients_tags as $row)
                                <div class="product-default">
                                        <a class="ingredientdata" data-id='{{$row->id}}' href="#tag_productlist">
                                            <img class="img-fluid rounded-circle mb-1" src="{{ $row->image }}" alt="concern" style="max-width:150px;">
                                            <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name }}</h4>
                                        </a>
                                </div>
                                @endforeach
                            </div><!-- End .news-proucts -->
                        </div><!-- End .container -->
                    </div><!-- End .tab-pane -->
                    <div class="tab-pane fade" id="routine-category" role="tabpanel" aria-labelledby="latest-products-tab">
                        <div class="container">
                            <div class="new-products owl-carousel owl-theme">
                                @foreach($skin_tags as $row)
                                    <div  class="product-default">
                                        <a class="skinprodata" data-id="{{$row->id}}" href="#tag_productlist">
                                            <img class="img-fluid rounded-circle mb-1" src="{{ $row->image }}" alt="concern" style="max-width:150px;">
                                            <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name }}</h4>
                                        </a>
                                    </div>
                                @endforeach
                            </div><!-- End .news-proucts -->
                        </div><!-- End .container -->
                    </div><!-- End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .Category-tabs -->

         </div>

            <div class="container tag_product"  id="tag_product" style="display: inline-block;">

            </div>




            <!-- Skin care starts -->
            <div class="home-product-tabs" style="margin-top:50px;">
                <div class="container">
                    <ul class="nav nav-tabs" style="justify-content:center;" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#scfeatured-products" role="tab" aria-controls="featured-products" aria-selected="true">BEST SELLER</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#sclatest-products" role="tab" aria-controls="latest-products" aria-selected="false">NEW ARRIVALS</a>
                        </li>
                    </ul>
                    <a href="asd" class="btn btn-primary show-all">SHOP ALL</a>
                </div><!-- End .container -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="scfeatured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                        <div class="container">
                             <div class="new-products owl-carousel owl-theme">
                        @foreach($skin_products_best_sell as $row)
                            @php
                                $image =  $row->image;
                                $image = explode(',',$image);
                                $first_image = $image[0];
                           @endphp
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('eshop-detail', $row->id) }}">
                                    <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                </a>
                            </figure>
                            <div class="product-details">
                                @php
                                    $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                @endphp
                                @if($brand_name)
                                    <div class="cat-box">
                                        <span  style="font-size: 13px;" class="product-cat">{{ $brand_name->title }}</span>
                                    </div><!-- End .price-box -->
                                @endif
                                {{--@php--}}
                                    {{--$cat_name = \App\Category::where('id',$row->category_id)->first();--}}
                                {{--@endphp--}}
                                {{--<div class="cat-box">--}}
                                    {{--<span  style="font-size: 13px;" class="product-cat">{{ $cat_name->name }}</span>--}}
                                {{--</div><!-- End .price-box -->--}}

                                <h2 class="product-title">
                                    <a href="{{ route('eshop-detail', $row->id) }}" >{{$row->name}}</a>
                                </h2>
                                <div class="price-box">
                                    <span class="product-price">৳{{$row->price}}</span>
                                </div><!-- End .price-box -->

                                @php
                                    $full_rating = 0 ;
                                    $rating = \App\Review::where('product_id',$row->id)->select('ratings')->get();
                                    $total_rating = $rating->sum('ratings');
                                    $total_customer =count($rating);
                                    if ($total_customer > 0 ){
                                    $avg_rating = ($total_rating/$total_customer);
                                    $full_rating = $avg_rating;
                                    }else{
                                    $avg_rating = 0;
                                    }
                                    $half_rating = 0;
                                    $full_rating = (int)$full_rating;
                                    $half_rating = $avg_rating - $full_rating ;
                                    $un_rating = (int)(5 - $avg_rating) ;
                                @endphp

                                <div>
                                      @for($i = 1 ; $i <= $full_rating ;$i++ )
                                        <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                      @endfor

                                      @if( $half_rating > 0  && $half_rating < 1 )
                                          <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                      @endif
                                      @for($j = 1 ; $j <= $un_rating ;$j++ )
                                          <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                      @endfor
                                </div>
                                    <div class="product-action">
                                        <form action="" method="">
                                            @if(Auth::user() == null)
                                                <a href="{{ route('eshop-wishlist-login-check', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist"></a>
                                            @else
                                                <a href="{{ route('eshop-wishlist', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                            @endif
                                        </form>
                                          <form action="{{ route('add-to-cart', $row->id) }}" method="POST">
                                          @csrf
                                         @if($row->qty > 0 )
                                          <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                         @else
                                         <a href="{{ route('eshop-detail', $row->id) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                         @endif
                                            <input type="hidden" name="product_price" value="{{ $row->price}}">
                                        </form>
                                            {{ Form::open(['route' => ['eshop'], 'method' => 'POST'] ) }}
                                            <div>
                                                <input type="hidden" name="quick_id" value="{{ $row->id}}">
                                                <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>
                                            </div>
                                            {{ Form::close() }}
                                    </div>
                            </div><!-- End .product-details -->
                        </div>
                      @endforeach
                    </div><!-- End .news-proucts -->
                     </div><!-- End .container -->
                  </div><!-- End .tab-pane -->
                    <div class="tab-pane fade" id="sclatest-products" role="tabpanel" aria-labelledby="latest-products-tab">
                        <div class="container">
                            <div class="new-products owl-carousel owl-theme">
                                @foreach($skin_products_arrivals as $row)
                                    @php
                                        $image =  $row->image;
                                        $image = explode(',',$image);
                                        $first_image = $image[0];
                                    @endphp
                                    <div class="product-default">
                                        <figure>
                                            <a href="{{ route('eshop-detail', $row->id) }}">
                                                <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            @php
                                                $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                            @endphp
                                            @if($brand_name)
                                            <div class="cat-box">
                                                <span  style="font-size: 13px;" class="product-cat">{{ $brand_name->title }}</span>
                                            </div><!-- End .price-box -->
                                            @endif

                                            <h2 class="product-title">
                                                <a href="{{ route('eshop-detail', $row->id) }}" >{{$row->name}}</a>
                                            </h2>
                                            <div class="price-box">
                                                <span class="product-price">৳{{$row->price}}</span>
                                            </div><!-- End .price-box -->

                                            @php
                                                $full_rating = 0 ;
                                                $rating = \App\Review::where('product_id',$row->id)->select('ratings')->get();
                                                $total_rating = $rating->sum('ratings');
                                                $total_customer =count($rating);
                                                if ($total_customer > 0 ){
                                                $avg_rating = ($total_rating/$total_customer);
                                                $full_rating = $avg_rating;
                                                }else{
                                                $avg_rating = 0;
                                                }
                                                $half_rating = 0;
                                                $full_rating = (int)$full_rating;
                                                $half_rating = $avg_rating - $full_rating ;
                                                $un_rating = (int)(5 - $avg_rating) ;
                                            @endphp

                                            <div>
                                                @for($i = 1 ; $i <= $full_rating ;$i++ )
                                                    <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                                @endfor

                                                @if( $half_rating > 0  && $half_rating < 1 )
                                                    <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                                @endif
                                                @for($j = 1 ; $j <= $un_rating ;$j++ )
                                                    <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                                @endfor
                                            </div>
                                            <div class="product-action">
                                                <form action="" method="">
                                                    @if(Auth::user() == null)
                                                        <a href="{{ route('eshop-wishlist-login-check', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist"></a>
                                                    @else
                                                        <a href="{{ route('eshop-wishlist', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                                    @endif
                                                </form>
                                                <form action="{{ route('add-to-cart', $row->id) }}" method="POST">
                                                    @csrf
                                                    @if($row->qty > 0 )
                                                        <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                                    @else
                                                        <a href="{{ route('eshop-detail', $row->id) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                    @endif
                                                    <input type="hidden" name="product_price" value="{{ $row->price}}">
                                                </form>
                                                {{ Form::open(['route' => ['eshop'], 'method' => 'POST'] ) }}
                                                <div>
                                                    <input type="hidden" name="quick_id" value="{{ $row->id}}">
                                                    <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>
                                                </div>
                                                {{ Form::close() }}
                                            </div>
                                        </div><!-- End .product-details -->
                                    </div>
                                @endforeach
                            </div><!-- End .news-proucts -->
                        </div><!-- End .container -->
                    </div><!-- End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .home-product-tabs -->

          @if($product_details_info != null)
                @php
                    $image =  $product_details_info->image;
                    $image = explode(',',$image);
                @endphp

            <div class="modal fade" id="quickviewModal" tabindex="-1" role="dialog" aria-labelledby="quickviewModal" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="product-single-container product-single-default product-quick-view container">
                        <div class="row">

                            <div class="col-lg-6 col-md-6 product-single-gallery">


                                <div class="product-slider-container product-item">

                                    <div class="product-single-carousel owl-carousel owl-theme">
                                        @foreach($image as $img)
                                        <div class="product-item">
                                            <img class="product-single-image" src="{{ url('public/images/product', $img) }}" data-zoom-image="{{ url('public/images/product', $img) }}"/>
                                        </div>
                                        @endforeach
                                    </div>
                                    <!-- End .product-single-carousel -->
                                </div>
                                <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                    @foreach($image as $img)
                                    <div class="col-3 owl-dot">
                                        <img src="{{ url('public/images/product', $img) }}"/>
                                    </div>
                                    @endforeach
                                </div>
                            </div><!-- End .col-lg-7 -->




                            <div class="col-lg-6 col-md-6">
                                <button type="button" class="close mobile_close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <br>
                                <div class="product-single-details">

                                    <h1 class="product-title">{{ $product_details_info->name }} </h1>
                                    @php
                                           $comments = \App\Review::where('product_id',$product_details_info->id)->where('comment' ,'!=', null)->orderBy('id','DESC')->get();
                                            $full_rating = 0 ;
                                            $rating = \App\Review::where('product_id',$product_details_info->id)->select('ratings')->get();
                                            $total_rating = $rating->sum('ratings');
                                            $total_customer =count($rating);
                                            if ($total_customer > 0 ){
                                            $avg_rating = ($total_rating/$total_customer);
                                            $full_rating = $avg_rating;
                                            }else{
                                            $avg_rating = 0;
                                            }
                                            $half_rating = 0;
                                            $full_rating = (int)$full_rating;
                                            $half_rating = $avg_rating - $full_rating ;
                                            $un_rating = (int)(5 - $avg_rating) ;
                                    @endphp

                                    <div>
                                        @for($i = 1 ; $i <= $full_rating ;$i++ )
                                            <span><i class="fa fa-star" style="font-size:18px"></i></span>
                                        @endfor

                                        @if( $half_rating > 0  && $half_rating < 1 )
                                            <i class="fa fa-star-half-o" style="font-size:18px" aria-hidden="true"></i>
                                        @endif
                                        @for($j = 1 ; $j <= $un_rating ;$j++ )
                                            <span><i class="fa fa-star-o" style="font-size:18px"></i></span>
                                        @endfor
                                        <p> ({{   count($comments) }} @if( count($comments) > 1 ) reviews @else review )  @endif  </p>
                                    </div>

                                    <div class="price-box">
                                        <span class="product-price">৳ {{ $product_details_info->price }}</span>
                                    </div><!-- End .price-box -->

                                    <div class="product-desc">
                                        <p> {!! $product_details_info->product_details !!}</p>
                                    </div><!-- End .product-desc -->


                                    <form action="{{ route('add-to-cart', $product_details_info->id) }}" method="POST">
                                    @csrf
                                    <div class="product-action">
                                        @if($product_details_info->qty > 0 )
                                        <button type="submit" class="paction add-cart" title="Add to Cart"><span>Add to Cart</span></button>
                                        @else
                                            <a href="{{ route('eshop-detail', $product_details_info->id) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                        @endif

                                        <input type="hidden" name="product_price" value="{{ $product_details_info->price}}">

                                        @if(Auth::user() == null)
                                        <a href="{{ route('eshop-wishlist-login-check', $product_details_info->id) }}" class="paction add-wishlist" title="Add to Wishlist">

                                        </a>
                                        @else
                                            <a href="{{ route('eshop-wishlist', $product_details_info->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                        @endif
                                       </div><!-- End .product-action -->
                                   </form>
                                    <div class="product-single-share">
                                        <label>Share:</label>
                                        <!-- www.addthis.com share plugin-->
                                        <div class="addthis_inline_share_toolbox"></div>
                                    </div><!-- End .product single-share -->
                                </div><!-- End .product-single-details -->
                            </div><!-- End .col-lg-5 -->
                        </div><!-- End .row -->
                    </div><!-- End .product-single-container -->
                </div>
                </div>
            </div>
        @endif




            <div class="company-section">
                <div class="container">
                    <div class="row align-items-lg-center">
                        <div class="col-lg-6 padding-left-lg" style="margin-bottom:30px;">
                            <h1 style="color:#d1223e;">Kosmetica<br> Glam Guides</h1>
                            <h4 style="line-height: 30px;">We are dedicated to educating our community about all things skincare. We address key steps in your routine, providing guides on the double-cleanse, eye care, and sunscreen.</h4>
                            <a href="#" class="btn btn-primary">Read more</a>
                        </div><!-- End .col-lg-6 -->
                        <div class="col-lg-6" style="margin-bottom:30px;">
                            <img src="{{ url('public/sokoglam.jpg') }}" alt="image">
                        </div><!-- End .col-lg-6 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .company-section -->

            <div class="blog-section">
                <div class="container">
                     <div class="related-posts">
                            <h4 style="text-align:center;">EDITORIALS</h4>

                            <div class="owl-carousel owl-theme related-posts-carousel">
                                 @foreach($blog as $row)
                                     <article class="entry">
                                    <div class="entry-media">
                                        <a href="{{ route('blog-post', $row->id) }}">
                                            <img src="{{ $row->blog_image }}" alt="Post">
                                        </a>
                                    </div><!-- End .entry-media -->

                                    <div class="entry-body">
                                        <div class="entry-date">
                                            <span class="day">{{ date('d', strtotime($row->created_at)) }}</span>
                                            <span class="month">{{ date('M', strtotime($row->created_at)) }}</span>
                                        </div><!-- End .entry-date -->

                                        <h2 class="entry-title">
                                            <a href="{{ route('blog-post', $row->id) }}">{{ $row->blog_title }}</a>
                                        </h2>

                                        <div class="entry-content">
                                            <p>{{ \Illuminate\Support\Str::limit($row->blog, 250, '..........') }}</p>

                                            <a href="{{ route('blog-post', $row->id) }}" class="read-more">Read More <i class="icon-angle-double-right"></i></a>
                                        </div><!-- End .entry-content -->
                                    </div><!-- End .entry-body -->
                                </article>
                                @endforeach

                            </div><!-- End .owl-carousel -->
                        </div><!-- End .related-posts -->

                </div><!-- End .container -->
            </div><!-- End .blog-section -->

             <div class="section" style="margin-bottom:50px;">
                <div class="container">
                    <div class="row align-items-lg-center">
                        <div class="col-lg-6 padding-left-lg">
                            <h3 style="line-height: 40px;color:#d1223e; text-align:center;">Get our Newsletter to know about our new products, services and offers</h3>
                            <form method="POST" action="{{ route('newsletter') }}">
                                @csrf
                                <input type="email" style="text-align:center;" class="form-control" name="email" placeholder="Email Address" required>
                                <div class="form-footer" style="justify-content: center;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div><!-- End .form-footer -->
                            </form>
                        </div><!-- End .col-lg-6 -->
                        <div class="col-lg-6" style="text-align:-webkit-center;">
                            <img src="{{ url('public/images/newsletter.jpg') }}" style="max-width:95%;">
                        </div><!-- End .col-lg-6 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .company-section -->
        </main><!-- End .main -->



     <script src="<?php echo asset('public/assets/frontend/js/jquery.min.js') ?>"></script>

     <script type="text/javascript">
         $(document).ready(function(){

   // Routine Product
             $(".prodata").on("click", function(){
                 var tag_id = $(this).data("id");
                 $('.prodata').find('h4').css({              
                    'border-bottom': '0px solid',
                    'padding-bottom': '0px'
                });
                $(this).find('h4').css({            
                    'border-bottom': '2px solid',
                    'padding-bottom': '10px'
                });
                 $.ajax({
                     type: 'get',
                     url: '{{ route('tag.product') }}',
                     data: {'tag_id': tag_id},
                     dataType: "text",
                     success: function (data) {
                         var htmltext = '';
                         mydata=JSON.stringify(data);
                         $.each(JSON.parse(data), function(key, value) {
                             var url_id = '{{route("eshop-detail", ":id")}}';
                                 url_id = url_id.replace(':id', value.id);
                            var  url = '{{url('/')}}';

                             htmltext += '<div class="ajaxplist product-default">'+
                                 '<figure>'+
                                 '<a href="'+url_id+'">'+
                                 ' <img src="'+url+'/public/images/product/'+value.image+'">' +
                                 '</a>'+
                                 '</figure>'+
                                 '<div class="product-details">'+
                                 '<h2 class="product-title">'+
                                 '<a href="'+url_id+'">'+value.name+'</a>'+
                                 '</h2>'+
                                 '<div class="price-box">'+
                                 '<span class="product-price">'+value.price+'</span>'+
                                 '</div>'+
                                 '<div class="product-action">'+
                                 '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                                 '</div>'+
                                 '</div>'+
                                 '</div>';
                         });
                         $('.tag_product').html(htmltext);
                     },
                     error: function () {
                     }
                 });

             });


  /// Ingredients Product
             $(".ingredientdata").on("click", function(){
                 var tag_id = $(this).data("id");
                 $('.ingredientdata').find('h4').css({              
                    'border-bottom': '0px solid',
                    'padding-bottom': '0px'
                });
                $(this).find('h4').css({            
                    'border-bottom': '2px solid',
                    'padding-bottom': '10px'
                });
                 $.ajax({
                     type: 'get',
                     url: '{{ route('tag.product') }}',
                     data: {'tag_id': tag_id},
                     dataType: "text",
                     success: function (data) {
                         var htmltext = '';
                         mydata=JSON.stringify(data);
                         $.each(JSON.parse(data), function(key, value) {
                             var url_id = '{{route("eshop-detail", ":id")}}';
                             url_id = url_id.replace(':id', value.id);
                             var  url = '{{url('/')}}';
                             htmltext += '<div class="ajaxplist product-default">'+
                                 '<figure>'+
                                 '<a href="'+url_id+'">'+
                                 ' <img src="'+url+'/public/images/product/'+value.image+'">' +
                                 '</a>'+
                                 '</figure>'+
                                 '<div class="product-details">'+
                                 '<h2 class="product-title">'+
                                 '<a href="'+url_id+'">'+value.name+'</a>'+
                                 '</h2>'+
                                 '<div class="price-box">'+
                                 '<span class="product-price">'+value.price+'</span>'+
                                 '</div>'+
                                 '<div class="product-action">'+
                                 '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                                 '</div>'+
                                 '</div>'+
                                 '</div>';
                         });
                         $('.tag_product').html(htmltext);
                     },
                     error: function () {
                     }

                 });

             });



             /// Skin Product
             $(".skinprodata").on("click", function(){
                 var tag_id = $(this).data("id");
                 $('.skinprodata').find('h4').css({              
                    'border-bottom': '0px solid',
                    'padding-bottom': '0px'
                });
                $(this).find('h4').css({            
                    'border-bottom': '2px solid',
                    'padding-bottom': '10px'
                });
                 $.ajax({
                     type: 'get',
                     url: '{{ route('tag.product') }}',
                     data: {'tag_id': tag_id},
                     dataType: "text",
                     success: function (data) {
                         var htmltext = '';
                         mydata=JSON.stringify(data);
                         $.each(JSON.parse(data), function(key, value) {
                             var url_id = '{{route("eshop-detail", ":id")}}';
                             url_id = url_id.replace(':id', value.id);
                             var  url = '{{url('/')}}';
                             htmltext += '<div class="ajaxplist product-default">'+
                                 '<figure>'+
                                 '<a href="'+url_id+'">'+
                                 ' <img src="'+url+'/public/images/product/'+value.image+'">' +
                                 '</a>'+
                                 '</figure>'+
                                 '<div class="product-details">'+
                                 '<h2 class="product-title">'+
                                 '<a href="'+url_id+'">'+value.name+'</a>'+
                                 '</h2>'+
                                 '<div class="price-box">'+
                                 '<span class="product-price">'+value.price+'</span>'+
                                 '</div>'+
                                 '<div class="product-action">'+
                                 '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                                 '</div>'+
                                 '</div>'+
                                 '</div>';
                         });
                         $('.tag_product').html(htmltext);
                     },
                     error: function () {
                     }
                 });

             });
         });
     </script>



        @if($quick_view != null && $quick_view  == 9)
            <script>
                $(function() {
                    $('#quickviewModal').modal('show');
                });
            </script>
        @endif




@endsection




