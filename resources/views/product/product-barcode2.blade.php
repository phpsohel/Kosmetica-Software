    @extends('layout.main') @section('content')
    @if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
       
      <section class="forms">
                <div class="content">
                    <div class="modal-header">
                        <h5 id="modal_header" class="modal-title">{{trans('file.Barcode')}}</h5>&nbsp;&nbsp;
                        <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <table id="barcode-conteant" style="" class="">
                                    <thead style="display: none;">
                                    <tr>
                                        <th>{{trans('file.name')}}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                 @for($i=1; $i<=$qty[0] ;$i++)
                                     <tr class="pageBreak">
                                         @if($paper_size == 36)
                                         <td style="">{{ $lims_product_data->name }} <br>
                                         <?php echo '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                             <br>
                                            Code: {{ $lims_product_data->code }}
                                             <br>
                                            Price: {{ $lims_product_data->price }}
                                             <br>
                                         </td>
                                         @elseif($paper_size == 24)
                                             <td class="pageBreak" style="" >{{ $lims_product_data->name }} <br>
                                                 <?php echo '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                                 <br>
                                                 Code: {{ $lims_product_data->code }}
                                                 <br>
                                                 Price: {{ $lims_product_data->price }}
                                                 <br>
                                             </td>
                                             @else
                                             <td style="" >{{ $lims_product_data->name }} <br>
                                                 <?php echo '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                                 <br>
                                                 Code: {{ $lims_product_data->code }}
                                                 <br>
                                                 Price: {{ $lims_product_data->price }}
                                                 <br>
                                             </td>
                                         @endif
                                     </tr>

                                 @endfor
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
 
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded','true');
        $("ul#product").addClass("show");
        $("ul#product #printBarcode-menu").addClass("active");
        // $("").on("click", function(event) {
        //     paper_size = ($("#paper-size").val());
        //     if(paper_size != "0") {
        //         var product_name = [];
        //         var code = [];
        //         var price = [];
        //         var promo_price = [];
        //         var qty = [];
        //         var barcode_image = [];
        //         var currency = [];
        //         var currency_position = [];
        //         var rownumber = $('table.order-list tbody tr:last').index();
        //         for(i = 0; i <= rownumber; i++){
        //             product_name.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(1)').text());
        //             code.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('td:nth-child(2)').text());
        //             price.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('price'));
        //             promo_price.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('promo-price'));
        //             currency.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('currency'));
        //             currency_position.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('currency-position'));
        //             qty.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').find('.qty').val());
        //             barcode_image.push($('table.order-list tbody tr:nth-child(' + (i + 1) + ')').data('imagedata'));
        //         }
        //         var htmltext = '<table class="barcodelist" style="width:200px;" cellpadding="5px" cellspacing="10px">';
        //         $.each(qty, function(index){
        //
        //             i = 0;
        //             while(i < qty[index]) {
        //                 if(i % 2 == 0)
        //                     htmltext +='<tr>';
        //                 // 36mm
        //                 if(paper_size == 36)
        //
        //                     htmltext +='<td style="width:164px;height:88%;padding-top:7px;vertical-align:middle;text-align:center">';
        //                 //24mm
        //                 else if(paper_size == 24)
        //
        //                     htmltext +='<td style="width:164px;height:100%;font-size:12px;text-align:center">';
        //                 //18mm
        //                 else if(paper_size == 18)
        //                     htmltext +='<td style="width:164px;height:100%;font-size:10px;text-align:center">';
        //
        //                 if($('input[name="name"]').is(":checked"))
        //                     htmltext += product_name[index] + '<br>';
        //
        //                 if(paper_size == 18)
        //                     htmltext += '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,'+barcode_image[index]+'" alt="barcode" /><br>';
        //                 else
        //                     htmltext += '<img style="max-width:150px;height:100%;max-height:20px" src="data:image/png;base64,'+barcode_image[index]+'" alt="barcode" /><br>';
        //
        //                 htmltext += code[index] + '<br>';
        //                 if($('input[name="code"]').is(":checked"))
        //                     htmltext += '<strong>'+code[index]+'</strong><br>';
        //                 if($('input[name="promo_price"]').is(":checked")) {
        //                     if(currency_position[index] == 'prefix')
        //                         htmltext += 'Price: '+currency[index]+'<span style="text-decoration: line-through;"> '+price[index]+'</span> '+promo_price[index]+'<br>';
        //                     else
        //                         htmltext += 'Price: <span style="text-decoration: line-through;">'+price[index]+'</span> '+promo_price[index]+' '+currency[index]+'<br>';
        //                 }
        //                 else if($('input[name="price"]').is(":checked")) {
        //                     if(currency_position[index] == 'prefix')
        //                         htmltext += 'Price: '+currency[index]+' '+price[index];
        //                     else
        //                         htmltext += 'Price: '+price[index]+' '+currency[index];
        //                 }
        //                 htmltext +='</td>';
        //                 if(i % 2 != 0)
        //                     console.log('done');
        //                 htmltext +='</tr>';
        //                 i++;
        //             }
        //         });
        //         htmltext += '</table">';
        //         $('#label-content').html(htmltext);
        //         $('#print-barcode').modal('show');
        //     }
        //     else
        //         alert('Please select paper size');
        // });

        $("#print-btn").on("click", function(){
            var divToPrint=document.getElementById('barcode-conteant');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<style type="text/css" media="print">img{padding-bottom:40px !important;}        </style> <body onload="window.print()">'+divToPrint.innerHTML+'</body>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        });

    </script>
@endsection