@extends('layout.main')
@section('content')
<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Update Product Tag</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <form id="product-form" action="{{ route('update-product_tag') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $product_tag->id }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="input-group pos">
                                        <label class="d-block">Product*</label>
                                        <select required name="product_id" id="product_id" class="selectpicker form-control" data-live-search="true" data-live-search-style="begins" title="Select Product...">
                                            <?php $deposit = []; ?>
                                            @foreach($products as $product)
                                                <?php $deposit[$product->id] = $product->deposit - $product->expense; ?>
                                                <option value="{{$product->id}}" {{(@$product_tag->product_id==$product->id)?"selected":""}}>{{$product->name . ' (' . $product->code . ')'}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tag Name *</strong> </label>
                                        <select name="tag_id[]" class="selectpicker form-control" multiple data-max-options="10">
                                            @foreach($tags as $tag)
                                                <option value="{{$tag->id}}" {{(@$product_tag->tag_id==$tag->id)?"selected":""}}>{{$tag->tag_name}} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>


                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>




@endsection