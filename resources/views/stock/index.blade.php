@extends('layout.main') @section('content')
    <section class="forms">
        <div class="container-fluid">
            <h4 class="text-center">Stock List</h4>
        </div>
        <div class="table-responsive mb-4">
            <table id="stock-count-table" class="table table-hover">
                <thead>
                <tr>
                    <th class="not-exported">SL</th>
                    <th> Product Name</th>
                    <th>Code</th>
                    @php
                        $warehouses=  \App\Warehouse::orderBy('id','DESC')->get();
                    @endphp
                    @foreach($warehouses as $ware )
                        <th>{{$ware->name}}</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($products as $key=>$product)
                    <tr>
                        <td >{{$key +1}}</td>
                        <td style="width: 15%">{{$product->name}}</td>
                        <td>{{$product->code}}</td>
                        @foreach($warehouses as $ware )
                            @php
                                $product_info = \App\Product_Warehouse::where('product_id', $product->id)->where('warehouse_id',$ware->id)->first();
                           //  dd($product_info);
                            @endphp
                            @if($product_info != null)
                                <td>{{$product_info->qty}}</td>
                            @else
                                <td>0</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection


