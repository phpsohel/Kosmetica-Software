@extends('layout.ar_website')
@section('home_content')

     <style>
         .feature-box-simple h3 { font-size: 20px;}
         h3, .h3 {   font-size: 3rem; }

         @media only screen and (min-width: 600px) {
          .info-box h4 {   font-size: 2rem; }
          .info-box{ padding-top: 3.7rem;  padding-bottom: 3.7rem; }

        }
        @media only screen and (max-width: 600px) {
          .parent-img{ max-width: 90px; }
          .nav.nav-tabs .nav-item+.nav-item {
               text-align: -webkit-center;
               margin-left: 2.3rem !important;
            }
          .mobile_close{
              top:5px;
              right:5px;
              position: fixed;
          }
           #skintype-category .owl-item, #skinconcern-category .owl-item, #routine-category .owl-item {
            width: 125px !important;
            }
            .prodata h4,.ingredientdata h4,.skinprodata h4{
                font-size:12px;
            }
            .ajaxplist{
                 width: 50% !important;
            }
            .home-slider-container, .home-slide{
                height: 140px !important;
            }
            .home-product-tabs .owl-theme .owl-nav .owl-prev {
                left:0  !important;
                height: 200px;
                background: #d7d1d173;
                width: 25px;
            }
            .home-product-tabs .owl-theme .owl-nav .owl-next {
                right:0 !important;
                height: 200px;
                background: #d7d1d173 !important;
                width: 25px;
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
             width: 25%;
         }
         element::-webkit-scrollbar {
            display: none; /* for Chrome, Safari, and Opera */
        }
        .home-slider-container, .home-slide{
            height: 450px;
        }
        .new-products.owl-carousel .owl-nav.disabled{
            display:inline-block !important;
        }
        .owl-carousel .owl-nav button.owl-next, .owl-carousel .owl-nav button.owl-prev{
            color: #d1223e !important;
            height: 200px;
            background: #d7d1d173 !important;
            width: 25px;
        }


     </style>
     @php
        $sliders = \App\Slider::where('is_active',true)->get();

       //   $name=  str_replace(' ', '-', $row->name);
       //   {{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}
     @endphp
        <main class="main">
            <div class="home-slider-container">
                <div class="home-slider owl-carousel">
                  @foreach( $sliders as $slider)
                    <div class="home-slide">
                        <div class="slide-bg owl-lazy"  data-src="{{url('public/images/slider',$slider->image)}}"></div><!-- End .slide-bg -->
                        <div class="home-slide-content container" style="display:none;">
                            <div class="row">
                                <div class="col-md-6 offset-md-6 col-lg-5 offset-lg-7">
                                    <h4>الممتازة</h4>
                                    <h1>سماعات الرأس</h1>
                                    <h3>فقط <strong>199 دولارًا أمريكيًا</strong></h3>
                                    <a href="category.html" class="btn btn-primary">تسوق الآن</a>
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .home-slide-content -->
                    </div><!-- End .home-slide -->
                      @endforeach
                </div><!-- End .home-slider -->
            </div><!-- End .home-slider-container -->
            <div class="tab-pane fade show " id="skin_care_section" role="tabpanel" aria-labelledby="featured-products-tab">
            <div class="company-section">
                <div class="container">
                    <div class="row align-items-lg-center">
                        <div class="col-lg-12" style="text-align:center; margin-top:50px;">
                            <h2 style="color:#d1223e; font-size:25px;">العربية ابدأ رحلة العناية بالبشرة</h2>
                            <h4 style="line-height: 30px;">العناية بالبشرة هي رحلة شخصية ونحن هنا لإرشادك على طول الطريق. <br>الدردشة الحية مع خبراء العناية بالبشرة لدينا لمزيد من المساعدة.</h4>
                        </div><!-- End .col-lg-12 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .company-section -->

            <!-- Category tab starts -->
            <div class="home-product-tabs" id="tag_productlist" style="margin-top:50px;">
                <div class="container">
                    <ul class="nav nav-tabs" style="justify-content:center;" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#skintype-category" role="tab" aria-controls="featured-products" aria-selected="true">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/routine.png') }}"  alt="Routine">
                                <h4 style="text-align:center;">نمط</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#skinconcern-category" role="tab" aria-controls="latest-products" aria-selected="false">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/ingredient.png') }}"  alt="Ingredients">
                                <h4 style="text-align:center;">مكونات</h4>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#routine-category" role="tab" aria-controls="latest-products" aria-selected="false">
                                <img class="img-fluid parent-img rounded-circle mb-1" src="{{ url('public/skin-issue.png') }}"  alt="Skin Issue">
                                <h4 style="text-align:center;">مشكلة الجلد</h4>
                            </a>
                        </li>
                    </ul>
                </div><!-- End .container -->
                  <div class="tab-content">
                    <div class="tab-pane fade show active" id="skintype-category" role="tabpanel" aria-labelledby="featured-products-tab">
                        <div class="container">
                             <div class="new-products owl-carousel owl-theme">
                        @foreach($routine_tags as $row)
                        <div class="product-default">
                                   <a class='prodata' data-id='{{$row->id}}' href="#tag_productlist">
                                    <img class="img-fluid rounded-circle mb-1" src="http://223.27.94.123/kosmetica/{{ $row->image }}" alt="concern" style="max-width:150px;">
                                    <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name_ar }}</h4>
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
                                            <img class="img-fluid rounded-circle mb-1" src="http://223.27.94.123/kosmetica/{{ $row->image }}" alt="concern" style="max-width:150px;">
                                            <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name_ar }}</h4>
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
                                            <img class="img-fluid rounded-circle mb-1" src="http://223.27.94.123/kosmetica/{{ $row->image }}" alt="concern" style="max-width:150px;">
                                            <h4 style="text-align:center; color: #d1223e;">{{ $row->tag_name_ar }}</h4>
                                        </a>
                                    </div>
                                @endforeach
                            </div><!-- End .news-proucts -->
                        </div><!-- End .container -->
                    </div><!-- End .tab-pane -->
                </div><!-- End .tab-content -->
            </div><!-- End .Category-tabs -->

         </div>

            <div class="container tag_product"  id="tag_product" style="display: -webkit-box; overflow-y:scroll;">
            </div>

            <!-- Skin care starts -->
            <div class="home-product-tabs" style="margin-top:50px;">
                <div class="container">
                    <ul class="nav nav-tabs" style="justify-content:center;" role="tablist">

                        <li class="nav-item">
                            <a class="nav-link active" id="featured-products-tab" data-toggle="tab" href="#scfeatured-products" role="tab" aria-controls="featured-products" aria-selected="true">الأكثر مبيعًا</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="latest-products-tab" data-toggle="tab" href="#sclatest-products" role="tab" aria-controls="latest-products" aria-selected="false">الوافدون الجدد</a>
                        </li>
                    </ul>
                    <a href="asd" class="btn btn-primary show-all">تسوق كل شيء</a>
                </div><!-- End .container -->
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="scfeatured-products" role="tabpanel" aria-labelledby="featured-products-tab">
                        <div class="container">
                             <div class="new-products owl-carousel owl-theme">
                        @foreach($skin_products_best_sell as $row)
                            @php

                                 $name =  str_replace(' ', '-', $row->name);
                                 $image =  $row->image;
                                 $image = explode(',',$image);
                                 $first_image = $image[0];
                           @endphp
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}">
                                    <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                </a>
                            </figure>
                            <div class="product-details">
                                @php
                                    $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                @endphp
                                @if($brand_name)
                                    <div class="cat-box">
                                        <span  style="font-size: 13px;" class="product-cat">{{ $brand_name->title_ar }}</span>
                                    </div><!-- End .price-box -->
                                @endif
                                <h2 class="product-title">
                                    <a href="{{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}" >{{$row->name_ar}}</a>
                                </h2>

                                <div class="price-box">
                                    @if($row->promotion == null)cmd

{{--                                        @if($row->promotion == null)--}}
{{--                                            $uae = exchange_rate*$row->price;--}}
{{--                                            <span class="product-price">৳{{ $uae}}</span>--}}
{{--                                        @else--}}
{{--                                            echo 'no';--}}
{{--                                        @endif--}}
                                        <span class="product-price">৳{{ $row->price }}</span>
                                    @else
                                        <span class="old-price">৳{{$row->price}}</span>
                                        <span class="promotional-price">৳{{$row->promotion_price}}</span>
                                    @endif
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
                                                <a href="{{ route('eshop-wishlist-login-check.ar', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist"></a>
                                            @else
                                                <a href="{{ route('eshop-wishlist.ar', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                            @endif
                                        </form>
                                          <form action="{{ route('add-to-cart.ar', $row->id) }}" method="POST">
                                          @csrf
                                         @if($row->qty > 0 )
                                          <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>أضف إلى السلة</button>
                                         @else
                                         <a href="{{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> عرض التفاصيل</a>
                                         @endif
                                            <input type="hidden" name="product_price" value="{{ $row->price}}">
                                            <input type="hidden" name="promotion_price" value="{{ $row->promotion_price}}">
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
                                        $name =  str_replace(' ', '-', $row->name);
                                           $image =  $row->image;
                                           $image = explode(',',$image);
                                           $first_image = $image[0];
                                    @endphp
                                    <div class="product-default">
                                        <figure>
                                            <a href=" {{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}">
                                                <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                            </a>
                                        </figure>
                                        <div class="product-details">
                                            @php
                                                $brand_name = \App\Brand:: where('id',$row->brand_id)->first();
                                            @endphp
                                            @if($brand_name)
                                            <div class="cat-box">
                                                <span  style="font-size: 13px;" class="product-cat">{{ $brand_name->title_ar }}</span>
                                            </div><!-- End .price-box -->
                                            @endif

                                            <h2 class="product-title">
                                                <a href=" {{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}" >{{$row->name_ar}}</a>
                                            </h2>
                                            <div class="price-box">
                                                @if($row->promotion == null)
                                                    <span class="product-price">৳{{$row->price}}</span>
                                                @else
                                                    <span class="old-price">৳{{$row->price}}</span>
                                                    <span class="promotional-price">৳{{$row->promotion_price}}</span>
                                                @endif
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
                                                        <a href="{{ route('eshop-wishlist-login-check.ar', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist"></a>
                                                    @else
                                                        <a href="{{ route('eshop-wishlist.ar', $row->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                                    @endif
                                                </form>
                                                <form action="{{ route('add-to-cart', $row->id) }}" method="POST">
                                                    @csrf
                                                    @if($row->qty > 0 )
                                                        <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                                    @else
                                                        <a href=" {{ route('eshop-details.ar',['id' => $row->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                    @endif
                                                    <input type="hidden" name="product_price" value="{{ $row->price}}">
                                                    <input type="hidden" name="promotion_price" value="{{ $row->promotion_price}}">
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

                    $name=  str_replace(' ', '-', $product_details_info->name);
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
                                    <h1 class="product-title">{{ $product_details_info->name_ar }} </h1>
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


                                    <form action="{{ route('add-to-cart.ar', $product_details_info->id) }}" method="POST">
                                    @csrf
                                    <div class="product-action">
                                        @if($product_details_info->qty > 0 )
                                        <button type="submit" class="paction add-cart" title="Add to Cart"><span>أضف إلى السلة</span></button>
                                        @else
                                            <a href="{{ route('eshop-details.ar',['id' => $product_details_info->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> عرض التفاصيل</a>
                                        @endif

                                        <input type="hidden" name="product_price" value="{{ $product_details_info->price}}">

                                        @if(Auth::user() == null)
                                        <a href="{{ route('eshop-wishlist-login-check.ar', $product_details_info->id) }}" class="paction add-wishlist" title="Add to Wishlist">

                                        </a>
                                        @else
                                            <a href="{{ route('eshop-wishlist.ar', $product_details_info->id) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
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
                        <div class="col-lg-6 padding-left-lg" style="margin-bottom:30px;text-align:right;">
                            <h1 style="color:#d1223e;">كوسمتيكا<br> دليل جلام</h1>
                            <h4 style="line-height: 30px;">نحن ملتزمون بتثقيف مجتمعنا حول كل ما يتعلق بالعناية بالبشرة. نعالج الخطوات الرئيسية في روتينك ، ونقدم إرشادات حول التطهير المزدوج والعناية بالعيون وواقي الشمس.</h4>
                            <a href="#" class="btn btn-primary">اقرأ أكثر</a>
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
                            <h4 style="text-align:center;">تحريرات</h4>

                            <div class="owl-carousel owl-theme related-posts-carousel">
                                 @foreach($blog as $row)
                                     <article class="entry">
                                    <div class="entry-media">
                                        <a href="{{ route('blog-post.ar', $row->id) }}">
                                            <img src="http://223.27.94.123/kosmetica/{{ $row->blog_image }}" alt="Post">
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

                </div><!-- End .container -->
            </div><!-- End .blog-section -->

             <div class="section" style="margin-bottom:50px;">
                <div class="container">
                    <div class="row align-items-lg-center">

                        <div class="col-lg-6" style="text-align:-webkit-center;">
                            <img src="{{ url('public/images/newsletter.jpg') }}" style="max-width:95%;">
                        </div><!-- End .col-lg-6 -->
                        <div class="col-lg-6 padding-left-lg">
                            <h3 style="line-height: 40px;color:#d1223e; text-align:center;">احصل على نشرتنا الإخبارية للتعرف على منتجاتنا وخدماتنا وعروضنا الجديدة</h3>
                            <form method="POST" action="{{ route('newsletter') }}">
                                @csrf
                                <input type="email" style="text-align:center;" class="form-control" name="email" placeholder="عنوان البريد الالكترونى" required>
                                <div class="form-footer" style="justify-content: center;">
                                    <button type="submit" class="btn btn-primary">يُقدِّم</button>
                                </div><!-- End .form-footer -->
                            </form>
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

                             var url_id = '{{route("eshop-detail_name",":name")}}';
                                // url_id = url_id.replace(':id', value.id);
                                 url_id = url_id.replace(':name', value.name);

                            //var  url = '{{url('/')}}';
                            var  url = '';
                             if (value.promotion == null && value.promotion_price == null ) {
                                 htmltext += '<div class="ajaxplist product-default">'+
                                     '<figure>'+
                                     '<a href="'+url_id+'">'+
                                     ' <img src="'+url+'http://223.27.94.123/kosmetica/public/images/product/'+value.image+'">' +
                                     '</a>'+
                                     '</figure>'+
                                     '<div class="product-details">'+
                                     '<h2 class="product-title">'+
                                     '<a href="'+url_id+'">'+value.name+'</a>'+
                                     '</h2>'+
                                     ' <div class="price-box">'+
                                     '<span class="product-price">৳'+value.price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }else {
                                 htmltext += '<div class="ajaxplist product-default">'+
                                     '<figure>'+
                                     '<a href="'+url_id+'">'+
                                     ' <img src="'+url+'http://223.27.94.123/kosmetica/public/images/product/'+value.image+'">' +
                                     '</a>'+
                                     '</figure>'+
                                     '<div class="product-details">'+
                                     '<h2 class="product-title">'+
                                     '<a href="'+url_id+'">'+value.name+'</a>'+
                                     '</h2>'+
                                     ' <div class="price-box">'+
                                     ' <span class="old-price">৳'+value.price+'</span>'+
                                     '<span class="promotional-price">৳'+value.promotion_price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }


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
                             var url_id = '{{route("eshop-detail_name", ":name")}}';
                           //  url_id = url_id.replace(':id', value.id);
                             url_id = url_id.replace(':name', value.name);
                             var  url = '{{url('/')}}';
                             if (value.promotion == null && value.promotion_price == null ) {
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
                                     ' <div class="price-box">'+
                                     '<span class="product-price">৳'+value.price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> عرض التفاصيل</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }else {
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
                                     ' <div class="price-box">'+
                                     ' <span class="old-price">৳'+value.price+'</span>'+
                                     '<span class="promotional-price">৳'+value.promotion_price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> عرض التفاصيل</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }


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
                             var url_id = '{{route("eshop-detail_name", ":name")}}';
                             //  url_id = url_id.replace(':id', value.id);
                             url_id = url_id.replace(':name', value.name);
                             var  url = '{{url('/')}}';
                             // htmltext += '<div class="ajaxplist product-default">'+
                             //     '<figure>'+
                             //     '<a href="'+url_id+'">'+
                             //     ' <img src="'+url+'/public/images/product/'+value.image+'">' +
                             //     '</a>'+
                             //     '</figure>'+
                             //     '<div class="product-details">'+
                             //     '<h2 class="product-title">'+
                             //     '<a href="'+url_id+'">'+value.name+'</a>'+
                             //     '</h2>'+
                             //     '<div class="price-box">'+
                             //     '<span class="product-price">'+value.price+'</span>'+
                             //     '</div>'+
                             //     '<div class="product-action">'+
                             //     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> View Details</a>'+
                             //     '</div>'+
                             //     '</div>'+
                             //     '</div>';

                             if (value.promotion == null && value.promotion_price == null ) {
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
                                     ' <div class="price-box">'+
                                     '<span class="product-price">৳'+value.price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> عرض التفاصيل</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }else {
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
                                     ' <div class="price-box">'+
                                     ' <span class="old-price">৳'+value.price+'</span>'+
                                     '<span class="promotional-price">৳'+value.promotion_price+'</span>'+
                                     '</div>'+
                                     '<div class="product-action">'+
                                     '<a href="'+url_id+'" class="btn-icon btn-add-cart"><i class="fas fa-eye"></i> عرض التفاصيل</a>'+
                                     '</div>'+
                                     '</div>'+
                                     '</div>';
                             }

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




