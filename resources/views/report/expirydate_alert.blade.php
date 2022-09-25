@extends('layout.main') @section('content')

<section class="forms">
    <div class="container-fluid">
	    <h4 class="text-center">{{trans('Product Expiry Alert')}}</h4>
    </div>                  
       <div class="container-fluid">
        <div class="card">
         {!! Form::open(['route' => 'report.product.expiry', 'method' => 'post']) !!} 
             <div class="card-body">



                                <div class="form-row">
                                    <div>
                                    <?php
                                      $date = Carbon\Carbon::now();
                                      $date=date_format($date,"Y-m-d");
                                   ?>
                                        <div class="col-md-12">
                                            <label> From Date <font style="color: red">*</font></label>
                                            <input type="date" name="date_start"class="form-control"value="{{ $date }}" >
                                        </div>
                                    </div>

                                    <div>
                                        <div class="col-md-12">
                                            <label> To Date <font style="color: red">*</font></label>
                                            <input type="date" name="date_end"class="form-control form-control-sm singledatepicker" autocomplete="off" id="datepicker" required="">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-3" style="padding-top:29px;">
                                         <button  type="submit" class="btn btn-primary btn-md">Search</button>
                                    </div>
                                </div>
                        </div>
            
            {!! Form::close() !!}

        </div>
  
    <div class="table-responsive mb-4">
        <table id="report-table" class="table table-hover">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Image')}}</th>
                    <th>{{trans('file.Product Name')}}</th>
                    <th>{{trans('file.Product Code')}}</th>
                    <th>{{trans('Purchase Ref-No')}}</th>
                    <th>{{trans('Warehouse')}}</th>
                    <th>{{trans('file.Quantity')}}</th>
                    <th>{{trans('Expire Date')}}</th>
                </tr>
            </thead>
            
              <tbody>
                 @if(!empty($purchases_data))
                  @foreach($purchases_data as $key=>$val)

                             @php
                               $warehousename =DB::table('warehouses')
                              ->where('id',$val->warehouse_id)
                              ->select('name')
                              ->first();
                              @endphp
                <tr>
                    <td>{{$key}}</td>
                    <td>
                        <img src="{{url('public/images/product',$val->image)}}" height="80" width="80">
                    </td>
                    <td>{{$val->name}}</td>
                    <td>{{$val->code}}</td>
                    <td>{{$val->reference_no}}</td>
                    <td>{{$warehousename->name}}</td>
                    <td>{{$val->qty}}</td>
                     <td>{{$val->ex_date}}</td>
                </tr>
                @endforeach 
              @endif
           </tbody>
            
        </table>
    </div>
</section>

<script type="text/javascript">
     $("ul#report").siblings('a').attr('aria-expanded','true');
     $("ul#report").addClass("show");
     $("ul#report #qtyAlert-report-menu").addClass("active");

    $('#report-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                text: '{{trans("file.PDF")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                text: '{{trans("file.CSV")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                text: '{{trans("file.Print")}}',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'colvis',
                text: '{{trans("file.Column visibility")}}',
                columns: ':gt(0)'
            }
        ],
    } );


</script>
@endsection