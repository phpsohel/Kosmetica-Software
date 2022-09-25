@extends('layout.website')
@section('home_content')

@if(Auth::user())
@php
    $customer = App\Customer::orderBy('customers.id', 'ASC')->where('users.role_id', '=', Auth::user()->role_id)->where('customers.user_id', '=', Auth::user()->id)->join('users', 'users.id', '=', 'customers.user_id')->first();
@endphp
@endif
<main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i class="icon-home"></i></a></li>
                        <li class="breadcrumb-item active" aria-current="page">Checkout</li>
                    </ol>
                </div><!-- End .container -->
            </nav>
            <div class="container">
                <div>
                    <h4>Already  Registered ?
                        <a href="{{ route('eshop-login') }}">click here to login</a>
                    </h4>
                </div>
                <br>
                <div class="row">
                    <div class="col-lg-8">
                        <ul class="checkout-steps">
                            <li>
                                <h2 class="step-title">Customer's Information</h2>
                                <form action="{{ route('place-order') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="user_ip" value="{{ request()->ip() }}">
                                    @if(Auth::user())
                                    <div class="form-group required-field">
                                        <label>Full Name </label>
                                        <input type="text" class="form-control" name="name" required value="{{ Auth::user()->name }}">
                                    </div><!-- End .form-group -->
                                    @endif
                                    @if(!Auth::user())
                                    <div class="form-group required-field">
                                        <label>Full Name </label>
                                        <input type="text" class="form-control" name="name" required>
                                    </div><!-- End .form-group -->
                                    @endif
                                    @if(Auth::user())
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="text" class="form-control" name="email" value="{{ Auth::user()->email }}">
                                    </div><!-- End .form-group -->
                                    @endif
                                    @if(!Auth::user())
                                    <div class="form-group">
                                        <label>Email </label>
                                        <input type="text" class="form-control" name="email">
                                    </div><!-- End .form-group -->
                                    @endif


                                    @if(Auth::user())
                                    <div class="form-group required-field">
                                        <label>Phone Number </label>
                                        <div class="form-control-tooltip">
                                            <input type="number" class="form-control" name="phone_number" required value="{{ Auth::user()->phone }}">
                                            <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>
                                        </div><!-- End .form-control-tooltip -->
                                    </div><!-- End .form-group -->
                                    @endif
                                    @if(!Auth::user())
                                    <div class="form-group required-field">
                                        <label>Phone Number </label>
                                        <div class="form-control-tooltip">
                                            <input type="number" class="form-control" name="phone_number" required>
                                            <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>
                                        </div><!-- End .form-control-tooltip -->
                                    </div><!-- End .form-group -->
                                    @endif




                                    @if(Auth::user())
                                    @if(Auth::user()->role_id == 5)
                                    <div class="form-group required-field">
                                        <label>Address </label>
                                        <input type="text" class="form-control" name="address" required value="{{ $customer->address }}">

                                    </div><!-- End .form-group -->
                                    @endif
                                    @endif
                                    @if(Auth::user())
                                    @if(Auth::user()->role_id != 5)
                                    <div class="form-group required-field">
                                        <label>Address </label>
                                        <input type="text" class="form-control" name="address" required>

                                    </div><!-- End .form-group -->
                                    @endif
                                    @endif
                                    @if(!Auth::user())
                                    <div class="form-group required-field">
                                        <label>Address </label>
                                        <input type="text" class="form-control" name="address" required>

                                    </div><!-- End .form-group -->
                                    @endif



                                    @if(Auth::user())
                                    @if(Auth::user()->role_id == 5)
                                   <div class="form-group required-field">
                                        <label>City </label>
                                        <input type="text" class="form-control" name="city" required value="{{ $customer->city }}">
                                    </div><!-- End .form-group -->
                                    @endif
                                    @endif
                                    @if(Auth::user())
                                    @if(Auth::user()->role_id != 5)
                                    <div class="form-group required-field">
                                        <label>City </label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div><!-- End .form-group -->
                                    @endif
                                    @endif
                                    @if(!Auth::user())
                                    <div class="form-group required-field">
                                        <label>City </label>
                                        <input type="text" class="form-control" name="city" required>
                                    </div><!-- End .form-group -->
                                    @endif
                            </li>
                            <li>
                            </li>
                        </ul>
                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="order-summary">
                            <h3> Order Summary</h3>

                            <h4>
                                <a data-toggle="collapse" href="#order-cart-section" class="collapsed" role="button" aria-expanded="false" aria-controls="order-cart-section">{{ $count }} products in Cart</a>
                            </h4>

                            <div class="collapse" id="order-cart-section">
                                <table class="table table-mini-cart">
                                    <tbody>

                                        @foreach($carts as $row)
                                            @php
                                                  $image =  $row->product->image;
                                                  $image = explode(',',$image);
                                                  $first_image = $image[0];
                                            @endphp
                                        <input type="hidden" name="cart_ip" value="{{ $row->user_ip }}">
                                        <tr>
                                            <td class="product-col">
                                                <figure class="product-image-container">
                                                    <a href="product.html" class="product-image">
                                                        <img src="{{ url('public/images/product', $first_image) }}" alt="product">
                                                    </a>
                                                </figure>
                                                <div>
                                                    <h2 class="product-title">
                                                        <a href="product.html">{{ $row->product->name }}</a>
                                                    </h2>

                                                    <span class="product-qty">Qty: {{ $row->product_quantity }}</span>
                                                </div>
                                            </td>
                                            <td class="price-col">৳{{ $row->product_price * $row->product_quantity }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                <div>
                                    <input type="hidden" name="shipping_cost" value="{{ $shipping_cost }}">
                                    <p>Shipping Cost: <strong>৳{{ $shipping_cost }}
                                    @if($shipping_cost == 60)
                                    (Inside Dhaka)
                                    @elseif($shipping_cost == 100)
                                                (Outside Dhaka)
                                    @elseif($shipping_cost == 0 && $warehouse_shipping_id == null && $warehouse_shipping_id < 1 )
                                     (Express Delivery)
                                    @else
                                     (Collect From Shop)
                                    @endif
                                </strong></p>
                                    <p>Total: <strong> ৳{{ $shipping_cost + $subtotal }}</strong> </p>
                                </div>
                                <input type="hidden" name="shipping_cost" value="{{ $shipping_cost }}">
                                <input type="hidden" name="warehouse_id" value="{{ $warehouse_id }}">
                                <input type="hidden" name="hub_id" value="{{ $hub_id }}">
                                <input type="hidden" name="pro_id" value="{{ $pro_id }}">
                                <input type="hidden" name="warehouse_shipping_id" value="{{ $warehouse_shipping_id }}">
                                <input type="hidden" name="sellItem" value="{{ $sellItem }}">
                            </div><!-- End #order-cart-section -->
                        </div><!-- End .order-summary -->


                        <div class="checkout-step-shipping">
                            <h2 class="step-title">Shipping Methods</h2>
                            <table class="table">
                                <tbody>
                                <tr>
                                  @if($shipping_cost == 100)
                                    <td style="display:flex" >
                                        <input type="radio" name="shipping_method" value="Cash" checked >
                                        <img  src="{{ url('public/images/payment/cash.png') }}" style=" margin-right: 40px; height:60px;width: auto;">

                                        {{--<input type="radio" name="shipping_method" value="Bkash">--}}
                                        {{--<img src="{{ url('public/images/payment/bkash.png') }}" style="height: 60px;width:auto;">--}}
                                    </td>

                                 @elseif($shipping_cost == 0 && $sellItem == null && $warehouse_shipping_id > 0  && $hub_id <= 0 )
                                        <td style="display:flex" >
                                            <input type="hidden" name="shipping_method">
                                        </td>
                                  @else
                                        <td style="display: flex">
                                            <input type="radio" name="shipping_method" value="Cash" checked>
                                            <img  src="{{ url('public/images/payment/cash.png') }}" style=" margin-right: 40px; height:60px;width: auto;">
                                            {{--<input type="radio" name="shipping_method" value="Bkash">--}}
                                            {{--<img src="{{ url('public/images/payment/bkash.png') }}" style="height: 60px;width:auto;">--}}
                                        </td>
                                 @endif
                                </tr>
                                </tbody>
                            </table>
                        </div>

                        <div>
                            <h2>Orders Notes </h2>
                              <div>
                                  <textarea name="payment_note" id="" cols="50" rows="8"></textarea>
                              </div>
                        </div>
                    </div><!-- End .col-lg-4 -->



                </div><!-- End .row -->

                <div class="row" style="margin:auto">
                    <div class="col-lg-12">
                        <div class="checkout-steps-action">
                            <button type="submit" class="btn btn-primary float-left"> Place Order</button>
                        </div><!-- End .checkout-steps-action -->
                    </div><!-- End .col-lg-8 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
 </form>
            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->

@endsection