@extends('layout.website')
@section('home_content')
	@php
	     	$brands     = \App\Brand::orderBy('title', 'ASC')->where('is_active', true)->where('title','!=','OTHERS')->where('parent_id', NULL)->get();
            $brand_parent_id = \App\Brand::where('title','=','Invisible')->first()->id;
            $brand_parent = \App\Brand::where('parent_id', $brand_parent_id)->get();

            foreach ($brand_parent as $row){
                $brand_p_id[] = $row->id;
            }
            $categories = \App\Category::orderBy('categories.id', 'DESC')
                ->join('products', 'products.category_id', '=', 'categories.id')
                ->where('categories.is_active', true)
                ->where('categories.parent_id', null)
                ->where('products.is_active', true)
                ->whereNotIn('products.brand_id', $brand_p_id)
                ->select('categories.id', 'categories.name')
                ->distinct('categories.name')
                ->limit(5)
                ->get();
            $carts = \App\Cart::where('user_ip', request()->ip())->latest()->get();

            $subtotal = \App\Cart::all()->where('user_ip', request()->ip())->sum(function($t){
                return $t->product_price * $t->product_quantity;
            });

            $quatation = \App\Quotation::orderBy('id', 'DESC')->first();

            $customer = \App\Customer::join('quotations', 'quotations.customer_id', '=', 'customers.id')
                ->where('quotations.id', $quatation->id)
                ->select('customers.*')
                ->first();

            $products = \App\ProductQuotation::join('quotations', 'quotations.id', '=', 'product_quotation.quotation_id')
                ->join('products', 'products.id', '=', 'product_quotation.product_id')
                ->where('quotations.id', $quatation->id)
                ->select('product_quotation.*', 'products.name')
                ->get();


            $sum = \App\ProductQuotation::all()
                ->where('quotation_id', $quatation->id)
                ->sum(function($t){
                    return $t->net_unit_price * $t->qty;
                });


            $user = \App\User::orderBy('id', 'DESC')
                ->where('id', $customer->user_id)
                ->first();


            $quation_count = \App\Quotation::where('customer_id', $customer->id)->count();


            // return $sale_count; exit();

            $name_without_space = str_replace(' ', '', $user->name);

            $user_name = substr($name_without_space, 0, 3);

            $rand_user_name = $user_name.rand(10,100);
	@endphp

	@if($message))
		<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $message }}</div>
	@endif


<!--================Home Banner Area =================-->
	<section class="banner_area">
		<div class="banner_inner d-flex align-items-center">
			<div class="container">
				<div class="banner_content text-center"><br><br>
					<h2>Order Confirmation</h2>
					<div class="page_link">
						<!-- <a href="index.html">Home</a> -->
						<!-- <a href="confirmation.html">Confirmation</a> -->
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--================End Home Banner Area =================-->

	<!--================Order Details Area =================-->
	<section class="order_details p_120">
		<div class="container">
			<h3 class="title_confirmation" style="text-align: center;">Thank you. Your order has been received.</h3><br>

			<div class="row order_d_inner">
				<div class="col-lg-4" style="border: 1px solid #d0cfcf; border-radius: 10px; padding: 20px; margin: 2px;">
					<div class="details_item"><br><br>
						<h4>Order Info</h4>
						<!-- <p><strong>*Please Remember The Order Number to Track</strong></p> -->
						<ul class="list">
							<li>
							<span><strong> Reference</strong></span>  : {{ $quatation->reference_no }}
							</li>
							<li>
							<span><strong> Date</strong></span>  : {{ date('d-m-Y', strtotime($quatation->created_at)) }}
							</li>
							<li>
								<span><strong>Total</strong></span> : ৳ {{ $quatation->grand_total }}
							</li>
							{{--<li>--}}
								{{--<span><strong>Shop</strong></span> :  {{ $quatation->warehouse->name }}--}}
							{{--</li>--}}

							 <li>
							    <span><strong> Payment method</strong></span> : {{ $shipping_method }}
							</li>
							<li>
								<span><strong> Order Note</strong></span> : {!! $payment_note !!}
							</li>

						</ul>
					</div>
				</div>

				<div class="col-lg-4" style="border: 1px solid #d0cfcf; border-radius: 10px; padding: 20px; margin: 2px;">
					<div class="details_item"><br><br>
						<h4>Billing & Shipping Detail</h4>
						<ul class="list">
							<li>

									<span><strong> Customer</strong></span>: {{ $customer->name }}
							</li>
							<li>

									<span><strong>City</strong></span> : {{ $customer->city }}
							</li>
							<li>

									<span><strong>Address</strong></span> : {{ $customer->address }}
							</li>
							<li>

									<span><strong>Phone</strong> </span>: {{ $customer->phone_number }}
							</li>

						</ul>
					</div>
				</div>
				@if(!Auth::user() && $quation_count <= 1)
				<div class="col-lg-3" style="border: 1px solid #d0cfcf; border-radius: 10px; padding: 20px; margin: 2px;">
					<div class="details_item"><br><br>
						<h4>Login Info</h4>
						<ul class="list">
							<li>
									<span><strong>User Name</strong></span> :{{ $user->name }}
							</li>

							<li>
									<span><strong>Password</strong></span> :{{ 12345678 }}
							</li>

						</ul>
					</div>
				</div>
				@endif
			</div>

			<div class="order_details_table" style="border: 1px solid #d0cfcf; border-radius: 10px; padding: 20px; margin: 2px;">
				<h2>Order Details</h2>
				<!-- <p>Download the Memo By clicking The Button Below</p> -->
				<!-- <p><strong>*Shipping Cost will be Added</strong></p> -->
				<!-- <a href="" class="btn btn-success">Memo</a> -->
				<div class="table-responsive">
					<table class="table">
						<thead>
							<tr>
								<th scope="col">Product</th>
								<th scope="col">Quantity</th>
								<th scope="col">Unit Price</th>
								<th scope="col">Total</th>
							</tr>
						</thead>

						<tbody>
						@foreach($products as $row)
							<tr>
								<td>
									<p>{{ $row->name }}</p>
								</td>
								<td>
									<h5>x {{ $row->qty }}</h5>
								</td>
								<td>
									<p>৳{{ $row->net_unit_price }}</p>
								</td>
								<td>
									<p>৳{{ $row->net_unit_price  * $row->qty }}</p>
								</td>
							</tr>
						@endforeach

							<br>
							<tr>
								<td></td>
								<td>
									<h4></h4>
								</td>
								<td>
									<h5>Shipping Cost</h5>
								</td>
								<td>
									<p>৳{{ $quatation->shipping_cost }}</p>
								</td>
							</tr>
							<tr>
								<td></td>
								<td>
									<h4></h4>
								</td>
								<td>
									<h5>Total</h5>
								</td>
								<td>
									<p>৳{{ $sum  + $quatation->shipping_cost }}</p>
								</td>
							</tr>
						</tbody>

					</table>
				</div>
			</div>
			</div>
		</div>
	</section>


@endsection