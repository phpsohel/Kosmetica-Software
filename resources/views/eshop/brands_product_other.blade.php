@extends('layout.website')
@section('home_content')
<style>
   @media  screen and (max-width: 600px) {
          .banner-cat {
            width:100%;
            height:140px !important;
            
            }
        }
        .banner.banner-cat {
        
            height:450px;
        }
    .sidebar-shop{
        display: block !important;
    }
        
</style>
  <main class="main">
      <div class="banner banner-cat" style="background-image: url('{{ asset('/') }}public/images/brand/{{$brand_name->image}}');  height: 450px; max-width:1200px; margin:auto;">
                <div class="banner-content container">
                    <!-- <h2 class="banner-subtitle">check out over <span>200+</span></h2> -->
                   
                    <!-- <a href="#" class="btn btn-dark">Shop Now</a> -->
                </div><!-- End .banner-content -->
            </div><!-- End .banner -->

            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Brands</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> Others</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">

                    @php

                        $id =  \App\Brand::where('title' ,'=','OTHERS')->first()->id;
                        $others_brand =  \App\Brand::where('parent_id' ,'=', $id)->where('is_active' ,'=','1')->get();

                    @endphp

                    <div class="sidebar-shop col-lg-2" style="line-height: 25px;">
                        <h4><strong style="color:black">Others Brand</strong></h4>
                        <ul>
                            @foreach($others_brand as $brand)
                                <li><a href="{{ route('brands-product',$brand->id) }}"><strong> {{ $brand->title }}</strong></a></li>
                            @endforeach
                        </ul>


                    </div><!-- End .widget -->



                    <div class="col-lg-10">
                         <nav class="toolbox" style="display:none;">
                            <div class="toolbox-left">
                                <div class="toolbox-item toolbox-sort">
                                    <div class="select-custom">
                                        <select name="orderby" class="form-control">
                                            <option value="menu_order" selected="selected">Default sorting</option>
                                            <option value="popularity">Sort by popularity</option>
                                            <option value="rating">Sort by average rating</option>
                                            <option value="date">Sort by newness</option>
                                            <option value="price">Sort by price: low to high</option>
                                            <option value="price-desc">Sort by price: high to low</option>
                                        </select>
                                    </div><!-- End .select-custom -->

                                    <a href="#" class="sorter-btn" title="Set Ascending Direction"><span class="sr-only">Set Ascending Direction</span></a>
                                </div><!-- End .toolbox-item -->
                            </div><!-- End .toolbox-left -->

                            <div class="toolbox-item toolbox-show">
                                <!-- <label>Showing 1–9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->

                        </nav>

                        <div class="row row-sm">

                            @foreach($brands_product as $row)
                                @php
                                      $image =  $row->pimage;
                                      $image = explode(',',$image);
                                      $first_image = $image[0];
                                @endphp
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="{{ route('eshop-detail', $row->pid) }}">
                                            <img src="{{ url('public/images/product',$first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                        </a>
                                    </figure>
                                    <div class="product-details">

                                        <div class="price-box" style="display: inline-flex;margin-bottom: 5px;">

                                            <span class="product-title">{{ $row->title }}</span>
                                        </div><!-- End .price-box -->
                                        <h2 class="product-title">
                                            <a href="{{ route('eshop-detail', $row->pid) }}">{{ $row->name }}</a>
                                        </h2>

                                        <div class="price-box">
                                            @if($row->promotion == null)
                                                <span class="product-price">৳{{$row->price}}</span>
                                            @else
                                                <span class="old-price">৳{{$row->price}}</span>
                                                <span class="product-price">৳{{$row->promotion_price}}</span>
                                            @endif
                                        </div><!-- End .price-box -->

                                        @php
                                            $full_rating = 0 ;
                                            $rating = \App\Review::where('product_id',$row->pid)->select('ratings')->get();
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
                                                    <a href="{{ route('eshop-wishlist-login-check', $row->pid) }}" class="paction add-wishlist" title="Add to Wishlist"></a>
                                                @else
                                                    <a href="{{ route('eshop-wishlist', $row->pid) }}" class="paction add-wishlist" title="Add to Wishlist" ></a>
                                                @endif
                                            </form>
                                            <form action="{{ route('add-to-cart', $row->pid) }}" method="POST">
                                                @csrf
                                                @if($row->qty > 0 )
                                                    <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                                @else
                                                    <a href="{{ route('eshop-detail', $row->pid) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                @endif
                                                <input type="hidden" name="product_price" value="{{ $row->price}}">
                                                <input type="hidden" name="promotion_price" value="{{ $row->promotion_price}}">
                                            </form>
                                            {{ Form::open(['route' => ['brands-product-other-quick'], 'method' => 'POST'] ) }}
                                            <div>
                                                <input type="hidden" name="quick_id" value="{{ $row->pid}}">
                                                <input type="hidden" name="brand_id" value="{{ $row->brand_id}}">
                                                <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>
                                            </div>
                                            {{ Form::close() }}
                                        </div>


                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                            @endforeach

                        </div>
                    </div><!-- End .col-lg-9 -->





                </div><!-- End .row -->
            </div><!-- End .container -->



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

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->


<script src="<?php echo asset('public/assets/frontend/js/jquery.min.js') ?>"></script>

@if($quick_view != null && $quick_view  == 9)
    <script>
        $(function() {
            $('#quickviewModal').modal('show');
        });
    </script>
@endif

@endsection