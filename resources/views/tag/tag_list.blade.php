@extends('layout.main')

@section('content')
 <div class="card-header d-flex align-items-center">
         <h4>Tag List</h4>

		<hr>
		<a href="{{route('add-tag')}}" class="btn btn-info" style="float: right"><i class="dripicons-plus"></i>Add Tag</a>
</div>
<section>

    <div class="table-responsive">
        <table id="product-data-table" class="table" style="width: 100%">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>#</th>
                    <th>Tag Name(en)</th>
                    <th>Tag Name(ar)</th>
                    <th>Tag Parent Name</th>
                    <th>Image</th>
                    <th class="not-exported">Action</th>
                </tr>
            </thead>
            <tbody>
            	@php($i=1)
            	@foreach($tags as $key => $row)
            	<tr>
            		<td></td>
            		<td>{{ $key+1 }}</td>
            		<td>{{ $row->tag_name }}</td>
            		<td>{{ $row->tag_name_ar }}</td>
            		<td>{{ $row->tag_parent_name }}</td>
            		<td><img src="{{ $row->image }}" style="height: 50px; width: 100px;"></td>
            		<td>
            			<a type="button" class="btn btn-primary" href="{{ route('edit-tag', $row->id) }}">Edit</a>
            			<a type="button" class="btn btn-primary" href="{{ route('delete-tag', $row->id) }}">Delete</a>
            		</td>
            	</tr>
            	@php($i++)
            	@endforeach
            </tbody>

        </table>
    </div>
</section>


@endsection
