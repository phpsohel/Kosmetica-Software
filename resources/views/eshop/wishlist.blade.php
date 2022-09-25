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
                    <h2>Wishlist Information</h2>
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
                                                            <th>Product Code</th>
                                                            <th>Price</th>
                                                            <th> Available In Stock</th>

                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach($lims_sale_data as $key => $sale)
                                                            <?php

                                                                  $products = \App\Product::where('id',$sale->product_id)->orderBy('id','DESC')->first();
                                                               //   dd($products);

                                                            ?>

                                                            <tr>
                                                            {{--<tr data-sale='["{{date($general_setting->date_format, strtotime($sale->created_at->toDateString()))}}", "{{$sale->reference_no}}", "{{$status}}", "{{$sale->biller->name}}", "{{$sale->biller->company_name}}", "{{$sale->biller->email}}", "{{$sale->biller->phone_number}}", "{{$sale->biller->address}}", "{{$sale->biller->city}}", "{{$sale->customer->name}}", "{{$sale->customer->phone_number}}", "{{$sale->customer->address}}", "{{$sale->customer->city}}", "{{$sale->id}}", "{{$sale->total_tax}}", "{{$sale->total_discount}}", "{{$sale->total_price}}", "{{$sale->order_tax}}", "{{$sale->order_tax_rate}}", "{{$sale->order_discount}}", "{{$sale->shipping_cost}}", "{{$sale->grand_total}}", "{{$sale->paid_amount}}", "{{$sale_note}}", "{{$staff_note}}", "{{$sale->user->name}}", "{{$sale->user->email}}", "{{$sale->warehouse->name}}", "{{$coupon_code}}", "{{$sale->coupon_discount}}"]'>--}}

                                                                <td>{{$key+1}}</td>
                                                                <td>{{ date($general_setting->date_format, strtotime($sale->date)) }}</td>
                                                                <td>{{$products->name}}</td>
                                                                <td>{{$products->code}}</td>
                                                                <td>{{$products->price}}</td>
                                                                @if( $products->qty > 0 )
                                                                    <td> <strong>Yes</strong></td>
                                                                    @else
                                                                    <td> <strong>No</strong></td>
                                                                    @endif

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
                            <li><a href="{{ route('my_review') }}">My Product Reviews</a></li>
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