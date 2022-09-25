@extends('layout.main')

@section('content')

<section class="forms">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center">
                        <h4>Update Tag</h4>
                    </div>
                    <div class="card-body">
                        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
                        <form id="product-form" action="{{ route('update-tag') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $tag->id }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> <strong>Tag Name(en) *</strong> </label>
                                        <input type="text" name="tag_name" class="form-control" id="blog_title" aria-describedby="tag_name" value="{{ $tag->tag_name }}" required>
                                        <span class="validation-msg" id="tag_name-error"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>  <strong>Tag Name(ar) *</strong> </label>
                                        <input type="text" name="tag_name_ar" class="form-control" id="blog_title" aria-describedby="tag_name" value="{{ $tag->tag_name_ar }}" required>
                                        <span class="validation-msg" id="tag_name-error"></span>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> <strong>Tag Parent Name *</strong> </label>
                                        <select name="tag_parent_name" class="form-control form-control-sm">
                                            <option value="">Select</option>
                                            <option value="Skin Type" {{($tag->tag_parent_name=='Skin Type')?"selected":''}}>Skin Type</option>
                                            <option value="Skin Concern" {{($tag->tag_parent_name=='Skin Concern')?"selected":''}}>Skin Concern</option>
                                            <option value="Routine {{( $tag->tag_parent_name=='Routine')?"selected":''}}">Routine</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label> <strong>Image *</strong> </label>
                                        <input type="hidden" name="image_old" value="{{ $tag->image }}">
                                        <input type="file" name="image" class="form-control" id="image" aria-describedby="image">
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
