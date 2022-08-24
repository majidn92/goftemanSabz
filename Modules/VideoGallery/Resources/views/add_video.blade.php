@extends('common::layouts.master')

@section('video-aria-expanded')
    aria-expanded="true"
@endsection
@section('video-show')
    show
@endsection
@section('video')
    active
@endsection
@section('videos-active')
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
                        <div class="col-12 col-lg-8">
                            <form class="author-form" name="author-form" method="post" action="{{ route('video.store.video') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="add-new-page  bg-white p-20 m-b-20">
                                    <div class="add-new-header clearfix m-b-20">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="block-header">
                                                    <h2>افزودن ویدئو</h2>
                                                </div>
                                            </div>
                                            @if (Sentinel::getUser()->hasAccess(['post_write']))
                                                <div class="col-6 text-left">
                                                    <a href="{{ route('video.videos') }}" class="btn btn-primary btn-sm btn-add-new"><i class="fa fa-bars"></i>
                                                        ویدئوها
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="language">{{ __('select_language') }} *</label>
                                                <select class="form-control dynamic-album" id="language" name="language" video data-dependent="album_id">
                                                    @foreach ($activeLang as $lang)
                                                        <option @if (App::getLocale() == $lang->code) Selected @endif value="{{ $lang->code }}">{{ $lang->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="rank" class="col-form-label">جایگاه نمایش
                                                </label>
                                                <input id="rank" name="rank" value="1" type="number" min="1" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="category_id">گروه *</label>
                                                <select class="form-control dynamic-album-tab" id="category_id" name="category_id" video>
                                                    <option value="">انتخاب گروه</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="section_id">انتخاب بخش یا صنعت *</label>
                                                <select class="form-control dynamic-album-tab" id="section_id" name="section_id">
                                                    <option value="">انتخاب بخش یا صنعت</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}" @if ($section->id == 1) selected @endif>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="image-slug" class="col-form-label">{{ __('title') }}
                                                </label>
                                                <input id="image-slug" name="title" value="" type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 offset-6 p-l-5 my-3">
                                            <label class="custom-control custom-checkbox pt-1">
                                                <input type="checkbox" id="featured" name="featured" class="custom-control-input">
                                                <span class="custom-control-label"></span>
                                                <label for="featured">افزودن به ویژه ها</label>
                                            </label>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field">
                                                <label for="cover" class="upload-file-btn btn btn-primary">انتخاب کاور *
                                                </label><br>
                                                <input type="file" id="cover" class="d-none " name="cover">
                                            </div>
                                            <img id="coverImg">
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="field">
                                                <label for="video" class="upload-file-btn btn btn-primary">انتخاب ویدئو *
                                                </label><br>
                                                <input type="file" id="video" class="d-none " name="video">
                                            </div>
                                            <video controls width="80%">
                                                <source id="video_here">
                                                Your browser does not support HTML5 video.
                                            </video>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 m-t-20">
                                            <div class="form-group form-float form-group-sm text-right">
                                                <button type="submit" name="btnsubmit" class="btn btn-primary"><i class="m-l-5 mdi mdi-plus"></i>{{ __('save') }}</button>
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
        cover.onchange = evt => {
            const [file] = cover.files
            if (file) {
                coverImg.src = URL.createObjectURL(file)
            }
        }

        $(document).on("change", "#video", function(evt) {
            var $source = $('#video_here');
            $source[0].src = URL.createObjectURL(this.files[0]);
            $source.parent()[0].load();
        });
    </script>
@endsection
