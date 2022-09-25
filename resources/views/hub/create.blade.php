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
        <div class="container-fluid">
            <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="dripicons-plus"></i>Add Hub</a>
        </div>
        <div class="table-responsive">
            <table id="warehouse-table" class="table">
                <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>Name</th>
                    <th>Warehouse</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.Email')}}</th>
                    <th>{{trans('file.Address')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
                </thead>
                <tbody>
                   @foreach($lims_warehouse_all as $key=>$warehouse)

                       @php
                       $val = \App\Warehouse::where('id',$warehouse->warehouse_id)->first();


                       @endphp
                    <tr data-id="{{$warehouse->id}}">
                        <td>{{$key}}</td>
                        <td>{{ $warehouse->hub_name }}</td>
                        @php
                            $val = \App\Warehouse::where('id',$warehouse->warehouse_id)->first();
                        @endphp
                        <td>{{ $val->name }}</td>
                        <td>{{ $warehouse->phone}}</td>
                        <td>{{ $warehouse->email}}</td>
                        <td>{{ $warehouse->address}}</td>
                        <td>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                    <span class="caret"></span>
                                    <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                    <li>
                                        <button type="button" data-id="{{$warehouse->id}}" class="open-EditWarehouseDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}
                                        </button>
                                    </li>
                                    <li class="divider"></li>
                                    {{ Form::open(['route' => ['hub.destroy', $warehouse->id], 'method' => 'DELETE'] ) }}
                                    <li>
                                        <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                    </li>
                                    {{ Form::close() }}
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => 'hub.store', 'method' => 'post']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title">Add Hub</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>

                    @php
                    $warehouses = \App\Warehouse::get();
                    @endphp
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Warehouse</label>
                            <select class="form-control"  name="warehouse_id" id="">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $val)
                                <option value="{{$val->id}}">{{$val->name}}</option>
                               @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6" >
                            <label>{{trans('file.name')}} *</label>
                            <input type="text" placeholder="Type Hub Name..." name="hub_name" required="required" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Phone Number')}} *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Email')}}</label>
                            <input type="email" name="email" placeholder="example@example.com" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Address')}} *</label>
                            <input type="text" name="address" placeholder="" class="form-control">
                            {{--<textarea required class="form-control" rows="3" name="address"></textarea>--}}
                        </div>
                    </div>


                    <div class="form-group">
                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
        <div role="document" class="modal-dialog">
            <div class="modal-content">
                {!! Form::open(['route' => ['hub.update',1], 'method' => 'put']) !!}
                <div class="modal-header">
                    <h5 id="exampleModalLabel" class="modal-title"> Update Hub</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
                </div>
                <div class="modal-body">
                    <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                    <?php
                    $lims_expense_category_list = DB::table('hubs')->get();
                    if(Auth::user()->role_id > 2)
                        $lims_warehouse_list = DB::table('warehouses')->where([
                            ['is_active', true],
                            ['id', Auth::user()->warehouse_id]
                        ])->get();
                    else
                        $lims_warehouse_list = DB::table('warehouses')->where('is_active', true)->get();
                    ?>

                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Warehouse</label>
                            <select class="selectpicker form-control"  name="warehouse_id" id="warehouse_id" data-live-search="true" data-live-search-style="begins" title="Select warehouse...">
                                @foreach($lims_warehouse_list as $val)
                                    <option value="{{$val->id}}">{{$val->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-md-6" >
                            <label>{{trans('file.name')}} *</label>
                            <input type="text" placeholder="Type Hub Name..." name="hub_name" required="required" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Phone Number')}} *</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Email')}}</label>
                            <input type="email" name="email" placeholder="example@example.com" class="form-control">
                        </div>
                        <div class="form-group col-md-6">
                            <label>{{trans('file.Address')}} *</label>
                            <input type="text" name="address" placeholder="" class="form-control">
                            {{--<textarea required class="form-control" rows="3" name="address"></textarea>--}}
                        </div>

                        <div class="form-group col-md-6">
                            <input type="hidden" name="hub_id" placeholder="" class="form-control">
                            {{--<textarea required class="form-control" rows="3" name="address"></textarea>--}}
                        </div>
                    </div>


                    <div class="form-group">
                        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <script type="text/javascript">

        $("ul#setting").siblings('a').attr('aria-expanded','true');
        $("ul#setting").addClass("show");
        $("ul#setting #warehouse-menu").addClass("active");

        var hub_id = [];
        var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function confirmDelete() {
            if (confirm("Are you sure want to delete?")) {
                return true;
            }
            return false;
        }

        $(document).ready(function() {

            $('.open-EditWarehouseDialog').on('click', function() {
                var url = "hub/"
                var id = $(this).data('id').toString();
                url = url.concat(id).concat("/edit");

                $.get(url, function(data) {
                    //console.log(data);
                    $("#editModal select[name='warehouse_id']").val(data['warehouse_id']);
                    $("#editModal input[name='hub_name']").val(data['hub_name']);
                    $("#editModal input[name='phone']").val(data['phone']);
                    $("#editModal input[name='email']").val(data['email']);
                    $("#editModal input[name='address']").val(data['address']);
                    $("#editModal input[name='hub_id']").val(data['id']);

                });
            });
        });

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
                    'targets': [0, 5 ]
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
                    action: function ( e, dt, node, config ) {
                        if(user_verified == '1') {
                            hub_id.length = 0;
                            $(':checkbox:checked').each(function(i){
                                if(i){
                                    hub_id[i-1] = $(this).closest('tr').data('id');
                                }
                            });
                            if(hub_id.length && confirm("Are you sure want to delete?")) {
                                $.ajax({
                                    type:'POST',
                                    url:'warehouse/deletebyselection',
                                    data:{
                                        warehouseIdArray: hub_id
                                    },
                                    success:function(data){
                                        alert(data);
                                    }
                                });
                                dt.rows({ page: 'current', selected: true }).remove().draw(false);
                            }
                            else if(!hub_id.length)
                                alert('No warehouse is selected!');
                        }
                        else
                            alert('This feature is disable for demo!');
                    }
                },
                {
                    extend: 'colvis',
                    columns: ':gt(0)'
                },
            ],
        } );

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $( "#select_all" ).on( "change", function() {
            if ($(this).is(':checked')) {
                $("tbody input[type='checkbox']").prop('checked', true);
            }
            else {
                $("tbody input[type='checkbox']").prop('checked', false);
            }
        });

        $("#export").on("click", function(e){
            e.preventDefault();
            var warehouse = [];
            $(':checkbox:checked').each(function(i){
                warehouse[i] = $(this).val();
            });
            $.ajax({
                type:'POST',
                url:'/exportwarehouse',
                data:{

                    warehouseArray: warehouse
                },
                success:function(data){
                    alert('Exported to CSV file successfully! Click Ok to download file');
                    window.location.href = data;
                }
            });
        });
    </script>
@endsection