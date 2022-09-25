@extends('layout.website')
@section('home_content')

	@if(session()->has('message'))
		<div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{!! session()->get('message') !!}</div>
	@endif
	@if(session()->has('not_permitted'))
		<div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
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
							<li>
								<span><strong>Shop</strong></span> :  {{ $quatation->warehouse->name }}
							</li>

							 <li>
							    <span><strong> Payment method</strong></span> : Cash
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