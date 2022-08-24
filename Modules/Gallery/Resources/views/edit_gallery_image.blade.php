@extends('common::layouts.master')
@section('gallery-aria-expanded')
    aria-expanded="true"
@endsection
@section('gallery-show')
    show
@endsection
@section('gallery')
    active
@endsection
@section('all-images-active')
    active
@endsection

@section('style')
    <style>
        .delete-img:hover {
            color: red
        }
    </style>
@endsection

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            <div class="row clearfix">
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            @if (session('error'))
                                <div id="error_m" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            @if (session('success'))
                                <div id="success_m" class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                        <!-- Main Content section start -->
                        <div class="col-12">
                            <form class="author-form" name="author-form" method="post" action="{{ route('update-album-image') }}" enctype="multipart/form-data">
                                @csrf
                                <input name="image_id" value="{{ $image->id }}" type="hidden">
                                <input name="ids" value="" type="hidden">
                                <div class="add-new-page  bg-white p-20 m-b-20">
                                    <div class="add-new-header clearfix m-b-20">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="block-header">
                                                    <h2>ویرایش آلبوم</h2>
                                                </div>
                                            </div>
                                            @if (Sentinel::getUser()->hasAccess(['post_write']))
                                                <div class="col-6 text-left">
                                                    <a href="{{ route('images') }}" class="btn btn-primary btn-sm btn-add-new"><i class="fa fa-bars"></i>
                                                        آلبوم تصاویر
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="image-slug" class="col-form-label">{{ __('title') }}
                                                </label>
                                                <input id="image-slug" name="title" value="{{ $image->title }}" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="cover" class="upload-file-btn btn btn-primary">
                                                    <i class="fa fa-folder input-file" aria-hidden="true"></i> تصویر کاور آلبوم
                                                </label>
                                                <input id="cover" name="cover" value="" type="file" style="display: none">
                                                <img id="cover_preview" src="{{ static_asset($image->original_image) }}" alt="" style="display: block">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="alert alert-info" role="alert" style="color: white;font-size: 16px">سایر تصاویر</div>
                                            <div class="row">
                                                @foreach ($image->gallery_images as $item)
                                                    <div class="col-sm-2">
                                                        <i data-id="{{ $item->id }}" class="fa fa-times delete-img" style="position: absolute;left:17px;cursor: pointer;" title="حذف"></i>
                                                        <img src="{{ static_asset($item->original_image) }}" alt="" width="100%">
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="col-sm-12 mt-3 mb-2">
                                            <div class="field">
                                                <label for="images" class="upload-file-btn btn btn-primary">
                                                    <i class="fa fa-folder input-file" aria-hidden="true"></i> افزودن تصاویر جدید
                                                </label>
                                                <br>
                                                <input type="file" id="images" class="d-none " name="files[]" multiple />
                                            </div>
                                        </div>
                                        <br>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 m-t-20">
                                            <div class="form-group form-float form-group-sm text-right">
                                                <button type="submit" name="btnsubmit" class="btn btn-primary"><i class="m-l-10 fa fa-save"></i>ذخیره</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            {{-- {!! Form::close() !!} --}}
                        </div>
                        <!-- Main Content section end -->

                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#cover").change(function() {
            cover_preview.src = URL.createObjectURL(this.files[0]);
        });

        $(".delete-img").click(function() {
            var id = $(this).data('id');
            var input = $('[name="ids"]');
            input.val(id + ',' + input.val());
            $(this).parents('.col-sm-2').hide();
            console.log($('[name="ids"]').val());
        });
    </script>
@endsection
