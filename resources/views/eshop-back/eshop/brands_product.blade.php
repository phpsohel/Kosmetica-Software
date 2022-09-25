@extends('layout.website')
@section('home_content')
<style>
      @media  screen and (max-width: 600px) {
          .banner-cat {
            width:100%;
            height:200px !important;
            
            }
        }
        .banner.banner-cat {
        
            height:450px;
        }
        
</style>
  <main class="main">
           <div class="banner banner-cat" style="background-image: url('{{ asset('/') }}public/images/brand/{{$brand_name->image}}');">
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
                                <!-- <label>Showing 1–9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->

                            {{--<div class="layout-modes">--}}
                                {{--<a href="category.html" class="layout-btn btn-grid active" title="Grid">--}}
                                    {{--<i class="icon-mode-grid"></i>--}}
                                {{--</a>--}}
                                {{--<a href="category-list.html" class="layout-btn btn-list" title="List">--}}
                                    {{--<i class="icon-mode-list"></i>--}}
                                {{--</a>--}}
                            {{--</div><!-- End .layout-modes -->--}}
                        </nav>

                        <div class="row row-sm">

                            @foreach($brands_product as $row)
                                @php
                                    $image =  $row->image;
                                      $image = explode(',',$image);
                                      $first_image = $image[0];
                                @endphp
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="{{ route('eshop-detail', $row->id) }}">
                                            <img src="{{ url('public/images/product',$first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        
                                        <div class="cat-box">
                                            <span  style="font-size: 13px;" class="product-cat">{{$brand_name->title}}</span>
                                        </div><!-- End .price-box -->

                                        <h2 class="product-title">
                                            <a href="{{ route('eshop-detail', $row->id) }}">{{ $row->name }}</a>
                                        </h2>
                                        <div class="price-box">
                                            <span class="product-price">৳{{ $row->price }}</span>
                                        </div><!-- End .price-box -->
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                         <form action="{{ route('eshop-detail', $row->id) }}" method="get">
                                    @csrf
                                    <div class="product-action">
                                        <a href="#" class="btn-icon-wish"><i class="icon-heart"></i></a>
                                        <button type="submit" class="btn-icon btn-add-cart"><i class="icon-bag"></i>ADD TO CART</button>
                                        <input type="hidden" name="product_price" value="{{ $row->price}}">
                                        <a href="{{ route('eshop-detail', $row->id) }}" class="btn-quickview" title="Quick View"><i class="fas fa-external-link-alt"></i></a>
                                    </div>
                                </form>
                                    </div><!-- End .product-details -->
                                </div>
                            </div>
                            @endforeach

                        </div>

                        <nav class="toolbox toolbox-pagination">
                            <div class="toolbox-item toolbox-show">
                                <!-- <label>Showing 1–9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->

                            <ul class="pagination">

                            </ul>
                        </nav>
                    </div><!-- End .col-lg-12 -->

                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->

@endsection