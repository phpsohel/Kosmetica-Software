@extends('layout.website')
@section('home_content')
    <main class="main">
        <nav aria-label="breadcrumb" class="breadcrumb-nav">
            <div class="container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                </ol>
            </div><!-- End .container -->
        </nav>

        <div class="container">
            <div class="row">
                <div class="col-lg-9 order-lg-last dashboard-content">
                    <h2>Review Information</h2>
                {{--<div class="row">--}}
                {{--<div class="container-fluid">--}}
                {{--<div class="col-md-12">--}}
                {{--<div class="brand-text float-left mt-4">--}}
                {{--<h3>Hello<span> {{Auth::user()->name }}!</span>   This is Your Orders </h3>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                {{--</div>--}}
                <!-- Counts Section -->
                    <section class="dashboard-counts">

                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card">


                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade show active" id="sale-latest">
                                                <div class="table-responsive">
                                                    <table id="sale-table" class="table">
                                                        <thead>
                                                        <tr>

                                                            <th>Sl</th>
                                                            <th>{{trans('file.date')}}</th>
                                                            <th>Product Name</th>
                                                            <th>Comment</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lims_review_data as $key => $sale)
                                                            <?php


                                                            $products = \App\Product::where('id',$sale->product_id)->orderBy('id','DESC')->first();
                                                            //   dd($products);

                                                            ?>

                                                            <tr>
                                                                <td>{{$key+1}}</td>
                                                                <td>{{ date($general_setting->date_format, strtotime($sale->date)) }}</td>
                                                                <td>{{$products->name}}</td>
                                                               <td>{!! $sale->comment !!}</td>
                                                            </tr>
                                                        @endforeach
                                                        </tbody>
                                                        <tfoot class="tfoot active">
                                                        <!--     <tr>

                                                                <th>Total:</th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>
                                                                <th></th>

                                                            </tr> -->
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div><!-- End .col-lg-9 -->

                @php
                    $customer = \App\Customer::select('id')->where('user_id', Auth::id())->first();

                    $lims_wishlist_data = \App\Wishlist::where('customer_id', $customer->id)->orderBy('created_at', 'desc')->count('id');

                @endphp


                <aside class="sidebar col-lg-3">
                    <div class="widget widget-dashboard">
                        <h3 class="widget-title">My Account</h3>

                        <ul class="list">
                            <li class=""><a href="{{ route('eshop-profile') }}">Account Dashboard</a></li>
                            <li><a href="{{ route('edit-profile', Auth::user()->id) }}">Account Information</a></li>
                            <!-- <li><a href="#">Address Book</a></li> -->
                            <li><a href="{{ route('orders') }}">My Orders</a></li>
                            <!-- <li><a href="#">Billing Agreements</a></li> -->
                            <!-- <li><a href="#">Recurring Profiles</a></li> -->
                            <li><a href="#">My Product Reviews</a></li>
                            <!-- <li><a href="#">My Tags</a></li> -->
                            <li><a href="{{ route('my_wishlist') }}">My Wishlist ({{$lims_wishlist_data }})</a></li>
                        {{--<li><a href="{{ route('customer-logout') }}">Logout</a></li>--}}
                        <!-- <li><a href="#">Newsletter Subscriptions</a></li> -->
                            <!-- <li><a href="#">My Downloadable Products</a></li> -->
                        </ul>

                        <br>
                        <div>
                            <a class="btn btn-danger sm" href="{{ route('customer-logout') }}">Log Out</a>
                        </div>
                    </div><!-- End .widget -->
                </aside><!-- End .col-lg-3 -->
            </div><!-- End .row -->
        </div><!-- End .container -->

        <div class="mb-5"></div><!-- margin -->
    </main><!-- End .main -->
@endsection