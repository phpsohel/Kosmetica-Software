@extends('layout.ar_website')
@section('home_content')
 <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb" style="float: right"style="float: right">
                        <li class="breadcrumb-item active" aria-current="page">عربة التسوق</li>
                        <li class="breadcrumb-item"><a href="{{ route('eshop.ar') }}"><i class="icon-home"></i></a></li>
                    </ol>
                </div><!-- End .container -->
            </nav>
            <div class="container">
                <br>
                <br>
                <br>
                <div class="row">

                    <div class="col-lg-8">
                        <div class="cart-table-container">
                            <table class="table table-cart">
                                 @if($carts->count() > 0)
                                <thead>
                                    <tr>
                                        <th class="product1-col"></th>
                                        <th class="product-col">منتج</th>
                                        <th class="price-col">سعر</th>
                                        <th class="qty-col">الكمية</th>
                                        <th>المجموع الفرعي</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($carts as $row)
                                        @php
                                            $name =  str_replace(' ', '-', $row->product->name);
                                             $image =  $row->product->image;
                                               $image = explode(',',$image);
                                               $first_image = $image[0];
                                        @endphp
                                        <tr class="product-row">
                                        <td  class="product1-col">
                                            <button type="button" class="close" aria-label="Close">
                                             <a href="{{ route('cart-destroy', $row->id) }}"> <span aria-hidden="true"> <span aria-hidden="true"></span>&times;</a>
                                            </button>
                                        </td>
                                        <td class="product-col">
                                            <figure class="product-image-container">
                                                <a href="{{ route('eshop-details.ar',['id' => $row->product->id, 'name' => $name ]) }}" class="product-image">
                                                    <img src="{{ url('public/images/product', $first_image) }}" style="height: 150px; width: auto;" alt="product">
                                                </a>
                                            </figure>
                                            <h5  class="product-title">
                                                <a  href="{{ route('eshop-details.ar',['id' => $row->product->id, 'name' => $name ]) }}">{{ $row->product->name_ar }}</a>
                                            </h5>
                                        </td>
                                        <td>৳{{ $row->product_price }}</td>
                                        <td>
                                            <form action="{{ route('cart-quantity-update.ar', $row->id) }}" method="POST">
                                                @csrf
                                            <input class="vertical-quantity form-control" type="text" value="{{  $row->product_quantity }}" name="product_quantity"><br>
                                            <button type="submit" class="btn btn-outline-secondary btn-update-cart">تحديث سلة الشراء</button>
                                            </form>
                                        </td>
                                        <td>৳{{ $row->product_price * $row->product_quantity }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <h1 style="font-size: 20px;">لا توجد منتجات في العربة!</h1>
                                    @endif

                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="{{ route('eshop.ar') }}" class="btn btn-outline-secondary">مواصلة التسوق</a>
                                            </div><!-- End .float-left -->
                                             @if($carts->count() > 0)
                                            <div class="float-right">
                                                <a href="{{ route('clear-cart') }}" class="btn btn-outline-secondary btn-clear-cart">تفريغ عربة التسوق</a>
                                            </div><!-- End .float-right -->
                                            @endif
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div><!-- End .cart-table-container -->
                        <div class="cart-discount">
                        </div><!-- End .cart-discount -->
                    </div><!-- End .col-lg-8 -->
                     @if($carts->count() > 0)
                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>ملخص</h3>
                            <h4>
                                <a data-toggle="collapse" href="#total-estimate-section" class="collapsed" role="button" aria-expanded="true" aria-controls="total-estimate-section">تكلفة الشحن</a>
                            </h4>
                            <div class="collapse show" id="total-estimate-section">
                                <form action="{{ route('checkout.ar', request()->ip()) }}" id="shippingCheck" method="POST">
                                    @csrf
                                    <div style="display: none;">
                                        <h5 id="shippingmsg" style="padding: 10px ;background-color: rgba(255,0,0,0.73); border-radius: 5px;"> </h5>
                                    </div>
                                    <div class="form-group form-group-custom-control ">
                                          <input type="radio" id="inside" name="shipping_cost" value="70">
                                          <label for="male">داخل دكا عربي 70</label><br>
                                          <input type="radio" id="outside" name="shipping_cost" value="100">
                                          <label for="female">خارج دكا 100 دينار بحريني</label><br>
                                           <input class="coupon_question"  href="#all_outlet" id="outlet" type="radio" name="shipping_cost" value="0" onchange="valueChanged()"/>
                                           <label for="male"><a data-toggle="collapse" class="collapsed" role="button" aria-expanded="false" aria-controls="all_outlet">الاستلام من المتجر</a></label>
                                        @php
                                           $warehouses = \App\Warehouse::where('id','!=' ,2 )->where('id','!=' ,1 )->get();
                                        @endphp
                                        @php
                                            $cartsCheck = \App\Cart::where('user_ip', request()->ip())->latest()->first();
                                             $ip = request()->ip();
                                        @endphp
                                            <div class="collapse answer all_outlet" id="all_outlet">
                                                <div class="form-group col-md-6">
                                                    <input type="hidden" name="pro_id" id="pro_id" value="{{ $cartsCheck->product_id}}">
                                            <input type="hidden" name="ip" id="ip" value="{{ $ip }}">
                                                    <select name="warehouse_id" id="warehouse_id">
                                                        <option value="0">حدد واحد</option>
                                                        @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse ->id }}">{{ $warehouse ->name_ar }}</option>
                                                        @endforeach
                                                    </select>
                                                </div><!-- End .form-group -->
                                          </div>
                                        @php
                                            $warehouses = \App\Hub::get();
                                        @endphp
                                        <div class="collapse hubselection" id="all_outlet">
                                            <div class="form-group col-md-6">
                                                <select name="hub_id" id="hub_id" style="width: 175px !important;" >
                                                    <option value="0">Select Hub</option>
                                                    @foreach($warehouses as $warehouse)
                                                        <option value="{{ $warehouse ->id }}">{{ $warehouse ->hub_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div><!-- End .form-group -->
                                        </div><!-- End #total-estimate-section -->

                                        <div class="collapse areaselection" id="all_outlet">
                                            <div class="form-group col-md-6">
                                                <select name="area_id" id="area_id" style="width: 175px !important;">
                                                       <option  value="0">حدد المنطقة</option>
                                                        <option  value=""></option>
                                                </select>
                                            </div><!-- End .form-group -->
                                        </div><!-- End #total-estimate-section -->
                                     </div><!-- End .form-group -->

                            </div><!-- End #total-estimate-section -->

                            <div class="product_check" style="display: none;">
                             <h5 style="padding: 10px ;background-color: rgba(255,0,0,0.73); border-radius: 5px;">لا تتوفر أي من منتجات سلة التسوق في المتجر الذي اخترته! يمكنك الحجز الآن.</h5>
                            </div>

                            <div class="leak_product_msg" style="display: none;">
                                <p style="padding: 10px ;background-color: #f7bec7; border-radius: 5px;">عفوا! جميع منتجات البطاقات غير متوفرة في هذا المنفذ في الوقت الحالي .
                                    <a href="#">  <strong id="product_name"></strong> </a> هي / غير متوفرة في المخزون. إذا كنت ترغب في ذلك ، قم بالحجز الآن وإلا قم بإزالة هذا المنتج من البطاقة.

                                </p>
                            </div>

                            <input type="hidden" name="subtotal" id="subtotal" value="{{ $subtotal}}">

                             <div class="hiddingShipping">
                                 <input type="hidden" name="shipping" id="shipping">
                             </div>
                            <div class="hiddingwarehouseShipping">
                                <input type="hidden" name="warehouse_shipping" id="warehouse_shipping">
                            </div>

                            <div class="sellItem">
                                <input type="hidden" name="sellItem" id="sellItem">
                            </div>
                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>المجموع الفرعي</td>
                                        <td>৳{{ $subtotal }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>الطلب الكلي</td>
                                        <td id="subtotal">৳{{ $subtotal }}</td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="checkout-methods">
                                <button type="submit" class="btn btn-block btn-sm btn-primary" id="checkShippingid" >اذهب إلى </button>
                            </div><!-- End .checkout-methods -->
                            <div class="booking" style="display: none">
                                <button type="submit" class="btn btn-block btn-sm btn-warning" id="checkShippingid">اذهب إلى الحجز</button>
                            </div><!-- End .checkout-methods -->
                            </form>
                            @endif
                        </div><!-- End .cart-summary -->
                    </div><!-- End .col-lg-4 -->
                </div><!-- End .row -->
            </div><!-- End .container -->

            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->

 <script src="<?php echo asset('public/assets/frontend/js/jquery.min.js') ?>"></script>


 <script>
     $(document).ready(function () {
         $('#checkShippingid').on('click', function () {
             var checked_gender = document.querySelector('input[name = "shipping_cost"]:checked');
             if (checked_gender == null){
                 $('#shippingCheck').submit(function (evt) {
                     alert(' Select Shipping Cost Option');
                     evt.preventDefault();
                     location.reload();
                 });
             }
         });
     });
 </script>


 <script type="text/javascript">
     function valueChanged()
     {
         if($('.coupon_question').is(":checked"))
             $(".answer").show();
         else
             $(".answer").hide();
     }
 </script>

   <script type="text/javascript">

    $(document).ready(function () {

       $('#all_outlet').on('change', function () {

           var w_id = $('#warehouse_id').val();
           var ip = $('#ip').val();
           $.ajax({
            cache: false ,
           type: 'get',
           url: '{{ route('checkout.check') }}',
           data: {'w_id': w_id ,'ip':ip },
           dataType: "json",
           success: function (data) {
               if(data[0] == 0  && data[1] == 0 || data[0][0].qty < 1  ){
               $(".product_check").show();
               $(".leak_product_msg").hide();
               $(".checkout-methods").hide();
               $(".booking").show();
           }else if(data[1] > 0 && data[0] != 0 ){
               $(".product_check").hide();
               $(".leak_product_msg").show();
               $(".booking").show();
               $(".checkout-methods").hide();
               $("input[name='sellItem']").val(data[0][0].qty);
               var html = ' ';

               $.each(data[2], function(key, value){
                   var url = '{{route("cart-destroy", ":id")}}';
                   url = url.replace(':id', value.id);
                   html +='<a class="remove_product_link'+value.id+'" href="#"> <span aria-hidden="true">  <strong>'+ value.name+ '</strong>  <span aria-hidden="true"></span>&times;</a>'  +' , ';
                   $("#product_name").html(html);
                   $(".remove_product_link"+value.id).attr("href",url);
               });

           }else{
               $(".product_check").hide();
               $(".booking").hide();
               $(".checkout-methods").show();
               $("input[name='sellItem']").val(data[0][0].qty);
           }
           },
           error: function () {
           }
           });
       });
      });
   </script>



 <script type="text/javascript">

       function valueChanged()
              {
             if($('.coupon_question').is(":checked"))
                 $(".answer").show();
             else
                 $(".answer").hide();
              }

         function hubChanged()
         {
             if($('.hub_question').is(":checked"))
                 $(".hubselection").show();
             else
                 $(".hubselection").hide();
         }



       $("input[name='shipping_cost']").on('change', function () {
           var s_cost = $(this).val();
           $.ajax({
               type: 'get',
               url: '{{ route('shipping.cost') }}',
               data: {'s_cost': s_cost},
               dataType: "json",
               success: function (data) {
                   var value_input = $("input[name='shipping']").val(data);
               },
               error: function () {
               }
           });
       });
 </script>


 <script type="text/javascript">
       $('#all_outlet').on('change', function () {
           var w_id = $('#warehouse_id').val();
           $.ajax({
               type: 'get',
               url: '{{ route('shipping_warwehouse.cost') }}',
               data: {'w_id': w_id},
               dataType: "json",
               success: function (data) {
                   var value_input = $("input[name='warehouse_shipping']").val(data);
               },
               error: function () {
               }
           });
       });

        $('#hub').click(function() {
            $("#warehouse_id").hide();
            $("#hub_id").show();
        });

        $('#outlet').click(function() {
            $("#hub_id").hide();
            $("#warehouse_id").show();
        });

        // Area
       $('#hub_id').on('change', function () {
           var hub_id = $(this).val();
           if (hub_id > 0) {
               $(".areaselection").show();
           }else{
               $(".areaselection").hide();
           }

       });
       $('#hub_id').on('change', function () {
           var hub_id = $(this).val();
          // alert(hub_id);
           $.ajax({
               type: 'get',
               url: '{{ route('get_area') }}',
               data: {'hub_id': hub_id},
               cache: false,
               dataType: "json",
               success: function (data) {

                   var selOpts = "<option value='0' > Select Area </option>";
                   $.each(data, function(key, area)
                   {
                       selOpts += "<option value='"+area.id+"'>"+area.name+"</option>";

                   });
                   $('#area_id').empty();
                   $('#area_id').append(selOpts);
               },
               error: function () {
               }
           });
       });

       $('#hub_id').on('change', function () {
           var w_id = $(this).val();
           $.ajax({
               type: 'get',
               url: '{{ route('shipping_warwehouse.cost') }}',
               data: {'w_id': w_id},
               dataType: "json",
               success: function (data) {
                   var value_input = $("input[name='warehouse_shipping']").val(data);
               },
               error: function () {
               }
           });
       });

       $('.cart-summary').on('click', function () {
           var w_id = $('#warehouse_id').val();
           var pro_id = $('#pro_id').val();
           var subtotal = $('#subtotal').val();
           var hub_id = $('#hub_id').val();
           var shipping_cost = $("input[name='shipping']").val();

           $.ajax({
           type: 'get',
           url: '{{ route('cart-order-booking') }}',
           data: {'w_id': w_id ,'pro_id': pro_id ,'subtotal':subtotal ,'shipping_cost':shipping_cost},
           dataType: "json",
           success: function (data) {

           },
           error: function () {
           }
           });
       });
   </script>
@endsection
