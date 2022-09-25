    @extends('layout.main') @section('content')
    @if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif
       <style>
          #barcode-conteant{
              margin: auto;
              text-align: center;
              max-width:150px !important;
          } 
           
       </style>
      <section class="forms">
                <div class="content">
                    <div class="modal-header">
                        <h5 id="modal_header" class="modal-title">{{trans('file.Barcode')}}</h5>&nbsp;&nbsp;
                        <button id="print-btn" type="button" class="btn btn-default btn-sm"><i class="dripicons-print"></i> {{trans('file.Print')}}</button>
                    </div>
                    
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <div class="mt-3">
                                <div id="barcode-conteant">
                                    @foreach($product_code as $key=>$val )
                                    @php

                                        $lims_product_data= App\Product::where('code',$val)->first();
                                    @endphp
                                      @for($i=0; $i< $qty[$key] ;$i++)
                                         @if($paper_size == 36)
                                         <div class="eachbar">{{ $lims_product_data->name }} <br>
                                         <?php echo '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                             <br>
                                            Code: {{ $lims_product_data->code }}
                                             <br>
                                            Price: {{ $lims_product_data->price }}
                                             <br>
                                         </div>
                                         @elseif($paper_size == 24)
                                             <div class="eachbar">{{ $lims_product_data->name }} <br>
                                                 <?php echo '<img style="max-width:150px;height:100%;max-height:12px" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                                 <br>
                                                 Code: {{ $lims_product_data->code }}
                                                 <br>
                                                 Price: {{ $lims_product_data->price }}
                                                 <br>
                                             </div>
                                             @else
                                             <div class="eachbar">{{ $lims_product_data->name }}<br>
                                                 <?php echo '<img style="max-width:150px;height:100%;max-height:20px;" src="data:image/png;base64,' . DNS1D::getBarcodePNG($lims_product_data->code,$lims_product_data->barcode_symbology). '" width="300" alt="barcode"   />';?>
                                                 <br>
                                                 Code: {{ $lims_product_data->code }}
                                                 <br>
                                                 Price: {{ $lims_product_data->price }}
                                                 <br>
                                             </div>
                                         @endif
                                 @endfor
                                  @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    </section>
 
    <script type="text/javascript">
        $("ul#product").siblings('a').attr('aria-expanded','true');
        $("ul#product").addClass("show");
        $("ul#product #printBarcode-menu").addClass("active");
        $("#print-btn").on("click", function(){
            var divToPrint=document.getElementById('barcode-conteant');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<style type="text/css" media="print">.eachbar{margin:auto;padding-bottom:40px!important;max-width:150px;text-align:center;page-break-after: always;}</style> <body onload="window.print()">'+divToPrint.innerHTML+'</body>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        });

    </script>
@endsection