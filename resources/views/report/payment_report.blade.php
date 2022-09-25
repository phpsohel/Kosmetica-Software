@extends('layout.main') @section('content')

    <section class="forms">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header mt-2">
                    <h3 class="text-center">{{trans('file.Payment Report')}}</h3>
                </div>
                {!! Form::open(['route' => 'report.paymentByDate_warehouse', 'method' => 'post']) !!}
                <div class="row">
                    <div class="col-md-4" style="margin-left: 50px;">
                        <div class="form-group">
                            <label style="margin-left: 50px;" class="d-tc mt-2"><strong>{{trans('file.Choose Your Date')}}</strong> &nbsp;</label>
                            <div class="d-tc">
                                <div class="input-group">
                                    <input class="form-control" type="date" name="start_date" />
                                    <input class="form-control" type="date" name="end_date"   />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label class="d-tc mt-2"><strong>{{trans('file.Choose Warehouse')}}</strong> &nbsp;</label>
                            <div class="d-tc">
                                {{--<input type="hidden" name="warehouse_id" value="0" />--}}
                                <select id="warehouse_id" name="warehouse_id" class="form-control">
                                    <option value="0">{{trans('file.All Warehouse')}}</option>
                                    @foreach($lims_warehouse_list as $warehouse)
                                        <option value="{{$warehouse->id}}">{{$warehouse->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="d-tc mt-2"><strong>Payment Type</strong> &nbsp;</label>
                            <div class="d-tc">

                                <select id="payment_type_id" name="payment_type_id" class="form-control" >
                                    <option value="0">Select Type</option>
                                    <option value="sale">Sale</option>
                                    <option value="purchase">Purchase</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="form-group">
                            <label class="mt-2"><strong>Payment By</strong> &nbsp;</label>
                            <div class="d-tc">
                                <select id="payment_by_id" name="payment_by_id" class="form-control">
                                    <option value="all">All</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Cheque">Credit Card</option>
                                    <option value="Bkash">Bkash</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2" style="margin-left: 50px;">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">{{trans('file.submit')}}</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
        <div class="table-responsive mb-4">
            <table id="report-table" class="table table-hover">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Date')}}</th>


                    <th>{{trans('file.Payment Reference')}} </th>
                    <th>{{trans('file.Sale Reference')}}</th>
                    <th>{{trans('file.Purchase Reference')}}</th>
                    <th>Warehouse</th>
                    <th>{{trans('file.Paid By')}}</th>
                    <th>{{trans('file.Amount')}}</th>
                    <th>{{trans('file.Created By')}}</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $amount = 0;
                @endphp
                {{--@foreach($lims_payment_data as $payment)--}}
                    
                    {{--$amount+=$payment->amount;--}}

                    {{--$sale = DB::table('sales')->find($payment->sale_id);--}}
                    {{--$purchase = DB::table('purchases')->find($payment->purchase_id);--}}

                    {{--if( $sale !=null && $sale->warehouse_id !=null){--}}
                        {{--$warehouse  = \App\Warehouse::where('id',$sale->warehouse_id)->first();--}}
                    {{--}else{--}}
                        {{--$warehouse  = \App\Warehouse::where('id',$purchase->warehouse_id)->first();--}}
                    {{--}--}}


                    {{--$user = DB::table('users')->find($payment->user_id);--}}
                    {{--?>--}}
                    {{--<tr>--}}
                        {{--<td></td>--}}
                        {{--<td style="width: 15%;">{{ date('Y-m-d', strtotime($payment->created_at))}}</td>--}}
                        {{--<td>{{$payment->payment_reference}}</td>--}}
                        {{--<td>@if($sale){{$sale->reference_no}}@endif</td>--}}
                        {{--<td>@if($purchase){{$purchase->reference_no}}@endif</td>--}}

                        {{--@if( $sale !=null && $warehouse != null)--}}
                            {{--<td>{{$warehouse->name}}</td>--}}
                        {{--@else--}}
                            {{--<td>{{$warehouse->name}}</td>--}}
                        {{--@endif--}}

                        {{--@if($payment->paying_method == 'Credit Card' || $payment->paying_method == 'Cheque' )--}}
                            {{--<td>Credit Card</td>--}}
                        {{--@else--}}
                            {{--<td>{{$payment->paying_method}}</td>--}}
                        {{--@endif--}}
                        {{--<td>{{$payment->amount}}</td>--}}
                        {{--<td>{{$user->name}}<br>{{$user->email}}</td>--}}
                    {{--</tr>--}}
                {{--@endforeach--}}
                </tbody>
                <tfoot>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th>Total</th>
                <th>{{$amount}} BDT</th>
                <th></th>

                </tfoot>
            </table>
        </div>
    </section>

    <script type="text/javascript">
        $("ul#report").siblings('a').attr('aria-expanded','true');
        $("ul#report").addClass("show");
        $("ul#report li#payment-report-menu").addClass("active");


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

        $(".daterangepicker-field").daterangepicker({
            callback: function(startDate, endDate, warehouse_id){
                var start_date = startDate.format('YYYY-MM-DD');
                var end_date = endDate.format('YYYY-MM-DD');
                var title = start_date + ' to ' + end_date;
                var warehouse_id = warehouse_id;
                $(this).val(title);
                $('input[name="start_date"]').val(start_date);
                $('input[name="end_date"]').val(end_date);
                $('input[name="warehouse_id"]').val(warehouse_id);

            }
        });

    </script>
@endsection