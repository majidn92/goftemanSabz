@extends('common::layouts.master')
@section('post-aria-expanded')
    aria-expanded="true"
@endsection
@section('post-show')
    show
@endsection
@section('post')
    active
@endsection
@section('create_article')
    active
@endsection
@section('modal')
    @include('gallery::image-gallery')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('public/vendor/persian-datepicker/persian-datepicker.css') }}">
@endsection


@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
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
            </div>
            <!-- page info start-->
            {!! Form::open(['route' => ['save-new-post', 'article'], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'create-post-form']) !!}
            <input type="hidden" id="images" value="{{ $countImage }}">
            <input type="hidden" id="videos" value="{{ $countVideo }}">
            <input type="hidden" id="imageCount" value="1" class="imageCount">
            <input type="hidden" id="videoCount" value="1">
            <input type="hidden" name="category_ids">
            <input type="hidden" name="sub_category_ids">
            <div class="clearfix">
                <!-- Main Content section start -->
                <div class="add-new-page bg-white p-10 pb-1 row" style="margin-bottom: 0 !important">
                    <div class="col-6">
                        <div class="block-header">
                            <h2>افزودن خبر متنی</h2>
                        </div>
                    </div>
                    <div class="col-6 text-left">
                        <a href="{{ route('post') }}" class="btn btn-primary btn-add-new">
                            <i class="fas fa-list"></i>
                            {{ __('posts') }}
                        </a>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">رو تیتر</label>
                            <input id="post_on_title" onkeyup="metaTitleSet()" name="on_title" value="{{ old('on_title') }}" type="text" class="form-control" placeholder="رو تیتر را وارد نمائید">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="post_title" class="col-form-label">{{ __('title') }}*</label>
                            <input id="post_title" onkeyup="metaTitleSet()" name="title" value="{{ old('title') }}" type="text" class="form-control" placeholder="تیتر را وارد نمائید">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="post_sub_title" class="col-form-label">لید خبر</label>
                            <textarea name="sub_title" id="post_sub_title" cols="30" class="form-control" rows="4" placeholder="لید خبر را وارد نمائید">{{ old('sub_title') }}</textarea>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="post-slug" class="col-form-label">
                                <b>{{ __('slug') }}</b>
                            </label>
                            <input id="post-slug" name="slug" value="{{ old('slug') }}" type="text" class="form-control" placeholder="نامک را وارد نمائید">
                        </div>
                    </div>
                    <div class="mt-3">
                        <button id="editor-image-btn" class="btn btn-primary btn-image-modal" data-id="1">افزودن عکس</button>
                    </div>
                    <div class="mt-3">
                        <span class="btn btn-info" data-toggle="modal" data-target="#fileModal">افزودن فایل</span>
                    </div>
                    <!-- tinemcey start -->
                    <div class="col-12">
                        <label for="post_content" class="col-form-label">{{ __('content') }}*</label>
                        <textarea name="content" id="post_content" cols="30" rows="5" placeholder="متن خبر را وارد نمائید">{{ old('content') }}</textarea>
                    </div>
                </div>

                <div class="content-area">
                    {{-- all content --}}
                </div>
                <!-- visibility section start -->
                <div class="container mb-2">
                    @if (Sentinel::getUser()->hasAccess(['post_options']))
                        <div class="row add-new-page bg-white p-20 pt-0 mt-2">
                            <div class="col-sm-6 p-l-15 mt-2">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="add_to_breaking" name="breaking" class="custom-control-input" @if (old('breaking')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="add_to_breaking">فوری</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15 mt-2">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="chat_room" name="chat_room" class="custom-control-input" @if (old('chat_room')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="chat_room">اتاق گفتگو</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="featured_post" name="featured" class="custom-control-input" @if (old('featured')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="featured_post">ویژه</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="person_of_day" name="person_of_day" class="custom-control-input" @if (old('person_of_day')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="person_of_day">ویژه نگار</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="add_to_slide" name="slider" class="custom-control-input" @if (old('slider')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="add_to_slide">اسلایدر</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="opinion" name="opinion" class="custom-control-input" @if (old('opinion')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="opinion">دیدگاه</label>
                                </label>
                            </div>
                            <div class="col-sm-6 offset-6 p-l-15 mb-4">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="populare" name="populare" class="custom-control-input" @if (old('populare')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="populare">پربازدید</label>
                                </label>
                            </div>
                        </div>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['post_state&section']))
                        <div class="row add-new-page bg-white p-20 pt-0 mt-2">
                            <div class="col-sm-4 p-l-15">
                                <label>
                                    <b>استان </b>
                                    <span>(اختیاری)</span>
                                </label>
                                <select name="state_id[]" class="form-control" multiple>
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}" @php
                                            if (old('state_id')) {
                                                $state_ids = old('state_id');
                                            } else {
                                                $state_ids = [];
                                            }
                                        @endphp @if (count($state_ids)) @foreach ($state_ids as $item)
                @if ($item == $state->id) 
                selected @endif @endforeach
                                    @endif


                                    >{{ $state->name }}</option>
                    @endforeach
                    </select>
                </div>
                <div class="col-sm-4 p-l-15">
                    <label>
                        <b>بخش یا صنعت </b>
                        <span>(اختیاری)</span>
                    </label>
                    <select name="section_id[]" id="section" class="form-control" multiple>
                        @foreach ($sections as $section)
                            <option value="{{ $section->id }}" @php
                                if (old('section_id')) {
                                    $section_ids = old('section_id');
                                } else {
                                    $section_ids = [];
                                }
                            @endphp @if (count($section_ids)) @foreach ($section_ids as $item)
                            @if ($item == $section->id) 
                            selected @endif @endforeach
                        @endif
                        >{{ $section->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-sm-4 p-l-15">
                    <label>
                        <b>منبع خبر</b>
                        <span>(اختیاری)</span>
                    </label>
                    <select name="source_name" class="form-control">
                        <option value="0">--انتخاب نمائید--</option>
                        @foreach ($sources as $source)
                            <option value="{{ $source->name }}" @if (old('source_name')) @if (old('source_name') == $source->name) selected @endif @endif
                                >
                                {{ $source->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
        </div>

        <!-- visibility section end -->
        <!-- SEO section start -->
        <div class="row add-new-page  bg-white p-20 m-b-20" id="post_meta">
            <div class="col-sm-12 block-header">
                <h2>{{ __('seo_details') }}</h2>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="meta_title"><b>{{ __('meta_title') }}</b></label>
                    <input id="meta_title" class="form-control meta" value="{{ old('meta_title') }}" data-type="title" name="meta_title" placeholder="متاتگ عنوان را وارد نمائید">
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label for="post_desc">
                        <b>{{ __('meta_description') }}</b>
                    </label>
                    <textarea class="form-control meta" id="meta_description" name="meta_description" data-type="description" rows="3" placeholder="متاتگ توضیحات را وارد نمائید">{{ old('meta_description') }}</textarea>
                    </p>
                </div>
            </div>
            <div class="col-sm-12 mb-3">
                <div class="form-group" style="margin-bottom: 3px !important">
                    <label for="post-keywords" class="col-form-label"><b>{{ __('keywords') }}</b>
                    </label>
                    <input id="post-keywords" name="meta_keywords" value="{{ old('meta_keywords') }}" type="text" class="form-control" placeholder="کلمات کلیدی را وارد نمائید">
                </div>
                <div style="font-size: 13px">کلمات کلیدی را با اینتر از هم جدا نمائید</div>
            </div>
            <div class="col-sm-12">
                <div class="form-group" style="margin-bottom: 3px !important">
                    <label for="post_tags" class="col-form-label"><b>{{ __('tags') }}</b></label>
                    <input id="post_tags" name="tags" type="text" value="{{ old('tags') }}" data-role="tagsinput" class="form-control" placeholder="برچسب ها را وارد نمائید">
                </div>
                <div style="font-size: 13px">برچسب ها را با اینتر از هم جدا نمائید</div>
            </div>
        </div>
        <!-- SEO section end -->
        <!-- Main Content section end -->

        <!-- right sidebar start -->
        <div class="row p-20 m-b-20">
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="post_language">{{ __('select_language') }}*</label>
                    <select class="form-control dynamic-category" id="post_language" name="language" data-dependent="category_id">
                        @foreach ($activeLang as $lang)
                            <option @if (App::getLocale() == $lang->code) Selected @endif value="{{ $lang->code }}">{{ $lang->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="post_status">{{ __('publish') }}*</label>
                    <select class="form-control" id="post_status" name="status">
                        <option value="1">انتشار</option>
                        <option value="0">{{ __('draft') }}</option>
                        @if (Sentinel::getUser()->hasAccess(['scheduled_post']))
                            <option value="2">{{ __('scheduled') }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-sm-12 divScheduleDate">
                    <label for="scheduled_date">{{ __('schedule_date') }}</label>
                    <div class="input-group">
                        <label class="input-group-text" for="scheduled_date"><i class="fa fa-calendar-alt"></i></label>
                        <input type="text" class="form-control example1" name="scheduled_date" style="direction: rtl" />
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                @php
                    if (old('category_ids')) {
                        $category_ids = explode(',', old('category_ids'));
                    } else {
                        $category_ids = [];
                    }
                @endphp
                <div id="category-select-box" class="form-group">
                    <label>{{ __('category') }}*</label>
                    <div id="custom-category-drop-down-title">
                        @if (count($category_ids))
                            @foreach ($category_ids as $item)
                                <span class="badge ml-1" style="background: #ccc" data-category-id="{{ $item }}">
                                    <span class="fa fa-times" data-category-id="{{ $item }}" title="حذف این گروه"></span>
                                    @php
                                        $category = DB::table('categories')
                                            ->where('id', $item)
                                            ->first();
                                    @endphp
                                    {{ $category->category_name }}
                                </span>
                            @endforeach
                        @else
                            --انتخاب نمائید--
                        @endif
                    </div>
                    <div class="form-control" id="category-select" @if (count($category_ids)) style="display: block" @endif>
                        @foreach ($categories as $category)
                            <div class="option" style="margin-bottom: 2px" data-category-id="{{ $category->id }}">
                                <input data-category-id="{{ $category->id }}" data-category-name="{{ $category->category_name }}" type="checkbox" @foreach ($category_ids as $item) @if ($item == $category->id)
                                        checked @endif @endforeach>
                                {{ $category->category_name }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                @php
                    if (old('sub_category_ids')) {
                        $sub_category_ids = explode(',', old('sub_category_ids'));
                    } else {
                        $sub_category_ids = [];
                    }
                    
                    $cat_id = [];
                @endphp
                <div class="form-group" id="sub-category-box">
                    <label>{{ __('sub_category') }}</label>

                    <div id="custom-drop-down-box">
                        @if (count($sub_category_ids))
                            @foreach ($sub_category_ids as $sub_category_id)
                                @php
                                    $sub_cat = DB::table('sub_categories')
                                        ->where('id', $sub_category_id)
                                        ->first();
                                    $cat = DB::table('categories')
                                        ->where('id', $sub_cat->category_id)
                                        ->first();
                                @endphp
                                <span class="badge ml-1" style="background: #ccc" data-category-id="{{ $cat->id }}" data-sub-category-id="{{ $sub_cat->id }}">
                                    <span class="fa fa-times" data-category-id="{{ $cat->id }}" title="حذف این زیر گروه"></span>
                                    {{ $sub_cat->sub_category_name }}
                                </span>
                            @endforeach
                        @else
                            --انتخاب نمائید--
                        @endif
                    </div>

                    <div id="custom-drop-down" @if (count($category_ids)) style="display: block" @endif>
                        @if (count($category_ids))
                            @foreach ($category_ids as $category_id)
                                @php
                                    
                                    $category = DB::table('categories')
                                        ->where('id', $category_id)
                                        ->first();
                                    $sub_categories = DB::table('sub_categories')
                                        ->where('category_id', $category_id)
                                        ->get();
                                    
                                @endphp
                                <div class="category-box" data-category-id="{{ $category->id }}">
                                    <div class="category">{{ $category->category_name }}</div>
                                    @foreach ($sub_categories as $sub_category)
                                        <div class="option">
                                            <input type="checkbox" data-category-id="{{ $category->id }}" data-sub-category-id="{{ $sub_category->id }}" data-sub-category-name="{{ $sub_category->sub_category_name }}" @foreach ($sub_category_ids as $item) @if ($item == $sub_category->id) checked @endif @endforeach>
                                            {{ $sub_category->sub_category_name }}
                                        </div>
                                    @endforeach
                                </div>

                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
            <div class="col-sm-3 mt-3">
                <div class="form-group text-center">
                    <!-- Large modal -->
                    <button type="button" id="btn_image_modal" class="btn btn-primary btn-image-modal mb-2" data-id="1" data-toggle="modal" data-target=".image-modal-lg">{{ __('add_image') }}</button>
                    <input id="image_id" name="image_id" type="hidden" class="form-control image_id">
                    <div class="form-group">
                        <div class="form-group text-center">
                            <img src="{{ static_asset('default-image/default-100x100.png') }} " id="image_preview" alt="image" class="img-responsive img-thumbnail image_preview">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="form-group">
                    <label class="custom-control" for="btnSubmit"></label>
                    <button type="submit" name="btnSubmit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-plus"></i>{{ __('create_post') }}</button>
                    <label class="" for="btnSubmit"></label>
                </div>
            </div>
        </div>
        <!-- right sidebar end -->
    </div>
    {!! Form::close() !!}
    <!-- page info end-->
    </div>
    </div>

    <input type="hidden" value="0" id="content_number">
    @include('post::file_table')
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.dynamic-category').change(function() {
                if ($(this).val() != '') {
                    var select = $(this).attr("id");
                    var value = $(this).val();
                    var dependent = $(this).data('dependent');
                    var _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('category-fetch') }}",
                        method: "POST",
                        data: {
                            select: select,
                            value: value,
                            _token: _token
                        },
                        success: function(result) {
                            $('#' + dependent).html(result);
                        }
                    })
                }
            });

            $('#post_language').change(function() {
                $('#category_id').val('');
                $('#sub_category_id').val('');
            });




            ////////////////////////////////////////////////////////////////////////////////////////////////////////



            $('.dynamic').change(function() {
                var select = $(this).attr("id");
                var value = $(this).val();
                var dependent = $(this).data('dependent');
                var _token = "{{ csrf_token() }}";
                $.ajax({
                    url: "{{ route('subcategory-fetch') }}",
                    method: "POST",
                    data: {
                        select: select,
                        value: value,
                        _token: _token
                    },
                    success: function(result) {
                        $('#custom-drop-down').html(result);
                        $('#custom-drop-down').show();
                        if (result == '') {
                            $('#custom-drop-down').hide();
                        }
                    }
                })
            });

            category_ids = [];
            sub_category_ids = [];
            first_step = 0;

            // change subcategory input selection
            $(document).on('click', "#custom-drop-down .option input[type='checkbox']", function() {
                var sub_category_id = $(this).data('sub-category-id');
                if ($(this).is(':checked')) {
                    sub_category_ids.push(sub_category_id);
                } else {
                    sub_category_ids = sub_category_ids.filter(function(elem) {
                        return elem != sub_category_id;
                    });
                }
            });

            $("#custom-category-drop-down-title").click(function(e) {
                $("#category-select").toggle();
            });

            $("#custom-drop-down-box").click(function(e) {
                $("#custom-drop-down").toggle();
            });


            $("body").on('click',
                function(e) {
                    return true;
                    if ($(e.target).parents("#category-select-box").length == 0 && $(e.target).parents("#custom-drop-down").length == 0) {
                        $("#category-select").hide();
                        $("#custom-drop-down").hide();
                    }
                    if ($(e.target).parents("#custom-drop-down-box").length > 1) {
                        $("#custom-drop-down").toggle();
                    }
                }
            );

            // changed category check box event
            $("#category-select-box input").click(function(e) {
                let category_ids_count = "{{ count($category_ids) }}";
                var category_id = $(this).data('category-id');
                var category_name = $(this).data('category-name');
                if ($(this).is(':checked')) {
                    category_ids.push(category_id);
                    $(this).parent(".option").css("background", "#ccc");
                    var content = `<span class="badge ml-1" style="background: #ccc" data-category-id="${category_id}">
                                    <span class="fa fa-times" data-category-id="${category_id}" title="حذف این گروه"></span>
                                    ${category_name}
                                    </span>`;
                    console.log(category_ids_count);
                    if (first_step || category_ids_count > 0) {
                        $("#custom-category-drop-down-title").append(content);
                    } else {
                        first_step = 1;
                        $("#custom-category-drop-down-title").html(content);
                    }
                    var _token = "{{ csrf_token() }}";
                    $.ajax({
                        url: "{{ route('subcategory-fetch') }}",
                        method: "POST",
                        data: {
                            category_id: category_id,
                            _token: _token
                        },
                        success: function(result) {
                            $('#custom-drop-down').append(result);
                            $('#custom-drop-down').show();
                            if (result == '') {
                                $('#custom-drop-down').hide();
                            }
                        }
                    })

                } else {

                    category_ids = category_ids.filter(function(elem) {
                        return elem != category_id;
                    });

                    $(this).parent(".option").css("background", "white");

                    $("#custom-category-drop-down-title span.badge").each(function() {
                        var category_id_elem = $(this).data('category-id');
                        if (category_id_elem == category_id) {
                            $(this).remove();
                        }

                        var count = $("#custom-category-drop-down-title span.badge").length;
                        if (count == 0) {
                            $("#custom-category-drop-down-title").html("--انتخاب نمائید--");
                        }
                    });
                    $("#custom-drop-down .category-box").each(function() {
                        var category_id_elem = $(this).data('category-id');
                        if (category_id == category_id_elem) {
                            $(this).remove();
                        }
                    });

                    if ($("#custom-drop-down .category-box").length == 0) {
                        $("#custom-drop-down").hide();
                    }

                    $("#category-select-box input").each(function() {
                        var category_id_elem = $(this).data('category-id');
                        if (category_id == category_id_elem) {
                            $(this).prop('checked', false);
                            $(this).parents(".option").css("background", "white");
                        }
                        var count = $("#custom-category-drop-down-title span.badge").length;
                        if (count == 0) {
                            $("#custom-category-drop-down-title").html("--انتخاب نمائید--");
                            first_step = 0;
                        }
                    });

                    $("#custom-drop-down-box .badge").each(function() {
                        if ($(this).data('category-id') == category_id) {
                            $(this).remove();
                        }
                    });
                }
            });


            // press x button for delete category
            $(document).on('click', '#custom-category-drop-down-title span.fa-times', function() {
                var category_id = $(this).data('category-id');
                $(this).parent(".badge").remove();
                $("#category-select-box input").each(function() {
                    var category_id_elem = $(this).data('category-id');
                    if (category_id == category_id_elem) {
                        $(this).prop('checked', false);
                        $(this).parents(".option").css("background", "white");
                    }
                    var count = $("#custom-category-drop-down-title span.badge").length;
                    if (count == 0) {
                        $("#custom-category-drop-down-title").html("--انتخاب نمائید--");
                        first_step = 0;
                    }
                });

                $("#custom-drop-down .category-box").each(function() {
                    var category_id_elem = $(this).data('category-id');
                    if (category_id == category_id_elem) {
                        $(this).remove();
                    }
                });

                if ($("#custom-drop-down .category-box").length == 0) {
                    $("#custom-drop-down").hide();
                }

                $("#custom-drop-down-box .badge").each(function() {
                    if ($(this).data('category-id') == category_id) {
                        $(this).remove();
                    }
                });

                var subC_count = $("#custom-drop-down-box span.badge").length;
                if (subC_count == 0) {
                    $("#custom-drop-down-box").html('--انتخاب نمائید--');
                }
            });


            // $("#create-post-form").submit(function(e) {
            //     $("input[name='category_ids']").val(category_ids);
            //     $("input[name='sub_category_ids']").val(sub_category_ids);
            //     return true;
            // });



            $("#create-post-form").submit(function(e) {

                category_ids = [];
                sub_category_ids = [];

                $("#category-select input").each(function() {
                    if ($(this).is(":checked")) {
                        let cat_id = $(this).data('category-id');
                        category_ids.push(cat_id);
                    }
                });

                $("#custom-drop-down input").each(function() {
                    if ($(this).is(":checked")) {
                        let sub_cat_id = $(this).data('sub-category-id');
                        sub_category_ids.push(sub_cat_id);
                    }
                });

                $("input[name='category_ids']").val(category_ids);
                $("input[name='sub_category_ids']").val(sub_category_ids);
                return true;
            });



            //press x button for delete sub_category
            $(document).on('click', '#custom-drop-down-box .fa-times', function() {

                var sub_category_id = $(this).parent('.badge').data('sub-category-id');
                $("#custom-drop-down input").each(function() {
                    if ($(this).data("sub-category-id") == sub_category_id && $(this).is(":checked")) {
                        $(this).prop("checked", false);
                    }
                });
                $(this).parent('span.badge').remove();

                var count = $("#custom-drop-down-box .badge").length;
                if (count == 0) {
                    $("#custom-drop-down-box").html('--انتخاب نمائید--');
                }

                sub_category_ids = sub_category_ids.filter(function(elem) {
                    return elem != sub_category_id;
                });

            });


            // change input sub_category
            $(document).on('change', '#custom-drop-down input', function(e) {
                e.preventDefault();
                var count = $("#custom-drop-down-box .badge").length;
                var category_id = $(this).data('category-id');
                var sub_category_id = $(this).data('sub-category-id');
                var sub_category_name = $(this).data('sub-category-name');

                if ($(this).is(":checked")) {
                    var content = `<span class="badge ml-1" style="background: #ccc" data-category-id="${category_id}" data-sub-category-id="${sub_category_id}">
                                    <span class="fa fa-times" data-category-id="${category_id}" title="حذف این زیر گروه"></span>
                                    ${sub_category_name}
                                </span>`;
                    if (count == 0) {
                        $("#custom-drop-down-box").html(content);
                    } else {
                        $("#custom-drop-down-box").append(content);
                    }
                } else {
                    $(this).parent('span.badge').remove();
                    $("#custom-drop-down-box .badge").each(function() {
                        if ($(this).data("sub-category-id") == sub_category_id) {
                            $(this).remove();
                        }
                    });
                    if (count == 1) {
                        $("#custom-drop-down-box").html('--انتخاب نمائید--');
                    }

                    sub_category_ids = sub_category_ids.filter(function(elem) {
                        return elem != sub_category_id;
                    });

                }

            });

            //////////////////////////////////////////////////////////////////////////////////////////////////



            $('#category').change(function() {
                $('#sub_category_id').val('');
            });
        });
    </script>
    <script type="text/javascript" src="{{ static_asset('js/post.js') }}"></script>
    <script type="text/javascript" src="{{ static_asset('js/tagsinput.js') }}"></script>
    <script>
        addContent = function(value) {

            var content_number = $("#content_number").val();
            content_number++;

            $.ajax({
                url: "{{ route('add-content') }}",
                method: "GET",
                data: {
                    value: value,
                    content_count: content_number
                },
                success: function(result) {
                    $('.content-area').append(result);
                    $("#content_number").val(content_number);

                    // auto scrolling to newly added element
                    var newlyAdded = 'content_' + content_number;
                    $('body, html').animate({
                        scrollTop: $('.' + newlyAdded).offset().top
                    }, 1000);
                }
            });
        }

        $(document).on("click", ".add-new-page .row_remove", function() {
            let element = $(this).parents('.add-new-page');
            element.hide("slow", function() {
                $(this).remove();
            })
        });
    </script>

    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-date.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-datepicker.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(".example1").pDatepicker({
                'timePicker': {
                    'enabled': false,
                },
                format: ' H:m:s YYYY/MM/DD ',

            });


            $("input[name='title']").blur(function() {
                $("input[name='meta_title']").val($(this).val());
                var text = $(this).val();
                text = text.replace(/\ /g, "-");
                $("input[name='slug']").val(text);
            });

            $("textarea[name='sub_title']").blur(function() {
                $("textarea[name='meta_description']").val($(this).val());
            });
        });
    </script>
    <script src="{{ url('public/js/multiselect-dropdown.js') }}"></script>
    <script>
        $(".multiselect-dropdown").addClass("form-control");
    </script>
    <script>
        $("#post-keywords").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).val($(this).val() + ',');
            }
        });

        $("#meta_title").bind("keypress", function(e) {
            if (e.keyCode == 13) {
                e.preventDefault();
            }
        });

        $("select[name='source_name']").change(function() {
            let content = tinyMCE.activeEditor.getContent();
            let name = $(this).val();
            if (name != 0) {
                content = content + '<p class="endOfMessage">منبع خبر: ' + name + '</p>';
                tinyMCE.activeEditor.setContent(content);
            } else {
                $.each(tinyMCE.activeEditor.$('.endOfMessage'),function(){
                    $(this).remove();
                });
            }
        });
    </script>
@endsection
