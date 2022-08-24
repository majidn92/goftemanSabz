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
                            <form class="author-form" name="author-form" method="post" action="{{ route('add-album-image') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="add-new-page  bg-white p-20 m-b-20">
                                    <div class="add-new-header clearfix m-b-20">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="block-header">
                                                    <h2>افزودن آلبوم</h2>
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
                                                <input id="image-slug" name="title" value="" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="cover" class="upload-file-btn btn btn-primary">
                                                    <i class="fa fa-folder input-file" aria-hidden="true"></i> تصویر کاور آلبوم
                                                </label>
                                                <input id="cover" name="cover" value="" type="file" style="display: none">
                                                <img id="cover_preview" src="{{static_asset('default-image/default-255x175.png')}}" alt="" style="display: block">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="field">
                                                <label for="images" class="upload-file-btn btn btn-primary">
                                                    <i class="fa fa-folder input-file" aria-hidden="true"></i> انتخاب تصاویر
                                                </label>
                                                <br>
                                                <input type="file" id="images" class="d-none " name="files[]" required multiple />
                                            </div>
                                        </div>
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
        $("#cover").change(function () { 
            cover_preview.src=URL.createObjectURL(this.files[0]);
        });
    </script>
@endsection
