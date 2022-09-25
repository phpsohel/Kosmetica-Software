@extends('layout.website')
@section('home_content')
<style>
    .ratings-table tbody td {
     border-right: none !important; 
     border-bottom: none !important;
    }
</style>
    @php
  //  dd($product->category_id);
         $cat_name = \App\Category::where('id',$product->category_id)->first();
    @endphp
 <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="{{ route('all-categories',$product->category_id) }}">{{$cat_name->name}}</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$product->name}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

     @php
         $image =  $product->image;
         //dd($image);
         $images = explode(',',$image);
     @endphp
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-single-container product-single-default">
                            <div class="row">
                                <div class="col-lg-5 col-md-6">
                                    <div class="product-single-gallery">
                                        <div class="product-slider-container product-item">
                                            <div class="product-single-carousel owl-carousel owl-theme">
                                                @foreach($images as $image)
                                                <div class="product-item">
                                                    <img class="product-single-image" src="{{ url('public/images/product', $image) }}" data-zoom-image="{{ url('public/images/product', $image) }}"/>
                                                </div>
                                                @endforeach
                                            </div>
                                            <!-- End .product-single-carousel -->
                                            <span class="prod-full-screen">
                                                <i class="icon-plus"></i>
                                            </span>
                                        </div>
                                        <div class="prod-thumbnail row owl-dots" id='carousel-custom-dots'>
                                            @foreach($images as $image)
                                            <div class="col-3 owl-dot">
                                                <img src="{{ url('public/images/product', $image) }}"/>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div><!-- End .product-single-gallery -->
                                </div><!-- End .col-lg-7 -->

                                @php
                                    $comments = \App\Review::where('product_id',$product->id)->where('comment' ,'!=', null)->orderBy('id','DESC')->get();
                                @endphp
                                 @if($product->brand_id != null)

                                    @php
                                      $brand_name = \App\Brand::where('id',$product->brand_id)->first();
        
                                       // dd($brand_name);
                                  @endphp
        
                                  @endif
                                <div class="col-lg-7 col-md-6">
                                    <div class="product-single-details">
                                        <p style='font-weight:bold;margin-bottom:0px;'><a href="{{ route('brands-product', $product->brand_id) }}">{{ $brand_name->title }}</a> </p>
                                        <span style="font-size: 20px;" class="product-title">{{$product->name}}</span>
                                        <br>
                                        @php
                                            $full_rating = 0 ;
                                            $rating = \App\Review::where('product_id',$product->id)->select('ratings')->get();
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
                                            @if($product->promotion == null && $product->promotion_price == null)
                                             <span class="product-price">৳{{$product->price}}</span>
                                             @else
                                            <span class="old-price">৳{{$product->price}}</span>
                                            <span class="product-price">৳{{$product->promotion_price}}</span>
                                          @endif
                                        </div><!-- End .price-box -->


                                        @php
                                        $stock_available = \App\Product_Warehouse::where('warehouse_id', '!=',2)->where('warehouse_id', '!=',6)->where('product_id',$product->id)->where('qty','>',0 )->get()->count();
                                        @endphp

                                         @if($stock_available == 4)

                                            <p > <bold>Availability : </bold><strong style="color: green">Stock Available</strong></p>
                                        @elseif($stock_available > 0 && $stock_available < 4 )
                                            <p>  <bold>Availability : </bold><strong  style="color: #eb6006"> Limited Stock</strong></p>
                                        @else
                                            <p > <bold>Availability : </bold> <strong style="color: red"> Stock Unavailable</strong></p>
                                        @endif

                                        <div class="product-desc">
                                            <textarea style="display: none;" id="editorCopy" name="body">{{ \Illuminate\Support\Str::limit($product->product_details, 260, '......') }}</textarea>
                                             <textarea style="display: none;" id="editorCopy1" name="body">{{ $product->product_details }}</textarea>

                                        </div><!-- End .product-desc -->

                                        <form action="{{ route('add-cart-quantity', $product->id) }}" method="post">
                                        @csrf
                                        <div class="product-action product-all-icons">
                                            <div class="product-single-qty">
                                                <input class="horizontal-quantity form-control" type="number" value="1" min="1" name="quantity">
                                            </div><!-- End .product-single-qty -->

                                             <input type="hidden" name="product_price" value="{{ $product->price}}">
                                             <input type="hidden" name="promotion_price" value="{{ $product->promotion_price}}">

                                             @if($product->qty > 0)
                                            <button type="submit" class="paction"><i class="icon-bag"></i>ADD TO CART</button>

                                            @else
                                                <button type="reset" class="paction"><i class="icon-bag"></i>BOOKING NOW</button>
                                            @endif

                                            @if(Auth::user() == null)
                                                <a href="{{ route('eshop-wishlist-login-check', $product->id) }}" class=" paction add-wishlist btn-add-login icon-wish" title="Add to Wishlist"></a>
                                            @else
                                                <a href="{{ route('eshop-wishlist', $product->id) }}" class="paction add-wishlist icon-wish" title="Add to Wishlist" ></a>
                                            @endif


                                            {{--<a href="#" class="paction add-wishlist" title="Add to Wishlist"> <span>Add to Wishlist</span> </a>--}}

                                            {{--<a href="#" class="paction add-compare" title="Add to Compare">--}}
                                                {{--<span>Add to Compare</span>--}}
                                            {{--</a>--}}
                                        </div><!-- End .product-action -->
                                    </form>

                                        <div class="product-single-share" style="margin-bottom:30px;">
                                            <label>Share:</label>
                                            <!-- www.addthis.com share plugin-->
                                            <div class="addthis_inline_share_toolbox"></div>
                                        </div><!-- End .product single-share -->
                                    </div><!-- End .product-single-details -->
                                    <div class="product-single-tabs">
                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="product-tab-desc" data-toggle="tab" href="#product-desc-content" role="tab" aria-controls="product-desc-content" aria-selected="true">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="product-tab-tags" data-toggle="tab" href="#product-ingredients-content" role="tab" aria-controls="product-ingredients-content" aria-selected="false">Ingredients</a>
                                </li>
                                <li class="nav-item">
                                     <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-use-content" role="tab" aria-controls="product-use-content" aria-selected="false">How to use</a>
                                 </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-stock-content" role="tab" aria-controls="product-stock-content" aria-selected="false">Available Stock</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="product-tab-reviews" data-toggle="tab" href="#product-reviews-content" role="tab" aria-controls="product-reviews-content" aria-selected="false">Reviews( {{ count($comments) }})</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="product-desc-content" role="tabpanel" aria-labelledby="product-tab-desc">
                                    <div class="product-desc-content">
                                        <div id="editor1"></div>
                                    </div><!-- End .product-desc-content -->
                                </div><!-- End .tab-pane -->


                                <div class="tab-pane fade" id="product-ingredients-content" role="tabpanel" aria-labelledby="product-tab-tags">
                                    <div class="product-ingredients-content">
                                        {!! $product->ingredients  !!}
                                    </div><!-- End .product-tags-content -->
                                </div><!-- End .tab-pane -->


                                <div class="tab-pane fade" id="product-use-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                    <div class="product-use-content">
                                        {!! $product->how_to_use  !!}

                                    </div>
                                </div>



                                <div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                    <div class="product-reviews-content">

                                        <div class="product-reviews-content">
                                            <h3 class="reviews-title">  {{ count($comments) }} @if( count($comments) > 1 ) reviews @else review  @endif  for  <span> {{ $product->name}}</h3>

                                            @foreach($comments as $comment)
                                                @php
                                                    $date = $comment->date;
                                                  $format_date =  \Carbon\Carbon::parse($date)->format('M d ,Y');
                                                @endphp
                                            <div class="comment-list">
                                                <div class="comments">
                                                    <div class="comment-block">
                                                        <div class="comment-header">
                                                            <div class="comment-arrow"></div>

                                                            {{--<div class="ratings-container float-sm-right">--}}
                                                                {{--<div class="product-ratings">--}}
                                                                    {{--<span class="ratings" style="width:60%"></span>--}}
                                                                    {{--<!-- End .ratings -->--}}
                                                                    {{--<span class="tooltiptext tooltip-top"></span>--}}
                                                                {{--</div>--}}
                                                                {{--<!-- End .product-ratings -->--}}
                                                            {{--</div>--}}

                                                            <span class="comment-by">
                                                    <strong>{{$comment->customer->name}}</strong>
                                                        </span>
                                                        </div>

                                                        <div class="comment-content">
                                                            <p>{{ $comment->comment }}</p>
                                                        </div>

                                                       <p> {{ $format_date }}</p>

                                                    </div>
                                                </div>
                                            </div>

                                            @endforeach

                                            <div class="divider"></div>

                                            <div class="add-product-review">
                                                <h3 class="review-title">Add a review</h3>

                                                    @if(Auth::user() == null)
                                                    <span>To add a review ,please login first </span>
                                                    <br>
                                                    <a href="{{ route('eshop-login') }}"><button class=" btn btn-primary">Login</button></a>
                                                    @else
                                                    <form  method="POST" action="{{ route('review.store') }}" class="comment-form m-0">
                                                        @csrf
                                                        <table class="ratings-table">
                                                            <thead>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th>1 star</th>
                                                                <th>2 stars</th>
                                                                <th>3 stars</th>
                                                                <th>4 stars</th>
                                                                <th>5 stars</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <td>Rating</td>
                                                                <td>
                                                                    <input type="radio" name="ratings" id="Quality_1" value="1" class="radio">
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="ratings" id="Quality_2" value="2" class="radio">
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="ratings" id="Quality_3" value="3" class="radio">
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="ratings" id="Quality_4" value="4" class="radio">
                                                                </td>
                                                                <td>
                                                                    <input type="radio" name="ratings" id="Quality_5" value="5" class="radio">
                                                                </td>
                                                            </tr>


                                                            </tbody>
                                                        </table>

                                                        <div class="form-group">
                                                            <label> <strong>Your review</strong> <span class="required">*</span></label>
                                                            <textarea cols="10" rows="6"  name="comment"  class="form-control form-control-sm"></textarea>
                                                        </div>


                                                        <input type="submit" class="btn btn-primary" value="Submit">
                                                        <input type="hidden" name="product_id" value="{{$product->id}}">
                                                    </form>
                                                    @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>


                                @php
                                    $warehouse = \App\Warehouse::where('id','!=',2)->where('id','!=',6)->get();
                                @endphp
                                <div class="tab-pane fade" id="product-stock-content" role="tabpanel" aria-labelledby="product-tab-reviews">
                                    <div class="product-stock-content">
                                        <table style="width: 95%;" class="ratings-table">
                                            <thead>
                                            <tr>
                                                <th>Shop Name</th>
                                                <th>Stock Available</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($warehouse as $value )
                                                @php
                                                 //$warehouse_id[] = $value->id;
                                                 $stock = \App\Product_Warehouse::where('product_id',$product->id)->where('warehouse_id',$value->id)->first();
                                               // dd($stock);
                                                @endphp
                                            <tr>
                                                <td style="text-align: center;">{{ $value->name }} <br> <span style="font-size: 13px; font-weight: 500;">{{ $value->address }}</span> </td>
                                                @if($stock)
                                                @if($stock->qty > 0)
                                                <td> <i class="fa fa-check" style='color:green;' aria-hidden="true"></i></td>
                                                @else
                                                    <td><i class="fa fa-times" style='color:#d1223e;' aria-hidden="true"></i></td>
                                                @endif
                                                    @else
                                                    <td><i class="fa fa-times" style='color:#d1223e;' aria-hidden="true"></i></td>
                                                @endif
                                            </tr>
                                            @endforeach



                                            </tbody>
                                        </table>

                                    </div><!-- End .product-reviews-content -->
                                </div><!-- End .tab-pane -->

                                {{--<div class="tab-pane fade" id="product-reviews-content" role="tabpanel" aria-labelledby="product-tab-reviews">--}}
                                    {{--<div class="product-reviews-content">--}}
                                        {{--<div class="collateral-box">--}}
                                            {{--<ul>--}}
                                                {{--<li>Be the first to review this product</li>--}}
                                            {{--</ul>--}}
                                        {{--</div><!-- End .collateral-box -->--}}

                                        {{--<div class="add-product-review">--}}
                                            {{--<h3 class="text-uppercase heading-text-color font-weight-semibold">WRITE YOUR OWN REVIEW</h3>--}}
                                            {{--<p>How do you rate this product? *</p>--}}

                                            {{--<form action="#">--}}
                                                {{--<table class="ratings-table">--}}
                                                    {{--<thead>--}}
                                                        {{--<tr>--}}
                                                            {{--<th>&nbsp;</th>--}}
                                                            {{--<th>1 star</th>--}}
                                                            {{--<th>2 stars</th>--}}
                                                            {{--<th>3 stars</th>--}}
                                                            {{--<th>4 stars</th>--}}
                                                            {{--<th>5 stars</th>--}}
                                                        {{--</tr>--}}
                                                    {{--</thead>--}}
                                                    {{--<tbody>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Quality</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="ratings[1]" id="Quality_1" value="1" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="ratings[1]" id="Quality_2" value="2" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="ratings[1]" id="Quality_3" value="3" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="ratings[1]" id="Quality_4" value="4" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="ratings[1]" id="Quality_5" value="5" class="radio">--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Value</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="value[1]" id="Value_1" value="1" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="value[1]" id="Value_2" value="2" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="value[1]" id="Value_3" value="3" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="value[1]" id="Value_4" value="4" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="value[1]" id="Value_5" value="5" class="radio">--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                        {{--<tr>--}}
                                                            {{--<td>Price</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="price[1]" id="Price_1" value="1" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="price[1]" id="Price_2" value="2" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="price[1]" id="Price_3" value="3" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="price[1]" id="Price_4" value="4" class="radio">--}}
                                                            {{--</td>--}}
                                                            {{--<td>--}}
                                                                {{--<input type="radio" name="price[1]" id="Price_5" value="5" class="radio">--}}
                                                            {{--</td>--}}
                                                        {{--</tr>--}}
                                                    {{--</tbody>--}}
                                                {{--</table>--}}

                                                {{--<div class="form-group">--}}
                                                    {{--<label>Nickname <span class="required">*</span></label>--}}
                                                    {{--<input type="text" class="form-control form-control-sm" required>--}}
                                                {{--</div><!-- End .form-group -->--}}
                                                {{--<div class="form-group">--}}
                                                    {{--<label>Summary of Your Review <span class="required">*</span></label>--}}
                                                    {{--<input type="text" class="form-control form-control-sm" required>--}}
                                                {{--</div><!-- End .form-group -->--}}
                                                {{--<div class="form-group mb-2">--}}
                                                    {{--<label>Review <span class="required">*</span></label>--}}
                                                    {{--<textarea cols="5" rows="6" class="form-control form-control-sm"></textarea>--}}
                                                {{--</div><!-- End .form-group -->--}}

                                                {{--<input type="submit" class="btn btn-primary" value="Submit Review">--}}
                                            {{--</form>--}}
                                        {{--</div><!-- End .add-product-review -->--}}
                                    {{--</div><!-- End .product-reviews-content -->--}}
                                {{--</div><!-- End .tab-pane -->--}}
                            </div><!-- End .tab-content -->
                        </div><!-- End .product-single-tabs -->
                                </div><!-- End .col-lg-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .product-single-container -->

                        
                    </div><!-- End .col-lg-9 -->


                         @if($product->brand_id != null)

                            @php
                              $brand_name = \App\Brand::where('id',$product->brand_id)->first();

                               // dd($brand_name);
                          @endphp

                          @endif
                  
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="featured-products-section carousel-section">
                <div class="container">
                    <h2 class="h3 title mb-2">Related Products</h2>

                    <div class="featured-products owl-carousel owl-theme">

                        @foreach($all_products as $row)
                            @php
                                $image =  $row->image;
                                  $image = explode(',',$image);
                                  $first_image = $image[0];
                            @endphp
                        <div class="product-default">
                            <figure>
                                <a href="{{ route('eshop-detail', $row->id) }}">
                                    <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: 275px; width: auto; margin: auto;">
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
                                    <a href="{{ route('eshop-detail', $row->id) }}">{{$row->name}}</a>
                                </h2>

                                <div class="price-box">
                                    @if($row->promotion == null && $row->promotion_price == null)
                                        <span class="product-price">৳{{$row->price}}</span>
                                    @else
                                        <span class="old-price">৳{{$row->price}}</span>
                                        <span class="product-price">৳{{$row->promotion_price}}</span>
                                    @endif
                                </div><!-- End .price-box -->

                                {{--<div class="price-box">--}}
                                    {{--<span class="product-price">৳{{ $row->price }}</span>--}}
                                {{--</div><!-- End .price-box -->--}}
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




                    </div><!-- End .featured-proucts -->
                </div><!-- End .container -->
            </div><!-- End .featured-proucts-section -->
        </main><!-- End .main -->

@endsection