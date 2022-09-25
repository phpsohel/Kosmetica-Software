<h1>Payment Details</h1>
<p><strong>Sale Reference: </strong>{{$sale_reference}}</p>
<p><strong>Payment Reference: </strong>{{$payment_reference}}</p>
<p><strong>Payment Method: </strong>{{$payment_method}}</p>
<p><strong>Paid Amount: </strong>{{$paid_amount}} BDT </p>
<p><strong>Grand Total: </strong>{{$grand_total}} BDT</p>
<p><strong>Due: </strong>{{number_format((float)($grand_total - $total_paid), 2, '.', '')}} BDT </p>
<p>Thank You</p>
