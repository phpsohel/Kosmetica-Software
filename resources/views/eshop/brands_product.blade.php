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
        
</style>

@php
    //   $name=  str_replace(' ', '-', $row->name);
    //   {{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}
@endphp
  <main class="main">
      <div class="banner banner-cat" style="background-image: url('{{ asset('/') }}public/images/brand/{{$brand_name->image}}'); height: 450px; max-width:1200px; margin:auto;">
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
                        <li class="breadcrumb-item active" aria-current="page"> {{$brand_name->title}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
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
                                <!-- <label>Showing 1???9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->

                        </nav>

                        <div class="row row-sm">

                            @foreach($brands_product as $row)
                                @php
                                    $name=  str_replace(' ', '-', $row->name);
                                   $image =  $row->image;
                                   $image = explode(',',$image);
                                   $first_image = $image[0];
                                @endphp
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">
                                            <img src="{{ url('public/images/product',$first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                        </a>
                                    </figure>
                                    <div class="product-details">

                                        <div class="price-box" style="display: inline-flex;margin-bottom: 5px;">

                                            <span class="product-title">{{ $brand_name->title }}</span>
                                        </div><!-- End .price-box -->
                                        <h2 class="product-title">
                                            <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">{{ $row->name }}</a>
                                        </h2>

                                        <div class="price-box">
                                            @if($row->promotion == null)
                                                <span class="product-price">???{{$row->price}}</span>
                                            @else
                                                <span class="old-price">???{{$row->price}}</span>
                                                <span class="promotional-price">???{{$row->promotion_price}}</span>
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
                                                    <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
                                                @endif
                                                <input type="hidden" name="product_price" value="{{ $row->price}}">
                                                <input type="hidden" name="promotion_price" value="{{ $row->promotion_price}}">
                                            </form>
                                            <!--{{ Form::open(['route' => ['brands-product-quick'], 'method' => 'POST'] ) }}-->
                                            <form action="" method="">
                                            <div>
                                                <!--<input type="hidden" name="quick_id" value="{{ $row->id}}">-->
                                                <!--<input type="hidden" name="brand_id" value="{{ $row->brand_id}}">-->
                                                <button type="submit" class="paction quick-view" title="Quick View"><i class="fas fa-external-link-alt"></i></button>
                                            </div>
                                            <!--{{ Form::close() }}-->
                                              </form>
                                        </div>


                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <nav class="toolbox toolbox-pagination">
                            <div class="toolbox-item toolbox-show">
                                <!-- <label>Showing 1???9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->

                            <ul class="pagination">

                            </ul>
                        </nav>
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar-shop col-lg-3 order-lg-first">
                        <div class="sidebar-wrapper">

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Price</a>
                                </h3>
                                <div class="collapse show" id="widget-body-2">
                                    <div class="widget-body">
                                        {!! Form::open(['route' => 'price.filter.brand', 'method' => 'post', 'files' => true]) !!}
                                        <div class="row">
                                            <input type="hidden" name="brand_id" value="{{$brand_name->id}}">
                                            <input style="max-width: 70px;" type="number" min="0" placeholder="Min" value="" name="min" pattern="[0-9]*">
                                            <span class="c1DHiF"> - </span>
                                            <input  style="max-width: 70px;" type="number" min="0" placeholder="Max" name="max" value="" pattern="[0-9]*">
                                        </div>
                                        <div class="filter-price-action">
                                            <button type="submit" class="btn btn-primary">Filter</button>
                                        </div><!-- End .filter-price-action -->
                                        {{ Form::close() }}
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            {{--@php--}}

                            {{--foreach ($brands_product as $pro){--}}
                                {{--$product_id[] = $pro->id;--}}
                            {{--}--}}
                            {{----}}
                            {{--$tags = \App\ProductTag::join('tags', 'product_tags.tag_id', '=', 'tags.id')--}}
                                                      {{--->whereIn('product_tags.product_id',$product_id)--}}
                                                      {{--->select('tags.*')--}}
                                                      {{--->get();--}}

                              {{--foreach ($tags as $pro){--}}
                                {{--$tag_id[] = $pro->id;--}}
                            {{--}--}}
                           {{--$tagname = \App\Tags::whereIn('id',$tag_id)->get();--}}

                            {{--@endphp--}}

                            {{--<div>--}}
                                {{--<level><strong style="color:black">Tags</strong>--}}
                                    {{--@foreach($tagname as $val)--}}
                                        {{--<li><a href="{{ route('tag.product', $val->id) }}"><strong> {{ $val->tag_name}}</strong></a></li>--}}
                                    {{--@endforeach--}}
                                {{--</level>--}}

                            {{--</div><!-- End .widget -->--}}






                            <div class="widget widget-featured">
                                <h3 class="widget-title">Featured Products</h3>

                                <div class="widget-body"><div class="owl-carousel widget-featured-products">
                                        <div class="featured-col">

                                             @foreach($products as $row)
                                                @php
                                                    $name=  str_replace(' ', '-', $row->name);
                                                      $image =  $row->image;
                                                        $image = explode(',',$image);
                                                        $first_image = $image[0];
                                                @endphp

                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">
                                                        <img src="{{ url('public/images/product',$first_image) }}">
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h2 class="product-title">
                                                        <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">{{ $row->name }}</a>
                                                    </h2>
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
                                                    <div class="price-box">
                                                        <span class="product-price">???{{ $row->price }}</span>
                                                    </div><!-- End .price-box -->
                                                </div><!-- End .product-details -->
                                            </div>
                                            @endforeach

                                        </div><!-- End .featured-col -->

                                        <div class="featured-col">
                                             @foreach($next_products as $row)
                                                @php
                                                    $name=  str_replace(' ', '-', $row->name);
                                                      $image =  $row->image;
                                                        $image = explode(',',$image);
                                                        $first_image = $image[0];
                                                @endphp
                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">
                                                        <img src="{{ url('public/images/product', $first_image) }}">
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h2 class="product-title">
                                                        <a href="{{ route('eshop-details',['id' => $row->id, 'name' => $name ]) }}">{{ $row->name }}</a>
                                                    </h2>
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

                                                    <div class="price-box">
                                                        <span class="product-price">???{{ $row->price }}</span>
                                                    </div><!-- End .price-box -->
                                                </div><!-- End .product-details -->
                                            </div>
                                             @endforeach


                                        </div><!-- End .featured-col -->
                                    </div><!-- End .widget-featured-slider -->
                                </div><!-- End .widget-body -->
                            </div><!-- End .widget -->

                            <div class="widget widget-block">

                            </div><!-- End .widget -->
                        </div><!-- End .sidebar-wrapper -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->


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
                                          <span class="product-price">??? {{ $product_details_info->price }}</span>
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
                                                  <a href="{{ route('eshop-details',['id' => $product_details_info->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>
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
                                      
                                      <!-- <div class="product-action">-->
                                      <!--    <a href="{{ route('eshop-details',['id' => $product_details_info->id, 'name' => $name ]) }}" class="btn-add-cart paction"><i class="fa fa-eye" aria-hidden="true"></i> View Details</a>-->
                                      <!--</div>-->
                                      
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