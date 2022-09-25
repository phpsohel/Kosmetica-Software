@extends('layout.main')
@section('content')
 <div class="card-header d-flex align-items-center">
         <h4>Product Tag List</h4>
		<hr>
		<a href="{{route('add-product-tag')}}" class="btn btn-info" style="float: right"><i class="dripicons-plus"></i>Add Product Tag</a>
</div>
<section>
    <div class="table-responsive">
        <table id="product-data-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Tag Name</th>
                    <th class="not-exported">Action</th>
                </tr>
            </thead>
            <tbody>

            	@foreach($product_tags as $key => $row)
            	<tr>
            		<td></td>
            		<td>{{ $key+1 }}</td>
            		<td>{{$row['product']['name']}}</td>
            		<td>{{$row['tag']['tag_name']}}</td>
            		<td>
            			<a type="button" class="btn btn-primary" href="{{ route('edit-product-tag', $row->id) }}">Edit</a>
            			<a type="button" class="btn btn-primary" href="{{ route('delete-product-tag', $row->id) }}">Delete</a>
            		</td>
            	</tr>

            	@endforeach
            </tbody>
            
        </table>
    </div>
</section>


@endsection