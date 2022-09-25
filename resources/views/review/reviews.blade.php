@extends('layout.main')
@section('content')
    @if($errors->has('name'))
        <div class="alert alert-danger alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
    @endif
    @if(session()->has('message'))
        <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
    @endif
    @if(session()->has('not_permitted'))
        <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
    @endif

    <section>
        <div class="table-responsive">
            <table id="warehouse-table" class="table">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th >Comment</th>
                    <th>Date</th>
                    <th class="not-exported">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reviews as $key => $row)
                    @php


                        $product = \App\Product::where('id',$row->product_id)->first();
                    // dd($product);
                    @endphp
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{ $row->customer->name }}</td>
                        <td>{{ $product->name }}</td>
                        <td style="max-width:60%;">{{ $row->comment }}</td>
                        <td>{{ \Carbon\Carbon::parse($row->date)->format('Y-m-d') }}</td>
                        <td>
                            <a type="button" class="btn btn-danger" href="{{ route('review.delete', $row->id) }}">Delete</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <script type="text/javascript">

        $('#warehouse-table').DataTable( {
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
                    'targets': [1, 5]
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
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                },
                {
                    extend: 'csv',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                },
                {
                    extend: 'print',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                },
                {
                    text: '{{trans("file.delete")}}',
                    className: 'buttons-delete',
                    // action: function ( e, dt, node, config ) {
                    //     if(user_verified == '1') {
                    //         warehouse_id.length = 0;
                    //         $(':checkbox:checked').each(function(i){
                    //             if(i){
                    //                 warehouse_id[i-1] = $(this).closest('tr').data('id');
                    //             }
                    //         });
                    //         if(warehouse_id.length && confirm("Are you sure want to delete?")) {
                    //             $.ajax({
                    //                 type:'POST',
                    //                 url:'warehouse/deletebyselection',
                    //                 data:{
                    //                     warehouseIdArray: warehouse_id
                    //                 },
                    //                 success:function(data){
                    //                     alert(data);
                    //                 }
                    //             });
                    //             dt.rows({ page: 'current', selected: true }).remove().draw(false);
                    //         }
                    //         else if(!warehouse_id.length)
                    //             alert('No warehouse is selected!');
                    //     }
                    //     else
                    //         alert('This feature is disable for demo!');
                    // }
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                },
            ],
        } );


    </script>
@endsection