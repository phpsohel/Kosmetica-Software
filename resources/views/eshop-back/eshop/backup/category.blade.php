@extends('layout.website')
@section('home_content')
  <main class="main">
            <div class="banner banner-cat" style="background-image: url('{{ asset('/') }}public/assets/frontend/images/sliderbackground.png'); height: 215px;">
                <div class="banner-content container">
                    <!-- <h2 class="banner-subtitle">check out over <span>200+</span></h2> -->
                    <h1 class="banner-title">
                        {{$cat_name->name}}
                    </h1>
                    <!-- <a href="#" class="btn btn-dark">Shop Now</a> -->
                </div><!-- End .banner-content -->
            </div><!-- End .banner -->

            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb mt-0">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="#">Categories</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{$cat_name->name}}</li>
                    </ol>
                </div><!-- End .container -->
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-lg-9">
                        <nav class="toolbox">
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

                            {{--<div class="layout-modes">--}}
                                {{--<a href="#" class="layout-btn btn-grid active" title="Grid">--}}
                                    {{--<i class="icon-mode-grid"></i>--}}
                                {{--</a>--}}
                                {{--<a href="#" class="layout-btn btn-list" title="List">--}}
                                    {{--<i class="icon-mode-list"></i>--}}
                                {{--</a>--}}
                            {{--</div><!-- End .layout-modes -->--}}
                        </nav>

                        <div class="row row-sm">

                            @foreach($product_category as $row)
                                @php


                                    $image =  $row->image;
                                      $image = explode(',',$image);
                                      $first_image = $image[0];
                                @endphp
                            <div class="col-6 col-md-4 col-lg-3 col-xl-3">
                                <div class="product-default">
                                    <figure>
                                        <a href="{{ route('eshop-detail', $row->id) }}">
                                            <img src="{{ url('public/images/product', $first_image) }}" alt="product" style="height: auto; width: auto; margin: auto;">
                                        </a>
                                    </figure>
                                    <div class="product-details">
                                        <div class="price-box" style="display: inline-flex;margin-bottom: 5px;">
                                            <img src="{{ url('public/images/brand', $brands_product[0]->image) }}" alt="product" style="height: 20px; width: auto;">
                                            {{--<span class="product-price">{{ $brands[0]->title }}</span>--}}
                                        </div><!-- End .price-box -->
                                        <div class="cat-box">
                                            <span  style="font-size: 13px;" class="product-cat">{{ $cat_name->name }}</span>
                                        </div><!-- End .price-box -->

                                        <h2 class="product-title">
                                            <a href="{{ route('eshop-detail', $row->id) }}">{{ $row->name }}</a>
                                        </h2>
                                        <div class="price-box">
                                            <span class="product-price">???{{ $row->price }}</span>
                                        </div><!-- End .price-box -->
                                        <div class="ratings-container">
                                            <div class="product-ratings">
                                                <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                <span class="tooltiptext tooltip-top"></span>
                                            </div><!-- End .product-ratings -->
                                        </div><!-- End .product-container -->
                                         <form action="{{ route('add-to-cart', $row->id) }}" method="POST">
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
                                <!-- <label>Showing 1???9 of 60 results</label> -->
                            </div><!-- End .toolbox-item -->
                            <ul class="pagination">
                               {{ $product_category->links() }}
                            </ul>
                        </nav>
                    </div><!-- End .col-lg-9 -->

                    <aside class="sidebar-shop col-lg-3 order-lg-first">
                        <div class="sidebar-wrapper">
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-1" role="button" aria-expanded="true" aria-controls="widget-body-1">{{$cat_name->name}}</a>
                                </h3>

                                <div class="collapse show" id="widget-body-1">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            @if(!$cat_name->parent_id)
                                            @foreach($cat as $row)
                                            @if($row->parent_id == $cat_name->id)
                                            <li><a href="{{ route('all-categories', $row->id) }}">{{ $row->name }}</a></li>
                                            @endif
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->

                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-2" role="button" aria-expanded="true" aria-controls="widget-body-2">Price</a>
                                </h3>
                                <div class="collapse show" id="widget-body-2">
                                    <div class="widget-body">
                                        {!! Form::open(['route' => 'price.filter', 'method' => 'post', 'files' => true]) !!}
                                             <div class="row">
                                                 <input type="hidden" name="cat_id" value="{{ $cat_name->id }}">
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


                            @php

                                 $tagname = [];
                                 $product_id = [];
                                 $tags = [];

                                foreach ($product_category as $pro){
                                    $product_id[] = $pro->id;
                                }

                                if ($product_id){

                                $tags = \App\ProductTag::join('tags', 'product_tags.tag_id', '=', 'tags.id')
                                                          ->whereIn('product_tags.product_id',$product_id)
                                                          ->select('tags.*')
                                                          ->get();
                                }


                                if(count($tags) > 0){

                                  foreach ($tags as $pro){
                                    $tag_id[] = $pro->id;
                                }

                                $tagname = \App\Tags::whereIn('id',$tag_id)->get();
                                }
                            @endphp


                            <div>
                                <level><strong style="color:black">Tags</strong>
                                    @if(count($tagname) > 0 )
                                    @foreach($tagname as $val)
                                        <li><a href="{{ route('tag.product', $val->id) }}"><strong> {{ $val->tag_name}}</strong></a></li>
                                    @endforeach
                                    @endif

                                </level>

                            </div><!-- End .widget -->

                            <!-- <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-3" role="button" aria-expanded="true" aria-controls="widget-body-3">Size</a>
                                </h3>
                               <div class="collapse show" id="widget-body-3">
                                    <div class="widget-body">
                                        <ul class="config-size-list">
                                            <li><a href="#">S</a></li>
                                            <li class="active"><a href="#">M</a></li>
                                            <li><a href="#">L</a></li>
                                            <li><a href="#">XL</a></li>
                                            <li><a href="#">2XL</a></li>
                                            <li><a href="#">3XL</a></li>
                                        </ul>
                                    </div><!-- End .widget-body
                                </div><!-- End .collapse
                            </div> End .widget -->
                            @if($brands_product)
                            <div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-4" role="button" aria-expanded="true" aria-controls="widget-body-4">Brands</a>
                                </h3>
                                <div class="collapse show" id="widget-body-4">
                                    <div class="widget-body">
                                        <ul class="cat-list">
                                            @foreach($brands_product as $row)
                                            <li><a href="{{ route('eshop-brands', [$row->id, $category_id]) }}">{{ $row->title }}
                                             </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div><!-- End .widget-body -->
                                </div><!-- End .collapse -->
                            </div><!-- End .widget -->
                            @endif
                            <!--<div class="widget">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-body-6" role="button" aria-expanded="true" aria-controls="widget-body-6">Color</a>
                                </h3>
                                <div class="collapse show" id="widget-body-6">
                                    <div class="widget-body">
                                        <ul class="config-swatch-list">
                                            <li>
                                                <a href="#" style="background-color: #4090d5;"></a>
                                            </li>
                                            <li class="active">
                                                <a href="#" style="background-color: #f5494a;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #fca309;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #11426b;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #f0f0f0;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #3fd5c9;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #979c1c;"></a>
                                            </li>
                                            <li>
                                                <a href="#" style="background-color: #7d5a3c;"></a>
                                            </li>
                                        </ul>
                                    </div><!-- End .widget-body
                                </div>
                            </div> End .widget -->
                            <div class="widget widget-featured">
                                <h3 class="widget-title">Featured Products</h3>

                                <div class="widget-body"><div class="owl-carousel widget-featured-products">
                                        <div class="featured-col">
                                            @foreach($products as $row)
                                                @php
                                                    $image =  $row->image;
                                                      $image = explode(',',$image);
                                                      $first_image = $image[0];
                                                @endphp
                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="{{ route('eshop-detail', $row->id) }}">
                                                        <img src="{{ url('public/images/product', $first_image) }}">
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h2 class="product-title">
                                                        <a href="{{ route('eshop-detail', $row->id) }}">{{$row->name}}</a>
                                                    </h2>
                                                    <div class="ratings-container">
                                                        <div class="product-ratings">
                                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div><!-- End .product-ratings -->
                                                    </div><!-- End .product-container -->
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
                                               // dd($row);
                                                    $image =  $row->image;
                                                      $image = explode(',',$image);
                                                      $first_image = $image[0];
                                                @endphp
                                            <div class="product-default left-details product-widget">
                                                <figure>
                                                    <a href="{{ route('eshop-detail', $row->id) }}">
                                                        <img src="{{ url('public/images/product',$first_image) }}">
                                                    </a>
                                                </figure>
                                                <div class="product-details">
                                                    <h2 class="product-title">
                                                        <a href="{{ route('eshop-detail', $row->id) }}">{{$row->name}}</a>
                                                    </h2>
                                                    <div class="ratings-container">
                                                        <div class="product-ratings">
                                                            <span class="ratings" style="width:100%"></span><!-- End .ratings -->
                                                            <span class="tooltiptext tooltip-top"></span>
                                                        </div><!-- End .product-ratings -->
                                                    </div><!-- End .product-container -->
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

                            <!--<div class="widget widget-block">
                                <h3 class="widget-title">Custom HTML Block</h3>
                                <h5>This is a custom sub-title.</h5>
                                <p>Lorem ipsum dolor sit amet, consectetur elitad adipiscing Cras non placerat mi. </p>
                            </div>
                            <!-- End .widget -->
                        </div><!-- End .sidebar-wrapper -->
                    </aside><!-- End .col-lg-3 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-5"></div><!-- margin -->
        </main><!-- End .main -->
@endsection