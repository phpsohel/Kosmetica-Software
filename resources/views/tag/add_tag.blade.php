@extends('layout.main')
@section('content')

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Create Tag</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <form id="product-form" action="{{ route('store-tag') }}" method="POST" enctype="multipart/form-data">
                        	@csrf
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Tag Name(en) *</strong> </label>
                                        <input type="text" name="tag_name" class="form-control" id="tag_name" aria-describedby="tag_name" required>
                                        <span class="validation-msg" id="blog_title-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label><strong>Tag Name(ar) *</strong> </label>
                                        <input type="text" name="tag_name_ar" class="form-control" id="tag_name" aria-describedby="tag_name" required>
                                        <span class="validation-msg" id="blog_title-error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Tag Parent Name *</strong> </label>
                                        {{--<input type="text" name="tag_parent_name" class="form-control" id="tag_parent_title" aria-describedby="tag_parent_title" required>--}}
                                        <select name="tag_parent_name" class="form-control form-control-sm">
                                            <option value="">Select</option>
                                            <option value="Skin Type">Skin Type</option>
                                            <option value="Skin Concern">Skin Concern</option>
                                            <option value="Routine">Routine</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> Image *</strong> </label>
                                        <input type="file" name="image" class="form-control" id="image" aria-describedby="image" required>
                                        <span class="validation-msg" id="image-error"></span>
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
