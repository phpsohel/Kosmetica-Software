<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Kosmetica Bangladesh</title>
    <meta name="keywords" content="HTML5 Template" />
    <meta name="description" content="Porto - Bootstrap eCommerce Template">
    <meta name="author" content="SW-THEMES">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('/') }}public/assets/frontend/images/icons/logo.png">

    <script type="text/javascript">
        WebFontConfig = {
            google: { families: [ 'Open+Sans:300,400,600,700,800','Poppins:300,400,500,600,700','Segoe Script:300,400,500,600,700' ] }
        };
        (function(d) {
            var wf = d.createElement('script'), s = d.scripts[0];
            wf.src = '{{ asset('/') }}public/assets/frontend/js/webfont.js';
            wf.async = true;
            s.parentNode.insertBefore(wf, s);
        })(document);
    </script>

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="{{ asset('/') }}public/assets/frontend/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="{{ asset('/') }}public/assets/frontend/css/style.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('/') }}public/assets/frontend/vendor/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        @font-face {
            font-family: "CenturyGothic";
            src: url("{{ asset('/') }}public/assets/frontend/fonts/CenturyGothic.eot");
            src: url("{{ asset('/') }}public/assets/frontend/fonts/CenturyGothic.woff") format("woff"),
            url("{{ asset('/') }}public/assets/frontend/fonts/CenturyGothic.otf") format("opentype"),
            url("{{ asset('/') }}public/assets/frontend/fonts/CenturyGothic.svg#filename") format("svg");
        }
        body, h1, h2, h3, h4, .nav.nav-tabs .nav-item .nav-link, .btn, .footer .widget-title, .contact-info-label, .product-default .btn-add-cart{
            font-family: "CenturyGothic";
        }
        .product-default .product-title {
            max-width: 100%;
            font-family: "CenturyGothic";
            text-align: -webkit-center;
        }
        .welcome-msg::after {
            border-right: none;
        }
        .footer-top {
            border-bottom: 1px solid #101010;
        }
        .footer-bottom {
            padding-bottom: 2.2rem;
        }
        p {
            line-height: 25px;
            text-align: justify;
        }
        .nav.nav-tabs .nav-item .nav-link.active {
            color: #d1223e;
            border-bottom-color: #d1223e;
        }
        .nav.nav-tabs .nav-item .nav-link:hover, .paction, .widget-info i {
            color: #d1223e;
        }
        .btn-primary {
            border-color: #d1223e;
            background-color: #d1223e;
            color: #fff;
            box-shadow: none;
        }
        .product-default:hover .btn-add-cart {
            background-color: #d1223e;
            border-color: #d1223e;
            color: white;
        }
        .menu>li:hover>a, .menu>li.show>a, .menu>li.active>a, a {
            color: #d1223e;
        }
        @media screen and (min-width: 700px) {
          .header-search .header-search-wrapper {
            width:55%;

            }
        }
        .footer{
            margin-top: 50px;
        }

        .sidebar-shop{
            display: none;
        }
        .header {
            border-top: 0.3rem solid white !important;
        }
        .btn-primary:hover, .footer .social-icon:hover {
            border-color: #000000 !important;
            background-color: #000000 !important;
        }
        .quick-view:hover, .add-wishlist:hover, .paction:hover {
            border-color: #d1223e !important;
            background-color: #d1223e !important;
        }
        .product-default a:hover {
            color: #000000 !important;
        }

        .product-title:hover{
            color:black;
        }
        .menu.sf-arrows>li>a.sf-with-ul::before{
            background-color: #d1223e !important;
        }
        a:hover, a:focus {
            color: #000000;
            text-decoration: none;
        }
        .product-single-details .product-price {
            color: #d1223e !important;
        }
        .menu>li.active>a {
            border-bottom: 2px solid;
        }
        .dropdownmenu-wrapper {
            border-top-color: #cb253f !important;
        }
        .product-default a {
            white-space: unset;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .old-price{
            text-decoration-color: #d1223e;
        }
        .promotional-price{
            color: #d1223e;
            font: 600 1.8rem/0.8 "Open Sans",sans-serif;
        }
        /*Language*/
        .btn-secondary:not(:disabled):not(.disabled):active, .btn-secondary:not(:disabled):not(.disabled).active, .show>.btn-secondary.dropdown-toggle {
            border-color: #1c1c1c;
            background-color: #CB253F!important;
            color: #fff;
        }
        .btn-secondary {
            border-color: #3c3c3c;
            background-color:  #CB253F!important;
            color: #fff;
            box-shadow: none;
        }
        .btn {
            padding: 5px 15px;
            font-size: 1.4rem;
            line-height: 1.5;
            font-family: "Oswald",sans-serif;
            letter-spacing: .1rem;
            text-transform: lowercase;
            border-radius: 0;
            min-width: 90px;
            transition: all .3s;
        }

    </style>

</head>
<body>
    <div class="page-wrapper">
        <header class="header">
            <div class="header-top">
                <div class="container">
                     <div class="header-center">
                         <p class="welcome-msg">WELCOME TO OUR STORE ! </p>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Language
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="http://223.27.94.123/kosmetica/eshop">English</a>
                            <a class="dropdown-item" href="http://223.27.94.123/kosmetica/eshop/ar">Arabic</a>
                        </div>
                    </div>
                </div><!-- End .container -->
            </div><!-- End .header-top -->

            <div class="header-middle">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler" type="button">
                            <i class="icon-menu"></i>
                        </button>
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button"><i class="icon-magnifier"></i></a>
                            <form action="{{ route('search') }}" method="post">
                                @csrf
                                <div class="header-search-wrapper">
                                    <input type="search" class="form-control" name="search" id="q" placeholder="Search..." required>
                                    {{--<div class="select-custom">--}}
                                        {{--<select id="cat" name="cat">--}}
                                            {{--<option value="">All Categories</option>--}}
                                            {{--<option value="4">Fashion</option>--}}
                                        {{--</select>--}}
                                    {{--</div><!-- End .select-custom -->--}}
                                    <button class="btn" type="submit"><i class="icon-magnifier"></i></button>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                    </div><!-- End .header-left -->

                    <div class="header-center">
                        <a href="{{route('eshop')}}" class="logo">
                            <img src="{{ asset('/') }}public/assets/frontend/images/logo.png" style="max-width:250px;" alt="Kosmetica">
                        </a>
                    </div><!-- End .headeer-center -->

                    <div class="header-right">
                         @php
                            $session = \Session::getId();
                    $quantity = App\Cart::where('user_ip', request()->ip())->where('session',$session)->sum('product_quantity');
                        @endphp
                        <div class="dropdown cart-dropdown">
                            <a href="{{ route('cart-page') }}" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                @if($quantity)
                                    <span class="cart-count">{{ $quantity }}</span>
                                @endif
                            </a>
                            @if($carts->count()>0)
                            <div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-products">
                                        @foreach($carts as $row)
                                            @php
                                                     $name=  str_replace(' ', '-', $row->product->name);
                                                    $image =  $row->product->image;

                                                      $image = explode(',',$image);
                                                      $first_image = $image[0];
                                            @endphp
                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <a href="{{ route('eshop-details.ar',['id' => $row->product->id, 'name' => $name ]) }}">{{ $row->product->name }}</a>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty">{{  $row->product_quantity }}</span>
                                                    x ৳{{ $row->product_price }}
                                                </span>
                                            </div><!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <a href="{{ route('eshop-details.ar',['id' => $row->product->id, 'name' => $name ]) }}" class="product-image">
                                                    <img src="{{ url('public/images/product', $first_image) }}" alt="product">
                                                </a>
                                                <a href="{{ route('cart-destroy-master', $row->id) }}" class="btn-remove" title="Remove Product"><i class="icon-cancel"></i></a>
                                            </figure>
                                        </div><!-- End .product -->
                                        @endforeach


                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>Total</span>

                                        <span class="cart-total-price">৳{{$subtotal}}</span>
                                    </div><!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action">
                                        <a href="{{ route('cart-page') }}" class="btn">View Cart</a>
                                        <!-- <a href="#" class="btn">Checkout</a> -->
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                            @else
                             <div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-products">

                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>No products in the cart.</span>

                                    </div><!-- End .dropdown-cart-total -->

                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                            @endif
                        </div><!-- End .dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->

            @php
                $catgor_id = App\Category::where('name', 'Body Care')->first()->id;
                $body_care_cat = App\Category::where('parent_id', $catgor_id)->get();

                $categor_id = App\Category::where('name', 'Hair Care')->first()->id;
                $hair_care_cat = App\Category::where('parent_id', $categor_id)->get();

                $categor_id = App\Category::where('name', 'Scalp Care')->first()->id;
                $scalp_care_cat = App\Category::where('parent_id', $categor_id)->get();

                $catmakeup_id = App\Category::where('name', 'Make Up')->first()->id;
                $make_up = App\Category::where('parent_id', $catmakeup_id)->get();

                $routines = App\Tags::where('tag_parent_name','Routine')->get();
                $ingredients = App\Tags::where('tag_parent_name','Ingredient')->get();
                $skin_issues = App\Tags::where('tag_parent_name','Skin Issue')->get();




            @endphp

            <div class="header-bottom sticky-header">
                <div class="container">
                    <nav class="main-nav">
                        <ul class="menu sf-arrows">
                            <li class="{{ (request()->segment(2) == '') ? 'active' : '' }}"><a href="{{route('eshop')}} "><i class="fa fa-home" aria-hidden="true"></i></a></li>
                             <li class="{{ (request()->segment(2) == 'offer') ? 'active' : '' }}"><a href="{{route('eshop-offer')}}"> Offers</a></li>
                            <li class="{{ (request()->segment(2) == 'right') ? 'active' : '' }}"><a href="{{route('right.now')}}">Right Now</a></li>
                            <li class="{{ (request()->segment(2) == 'brands-product') ? 'active' : '' }}">
                                <a href="#">Brands</a>
                                <div class="megamenu megamenu-fixed-width">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-lg-3">
                                              @for( $i=0; $i< count($brands);$i++)
                                                  @php
                                                      $name=  str_replace(' ', '-', $brands[$i]->title);
                                                  @endphp
                                               @php if($i!=0 && $i%5==0){ echo '</div><div class="col-lg-3">';} @endphp
                                                    <div class=""><a href="{{ route('brands-product_name',['id' => $brands[$i]->id, 'name' => $name ]) }}">{{ $brands[$i]->title }}</a>
                                                    </div>

                                                 <!-- End .col-lg-6 -->
                                               @endfor
                                               <div style="padding: 0px 5px; background: #cb253f;"><a href="{{ route('brands-product-other') }}" style="color:white;"> Others >> </a>
                                                    </div>

                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-8 -->

                                    </div>
                                </div><!-- End .megamenu -->

                            </li>
                            {{--<li class="megamenu-container {{ (request()->segment(1) == '') ? 'active' : '' }}"><a href="{{ route('eshop') }}#skin_care_section">Skin Care</a></li>--}}

                            <li class="{{ (request()->segment(2) == 'category-product') ? 'active' : '' }}">
                                <a href="#" class="sf-with-ul">Skin Care</a>
                                <ul>
                                    <li><a href="#">ROUTINE</a>

                                        <ul>
                                            @for( $i=0; $i< count($routines);$i++)
                                                @php
                                                    $name=  str_replace(' ', '-', $routines[$i]->tag_name);
                                                @endphp
                                                <li><a href="{{ route('tag-product_name',['id' => $routines[$i]->id, 'name' => $name ]) }}">{{ $routines[$i]->tag_name }}</a></li>
                                            @endfor
                                        </ul>
                                    </li>
                                    <li><a href="#">INGREDIENTS</a>

                                        <ul>
                                            @for( $i=0; $i< count($ingredients);$i++)
                                                @php
                                                    $name=  str_replace(' ', '-', $ingredients[$i]->tag_name);
                                                     $name=  str_replace('/', '-', $name);
                                                @endphp
                                                <li><a href="{{ route('tag-product_name',['id' => $ingredients[$i]->id, 'name' => $name ]) }}">{{ $ingredients[$i]->tag_name }}</a></li>
                                            @endfor
                                        </ul>
                                    </li>
                                    <li><a href="#">SKIN ISSUE</a>
                                        <ul>
                                            @for( $i=0; $i< count($skin_issues);$i++)
                                                @php
                                                    $name=  str_replace(' ', '-', $skin_issues[$i]->tag_name);
                                                @endphp
                                                <li><a href="{{ route('tag-product_name',['id' => $skin_issues[$i]->id, 'name' => $name ]) }}">{{ $skin_issues[$i]->tag_name }}</a></li>
                                            @endfor
                                        </ul>
                                    </li>
                                </ul>
                            </li>


                            <li class="{{ (request()->segment(2) == 'category-product') ? 'active' : '' }}">
                               <a href="#" class="sf-with-ul">Body & Hair</a>
                               <ul>
                                        <li><a href="#">Body Care</a>

                                            <ul>
                                                @for( $i=0; $i< count($body_care_cat);$i++)
                                                    @php
                                                        $name=  str_replace(' ', '-', $body_care_cat[$i]->name);
                                                    @endphp
                                                <li><a href="{{ route('category-product_name',['id' => $body_care_cat[$i]->id, 'name' => $name ]) }}">{{ $body_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                        <li><a href="#">Hair Care</a>

                                            <ul>
                                                @for( $i=0; $i< count($hair_care_cat);$i++)
                                                    @php
                                                        $name=  str_replace(' ', '-', $hair_care_cat[$i]->name);
                                                    @endphp
                                                <li><a href="{{ route('category-product_name',['id' => $hair_care_cat[$i]->id, 'name' => $name ]) }}">{{ $hair_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                        <li><a href="#">Scalp Care</a>
                                            <ul>
                                                @for( $i=0; $i< count($scalp_care_cat);$i++)
                                                    @php
                                                        $name=  str_replace(' ', '-', $scalp_care_cat[$i]->name);
                                                    @endphp
                                                    <li><a href="{{route('category-product__name_hair_scalp',['id' => $scalp_care_cat[$i]->id, 'name' => $name ]) }}">{{ $scalp_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Make Up</a>
                                <div class="megamenu megamenu-fixed-width">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                              @for( $i=0; $i< count($make_up);$i++)
                                                    @php
                                                        $name=  str_replace(' ', '-', $make_up[$i]->name);
                                                    @endphp
                                                <div class="col-lg-3">
                                                    <div class=""><a href="{{ route('category-product_name', ['id' => $make_up[$i]->id, 'name' => $name ]) }}">{{ $make_up[$i]->name }}</a>
                                                    </div>

                                                </div><!-- End .col-lg-6 -->
                                               @endfor
                                            </div><!-- End .row -->
                                        </div><!-- End .col-lg-8 -->

                                    </div>
                                </div><!-- End .megamenu -->

                            </li>
                            <li class="{{ (request()->segment(2) == 'mini-shop') ? 'active' : '' }}"><a href="{{ route('eshop-mini-shop') }}">Mini Shop</a></li>
                            <li class="{{ (request()->segment(2) == 'blogs') ? 'active' : '' }}"><a href="{{ route('eshop-blogs') }}">Blog</a></li>
                            <li class="float-right"><a href="{{ route('right.now') }}">Card</a></li>
                            <li class="{{ (request()->segment(2) == 'contact') ? 'active' : '' }}"><a href="{{ route('contact') }}">Contact Us</a></li>
                        </ul>
                    </nav>
                </div><!-- End .header-bottom -->
            </div><!-- End .header-bottom -->
        </header><!-- End .header -->

        @yield('home_content')
        <footer class="footer" style="padding-top: 50px;">
            <div class="footer-top">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <div class="widget widget-about">
                                <h4 class="widget-title">About Us</h4>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla tristique augue eget enim feugiat blandit. Phasellus bibendum ex leo, at egestas lacus pellentesque in x leo, at egestas lacus.</p>
                                <div class="social-icons">
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a>
                                </div><!-- End .social-icons -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-7 -->

                        @php
                            $footer = \App\GeneralSetting::first();
                        @endphp

                        <div class="col-lg-5">
                            <div class="widget">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4 class="widget-title">Contact Info</h4>
                                        <ul class="contact-info">
                                            <li>
                                                <span class="contact-info-label">Address:</span>{{$footer->address}}
                                            </li>
                                        </ul>
                                    </div><!-- End .col-md-6 -->

                                    <div class="col-md-6">
                                        <ul class="contact-info">
                                            <li>
                                                <span class="contact-info-label">Phone:</span> {{$footer->phone}}
                                            </li>
                                            <li>
                                                <span class="contact-info-label">Email:</span> {{$footer->email}}
                                            </li>
                                        </ul>
                                    </div><!-- End .col-md-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-5 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-top -->

            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="links">
                                            <li><a href="{{ route('contact') }}">Contact Us</a></li>
                                            @if(!Auth::check())
                                            <li><a href="{{ route('eshop-login') }}">Login</a></li>
                                            @endif

                                             @if(Auth::check())
                                                <li><a href="{{ route('eshop-profile') }}">My Account</a></li>
                                             @else
                                                <li><a href="{{ route('eshop-login') }}">My Account</a></li>
                                             @endif

                                            @if(Auth::check())
                                                <li><a href="{{ route('orders') }}">Orders History</a></li>
                                            @else
                                                <li><a href="{{ route('eshop-login') }}">Orders History</a></li>
                                            @endif

                                            @if(Auth::check())
                                                <li><a href="{{ route('my_wishlist') }}">Wishlist</a></li>
                                            @else
                                                <li><a href="{{ route('eshop-login') }}">Wishlist</a></li>
                                            @endif

                                            @if(Auth::check())
                                            <li><a href="{{ route('customer-logout') }}">Logout</a></li>
                                            @endif


                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-4 -->
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Brands</h4>
                                 @php
                                    $brands = App\Brand::orderBy('id', 'DESC')
                                                            ->where('title','!=','Invisible')
                                                            ->limit(5)
                                                            ->get();

                                  $catmakeup_id = App\Category::where('name', 'Make Up')->first()->id;
                                   $parent_makeup = App\Category::where('parent_id', $catmakeup_id)->limit(5)->get();
                                @endphp
                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="links">
                                             @foreach($brands as $key)
                                                    <li><a href="{{ route('brands-product', $key->id) }}">{{ $key->title }}</a></li>
                                                    @endforeach
                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-4 -->
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Make Up</h4>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <ul class="links">
                                           @foreach($parent_makeup as $row)
                                               <li> <a href="{{ route('all-categories', $row->id) }}">{{ $row->name }}</a></li>
                                              @endforeach

                                        </ul>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-4 -->
                        <div class="col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Payment Methods</h4>

                                <div class="row">
                                    <div class="col-sm-12">
                                        <img src="{{ asset('/') }}public/images/payment/payments.png" style="max-width:250px;" alt="Kosmetica">
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-3">

                        </div><!-- End .col-lg-4 -->
                        @php
                            $time = Carbon\Carbon::now();
                            $year =  $time->year;
                        @endphp

                        <div class="col-lg-6 text-center">
                            <p style="text-align: center;" class="footer-copyright">{{$footer->site_title}}. © {{$year}}. All Rights Reserved</p>
                        </div><!-- End .col-lg-5 -->

                        <div class="col-lg-3">

                        </div><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->

    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->
    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-cancel"></i></span>
            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li class="active"><a href="{{route('eshop')}}">Home</a></li>
                     <li><a href="{{route('eshop-offer')}}"> Offers</a></li>
                    <li><a href="{{route('right.now')}}">Right Now</a></li>

                    @php
                        $mobile_brands = App\Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
                        //Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
                    @endphp

                    <li>
                        <a href="#">Brands</a>
                        <div class="megamenu megamenu-fixed-width">
                            <div class="row">
                                        <div class="col-lg-6">
                                            <ul>
                                                @for( $i=0; $i< count($mobile_brands);$i++)
                                                    <li> <a href="{{ route('brands-product', $mobile_brands[$i]->id) }}">{{ $mobile_brands[$i]->title }}</a></li>
                                                @endfor
                                                <li> <a href="{{ route('brands-product-other') }}">OTHERS >> </a></li>
                                            </ul>
                                        </div><!-- End .col-lg-6 -->
                            </div>
                        </div><!-- End .megamenu -->
                    </li>
                    {{--<li class="megamenu-container"><a href="{{ route('eshop') }}#skin_care_section">Skin Care</a></li>--}}

                    <li class="{{ (request()->segment(2) == 'category-product') ? 'active' : '' }}">
                        <a href="#" class="sf-with-ul">Skin Care</a>
                        <ul>
                            <li><a href="#">ROUTINE</a>

                                <ul>
                                    @for( $i=0; $i< count($routines);$i++)
                                        <li><a href="{{route('tag-product', $routines[$i]->id) }}">{{ $routines[$i]->tag_name }}</a></li>
                                    @endfor
                                </ul>
                            </li>
                            <li><a href="#">INGREDIENTS</a>

                                <ul>
                                    @for( $i=0; $i< count($ingredients);$i++)
                                        <li><a href="{{route('tag-product', $ingredients[$i]->id) }}">{{ $ingredients[$i]->tag_name }}</a></li>
                                    @endfor
                                </ul>
                            </li>
                            <li><a href="#">SKIN ISSUE</a>
                                <ul>
                                    @for( $i=0; $i< count($skin_issues);$i++)
                                        <li><a href="{{route('tag-product', $skin_issues[$i]->id) }}">{{ $skin_issues[$i]->tag_name }}</a></li>
                                    @endfor
                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li>
                        <a href="#">Body & Hair</a>
                        <div class="megamenu megamenu-fixed-width">
                            <div class="row">
                                <div class="col-lg-6">
                                    <ul>
                                        <li><a href="#">Body CARE</a>
                                            <ul>
                                                @for( $i=0; $i< count($body_care_cat);$i++)
                                                <li><a href="{{route('category-product', $body_care_cat[$i]->id) }}">{{ $body_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                        <li><a href="#">HAIR CARE</a>
                                            <ul>
                                                @for( $i=0; $i< count($hair_care_cat);$i++)
                                                <li><a href="{{route('category-product', $hair_care_cat[$i]->id) }}">{{ $hair_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                        <li><a href="#">SCALP CARE</a>
                                            <ul>
                                                @for( $i=0; $i< count($scalp_care_cat);$i++)
                                                <li><a href="{{route('category-product_hair_scalp', $scalp_care_cat[$i]->id) }}">{{ $scalp_care_cat[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </li>
                                    </ul>
                               </div><!-- End .col-lg-6 -->
                            </div>
                        </div><!-- End .megamenu -->
                    </li>

                    <li>
                        <a href="#">Make Up</a>
                        <div class="megamenu megamenu-fixed-width">
                            <div class="row">
                                        <div class="col-lg-6">
                                            <ul>
                                                @for( $i=0; $i< count($make_up);$i++)
                                                    <li> <a href="{{ route('category-product', $make_up[$i]->id) }}">{{ $make_up[$i]->name }}</a></li>
                                                @endfor
                                            </ul>
                                        </div><!-- End .col-lg-6 -->
                            </div>
                        </div><!-- End .megamenu -->
                    </li>
                    <li><a href="{{ route('eshop-mini-shop') }}">Mini Shop</a></li>
                    <li><a href="{{ route('eshop-blogs') }}">Blog</a></li>
                    <li><a href="{{ route('right.now') }}">Card</a></li>
                    <li><a href="{{ route('contact') }}">Contact Us</a></li>
                </ul>
            </nav><!-- End .mobile-nav -->



            <div class="social-icons">
                <a href="https://www.facebook.com/AcquaintTechnologies/" class="social-icon" target="_blank"><i class="icon-facebook"></i></a>
                <a href="https://twitter.com/acquain02282636" class="social-icon" target="_blank"><i class="icon-twitter"></i></a>
                <!-- <a href="#" class="social-icon" target="_blank"><i class="icon-instagram"></i></a> -->
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->


    <!-- Add Cart Modal -->
    <div class="modal fade" id="addCartModal" tabindex="-1" role="dialog" aria-labelledby="addCartModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
            <p>You've just added product to the<br>cart</p>

            <div class="btn-actions">
                <a href="{{ route('cart-page') }}"><button class="btn-primary">Go to cart page</button></a>
                <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Newsletter Modal -->
    <div style="width: 50%;margin: auto" class="modal fade" id="newsletterModal" tabindex="-1" role="dialog" aria-labelledby="newsletterModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content" >
          <div class="modal-body add-cart-box text-center">
            <h4 style="text-align: center;">Thanks For the Subscription</h4>
            <div class="btn-actions">
                <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>
     <!-- clearCartModal Modal -->
    <div class="modal fade" id="clearCartModal" tabindex="-1" role="dialog" aria-labelledby="clearCartModal" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
            <p>Your Cart is Empty!</p>

            <div class="btn-actions">

                <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>

     <!-- clearCart Modal -->
    <div class="modal fade" id="clearCart" tabindex="-1" role="dialog" aria-labelledby="clearCart" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
            <p>Your Cart is Empty!</p>

            <div class="btn-actions">

                <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>


     <!-- qtyUpdate Modal -->
    <div class="modal fade" id="qtyUpdate" tabindex="-1" role="dialog" aria-labelledby="qtyUpdate" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-body add-cart-box text-center">
            <p>Quantity Update!</p>

            <div class="btn-actions">

                <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Continue</button></a>
            </div>
          </div>
        </div>
      </div>
    </div>





    <!-- Add Cart Modal -->
    <div class="modal fade" id="addWishlistLoginModal" tabindex="-1" role="dialog" aria-labelledby="addWishlistLoginModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width: 500px; margin: auto">
                <div class="modal-body add-cart-box text-center">
                    <p>You've just login before add to the <br>Wishlist</p>

                    <div class="btn-actions">
                        <a href="{{ route('eshop-login') }}"><button class="btn-primary">Login</button></a>
                        <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Cart Modal -->
    <div class="modal fade" id="addWishlistModal" tabindex="-1" role="dialog" aria-labelledby="addWishlistModal" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content" style="max-width: 500px; margin: auto">
                <div class="modal-body add-cart-box text-center" >
                    <p style="text-align: center;font-weight: bold">You've just added product to your
                        Wishlist</p>

                    <div class="btn-actions">
                        <a href="{{ route('eshop-profile') }}"><button class="btn-primary"> Wishlist</button></a>
                        <a href="{{ route('eshop') }}"><button class="btn-primary" data-dismiss="modal">Cancel</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <a id="scroll-top" href="#top" role="button"><i class="icon-angle-up"></i></a>

    <!-- Plugins JS File -->
    <script src="{{ asset('/') }}public/assets/frontend/js/jquery.min.js"></script>
    <script src="{{ asset('/') }}public/assets/frontend/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('/') }}public/assets/frontend/js/plugins.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('/') }}public/assets/frontend/js/main.min.js"></script>

    <script type="text/javascript">
        $('#editor').html($('#editorCopy').val());
        $('#editor1').html($('#editorCopy1').val());
        $('#postSubmit').click(function () {
             $('#editorCopy').val($('#editor').html());
        });
    </script>

    <!-- Google Map-->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDc3LRykbLB-y8MuomRUIY0qH5S6xgBLX4"></script>
    <script src="{{ asset('/') }}public/assets/frontend/js/map.js"></script>

    <!-- range slider -->
    <script src="{{ asset('/') }}public/assets/frontend/js/nouislider.min.js"></script>

     <!-- www.addthis.com share plugin -->
    <script src="https://s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5b927288a03dbde6"></script>




    @if(!empty(Session::get('modal')) && Session::get('modal') == 5)
        <script>
            $(function() {
                $('#addCartModal').modal('show');
            });
        </script>
    @endif

    @if(!empty(Session::get('clear_cart')) && Session::get('clear_cart') == 5)
    <script>
        $(function() {
            $('#clearCartModal').modal('show');
        });
    </script>
    @endif

    @if(!empty(Session::get('newsletter_modal')) && Session::get('newsletter_modal') == 1)
    <script>
        $(function() {
            $('#newsletterModal').modal('show');
        });
    </script>
    @endif

    @if(!empty(Session::get('clear')) && Session::get('clear') == 4)
    <script>
        $(function() {
            $('#clearCart').modal('show');
        });
    </script>
    @endif

     @if(!empty(Session::get('qty_update')) && Session::get('qty_update') == 5)
    <script>
        $(function() {
            $('#qtyUpdate').modal('show');
        });
    </script>
    @endif



    @if(!empty(Session::get('wishlist_login')) && Session::get('wishlist_login') == 6)
        <script>
            $(function() {
                $('#addWishlistLoginModal').modal('show');
            });
        </script>
    @endif

    @if(!empty(Session::get('wishlist')) && Session::get('wishlist') == 7)
        <script>
            $(function() {
                $('#addWishlistModal').modal('show');
            });
        </script>
    @endif


    @if(!empty(Session::get('quick_view')) && Session::get('quick_view') == 9)
        <script>
            $(function() {
                $('#quickviewModal').modal('show');
            });
        </script>
    @endif


     <script>
        $(".input").on('input', function(){
            var shipping_cost = document.getElementById('shipping_cost').value;
            shipping_cost = parseFloat(shipping_cost);
            // alert('aaa');
            // alert(shipping_cost);

            var subtotal = document.getElementById('subtotal').value;
            subtotal = parseFloat(subtotal);



             var order_total = document.getElementById('order_total').value = shipping_cost + subtotal;
             // order_total = parseFloat(order_total);
            // alert(order_total);
        });
    </script>


</body>
</html>
