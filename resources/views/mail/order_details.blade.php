<h1>Order Details</h1>
@php

    $warehouse = \App\Warehouse::where('id',$warehouse_id)->first();

@endphp
<h3>Customer Information</h3>
 <p><strong> Customer</strong>: {{ $name }} </p>
 <p><strong>City</strong> : {{ $city }} </p>
 <p><strong>Address</strong> : {{ $address }} </p>
 <p><strong>Phone</strong> : {{ $phone_number }} </p>
<p><strong>Reference: </strong>{{$reference_no}}</p>
<p><strong>Payment Method: </strong>{{$payment_method}}</p>
<p><strong>Order Note : </strong>{!! $payment_note !!}</p>

<h3>Order Table</h3>
<table style="border-collapse: collapse; width: 100%;">
    <thead>
    <th style="border: 1px solid #000; padding: 5px">#</th>
    <th style="border: 1px solid #000; padding: 5px">Product</th>
    <th style="border: 1px solid #000; padding: 5px">Qty</th>
    <th style="border: 1px solid #000; padding: 5px">Unit Price</th>
    <th style="border: 1px solid #000; padding: 5px">SubTotal</th>
    </thead>
    <tbody>

    @php
       $pro_quotation = \App\ProductQuotation::where('quotation_id',$id)->get();
    @endphp

    @foreach($pro_quotation as $key=>$val)

        @php
            $product = \App\Product::where('id',$val->product_id)->first();
        @endphp
        <tr>
            <td style="border: 1px solid #000; padding: 5px">{{$key+1}}</td>
            <td style="border: 1px solid #000; padding: 5px">{{$product->name}}</td>
            <td style="border: 1px solid #000; padding: 5px">{{ $val->qty }}</td>
            <td style="border: 1px solid #000; padding: 5px">{{number_format((float)($val->net_unit_price), 2, '.', '')}}</td>
            <td style="border: 1px solid #000; padding: 5px">{{ $val->total }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="2" style="border: 1px solid #000; padding: 5px"><strong>Total </strong></td>
        <td style="border: 1px solid #000; padding: 5px">{{$total_qty}}</td>
        <td style="border: 1px solid #000; padding: 5px"></td>
        <td style="border: 1px solid #000; padding: 5px">{{$total_price}}</td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid #000; padding: 5px"><strong>Order Tax </strong> </td>
        <td style="border: 1px solid #000; padding: 5px">{{$order_tax.'('.$order_tax_rate.'%)'}}</td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid #000; padding: 5px"><strong>Order discount </strong> </td>
        <td style="border: 1px solid #000; padding: 5px">
            @if($order_discount){{$order_discount}}
            @else 0 @endif
        </td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid #000; padding: 5px"><strong>Shipping Cost</strong> </td>
        <td style="border: 1px solid #000; padding: 5px">
           {{$shipping_cost}} @if($shipping_cost == 70 ) ( Inside of Dhaka) @elseif($shipping_cost == 100 ) ( Outside of Dhaka) @else ({{$warehouse->name}}) @endif

        </td>
    </tr>
    <tr>
        <td colspan="4" style="border: 1px solid #000; padding: 5px"><strong>Grand Total</strong></td>
        <td style="border: 1px solid #000; padding: 5px">{{$grand_total}}</td>
    </tr>
    </tbody>
</table>

<p>Thank You</p>