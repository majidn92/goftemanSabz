@extends('common::layouts.master')
{{-- {{dd(old('state_id'))}} --}}
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
    @include('gallery::video-gallery')
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('public/vendor/persian-datepicker/persian-datepicker.css') }}">
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            {!! Form::open(['route' => ['update-post', 'article', $post->id], 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'edit-post-form']) !!}
            <input type="hidden" id="images" value="{{ $countImage }}">
            <input type="hidden" id="videos" value="{{ $countVideo }}">
            <input type="hidden" id="imageCount" value="1">
            <input type="hidden" name="category_ids">
            <input type="hidden" name="sub_category_ids">
            <div class="row">
                <div class="col-6">
                    <div class="block-header">
                        <h2>ویرایش خبر متنی</h2>
                    </div>
                </div>
                <div class="col-6 text-left">
                    <a href="{{ route('post') }}" class="btn btn-primary btn-add-new"><i class="fas fa-list"></i> {{ __('posts') }}
                    </a>
                </div>
            </div>
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
                    <div class="add-new-page  bg-white">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="post_on_title" class="col-form-label">رو تیتر</label>
                                <input id="post_on_title" onkeyup="metaTitleSet()" name="on_title" value="{{ old('on_title') ?? $post->on_title }}"   type="text" class="form-control" placeholder="رو تیتر را وارد نمائید">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="post_title" class="col-form-label">{{ __('title') }}*</label>
                                <input id="post_title" name="title" value="{{ old('title') ?? $post->title }}" type="text" class="form-control" placeholder="تیتر را وارد نمائید">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="post_sub_title" class="col-form-label">لید خبر</label> 
                                <textarea name="sub_title" id="post_sub_title" cols="30" class="form-control" rows="4" placeholder="لید خبر را وارد نمائید">{{ old('sub_title') ?? $post->sub_title }}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="post-slug" class="col-form-label">
                                    <b>{{ __('slug') }}</b>
                                </label>
                                <input id="post-slug" name="slug" value="{{ old('slug') ?? $post->slug }}" type="text" class="form-control" placeholder="نامک را وارد نمائید">
                            </div>
                        </div>
                        <div class="mt-3">
                            <button id="editor-image-btn" class="btn btn-primary btn-image-modal" data-id="1">افزودن عکس</button>
                        </div>
                        <div class="mt-3">
                            <span class="btn btn-info" data-toggle="modal" data-target="#fileModal">افزودن فایل</span>
                        </div>
                        <!-- tinemcey start -->
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <label for="post_content" class="col-form-label">{{ __('content') }}*</label>
                                    <textarea name="content" id="post_content" cols="30" rows="5">{!! old('content') ?? $post->content !!}</textarea>
                                </div>
                            </div>
                        </div>
                        <!-- tinemcey end -->
                    </div>

                    <div class="content-area">
                        {{-- all content --}}
                        @php
                            $content_count = 0;
                        @endphp
                        @foreach ($post_contents as $page => $content)
                            @php
                                $page = array_keys($content);
                                $content_count++;
                            @endphp
                            @include('post::contents/' . $page[0], compact('content_count', 'content'))
                        @endforeach
                        {{-- all content --}}
                    </div>
                    <!-- visibility section start -->
                    @if (Sentinel::getUser()->hasAccess(['post_options']))
                        <div class="row add-new-page  bg-white p-20 m-b-20">
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="add_to_breaking" name="breaking" class="custom-control-input" @if ($post->breaking == 1 || old('breaking')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="add_to_breaking">فوری</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="chat_room" name="chat_room" class="custom-control-input" @if ($post->chat_room == 1 || old('chat_room')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="chat_room">اتاق گفتگو</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="featured_post" name="featured" class="custom-control-input" @if ($post->featured == 1 || old('featured')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="featured_post">ویژه</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="person_of_day" name="person_of_day" class="custom-control-input" @if ($post->person_of_day == 1 || old('person_of_day')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="person_of_day">ویژه نگار</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="add_to_slide" name="slider" class="custom-control-input" @if ($post->slider == 1|| old('slider')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="add_to_slide">اسلایدر</label>
                                </label>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="opinion" name="opinion" class="custom-control-input" @if ($post->opinion == 1 || old('opinion')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="opinion">دیدگاه</label>
                                </label>
                            </div>
                            <div class="col-sm-6 offset-6 p-l-15 pt-1">
                                <label class="custom-control custom-checkbox pt-1">
                                    <input type="checkbox" id="populare" name="populare" class="custom-control-input" @if ($post->populare == 1 || old('populare')) checked @endif>
                                    <span class="custom-control-label"></span>
                                    <label for="populare">پربازدید</label>
                                </label>
                            </div>
                        </div>
                    @endif
                    @if (Sentinel::getUser()->hasAccess(['post_state&section']))
                        <div class="row add-new-page  bg-white p-20 m-b-20">
                            <div class="col-sm-6 p-l-15">
                                @php
                                    $states = DB::table('states')->get();
                                @endphp
                                <label><b>استان</b></label>
                                <select name="state_id[]" class="form-control" multiple>
                                    @if (!$post->state)
                                        <option value="">--انتخاب نمائید--</option>
                                    @endif
                                    
                                    @foreach ($states as $state)
                                        <option value="{{ $state->id }}"
                                            @foreach ($post->state as $item) 
                                            @if ($state->id == $item->id) selected @endif
                                             @endforeach

                                             @if (old('state_id'))
                                             @foreach (old('state_id') as $old_id) 
                                             @if ($state->id == $old_id) selected @endif
                                              @endforeach
                                             @endif
                                              >
                                            {{ $state->name }}
                                        </option>
                                    @endforeach
                                    @if ($post->state)
                                        <option value="null">--هیچ کدام--</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-6 p-l-15">
                                <label><b>بخش یا صنعت</b></label>
                                <select name="section_id[]" class="form-control" multiple>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" 
                                            @foreach ($post->sections as $item) 
                                            @if ($section->id == $item->id) selected @endif 
                                            @endforeach

                                            @if (old('section_id'))
                                            @foreach (old('section_id') as $old_id) 
                                            @if ($section->id == $old_id) selected @endif
                                             @endforeach
                                            @endif

                                            >
                                            {{ $section->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    @endif
                    <!-- visibility section end -->
                    <!-- SEO section start -->
                    <div class="add-new-page  bg-white p-20 m-b-20 pt-0">
                        <div class="block-header">
                            <h2>{{ __('seo_details') }}</h2>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="meta_title">
                                    <b>متاتگ عنوان</b>
                                </label>
                                <input class="form-control meta" name="meta_title" value="{{ old('meta_title') ?? $post->meta_title}}" id="meta_title" data-type="title" placeholder="متاتگ عنوان را وارد نمائید">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="post_desc">
                                    <b>متاتگ توضیحات</b>
                                </label>
                                <textarea class="form-control meta" id="meta_description" name="meta_description" data-type="description" rows="3" placeholder="متاتگ توضیحات را وارد نمائید">{{ old('meta_description') ?? $post->meta_description}}</textarea>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" style="margin-bottom: 2px">
                                <label for="post-keywords" class="col-form-label">
                                    <b>{{ __('keywords') }}
                                    </b>
                                </label>
                                <input id="post-keywords" name="meta_keywords" value="{{ old('meta_keywords') ?? $post->meta_keywords}}" type="text" class="form-control" placeholder="کلمات کلیدی را وارد نمائید">
                            </div>
                            <div style="font-size: 13px">کلمات کلیدی را با اینتر از هم جدا نمائید</div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group" style="margin-bottom: 2px">
                                <label for="post_tags" class="col-form-label"><b>{{ __('tags') }}</b></label>
                                <input id="post_tags" type="text" name="tags" value="{{ old('tags') ?? $post->tags}}" data-role="tagsinput" class="form-control" placeholder="برچسب ها را وارد نمائید">
                            </div>
                            <div style="font-size: 13px">برچسب ها را با اینتر از هم جدا نمائید</div>
                        </div>
                    </div>
                    <!-- SEO section end -->
                </div>
                <!-- Main Content section end -->

                <!-- right sidebar start -->

                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_language">{{ __('select_language') }}*</label>
                        <select class="form-control dynamic-category" id="post_language" name="language" data-dependent="category_id">
                            @foreach ($activeLang as $lang)
                                <option @if ($post->language == $lang->code) Selected @endif value="{{ $lang->code }}">
                                    {{ $lang->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="post_status">انتشار</label>
                        <select class="form-control" id="post_status" name="status">
                            <option @if ($post->status == 1 && $post->scheduled == 0) selected @endif value="1">انتشار</option>
                            <option @if ($post->status == 0 && $post->scheduled == 0) selected @endif value="0">{{ __('draft') }}</option>
                            @if (Sentinel::getUser()->hasAccess(['scheduled_post']))
                                <option @if ($post->status == 2 && $post->scheduled == 1) selected @endif value="2">{{ __('scheduled') }}</option>
                            @endif
                        </select>
                    </div>
                    <div class="col-sm-12 divScheduleDate" @if ($post->post_status == 0 && $post->scheduled == 1) @else id="display-nothing" @endif>
                        <label for="scheduled_date">{{ __('schedule_date') }}</label>
                        <div class="input-group">
                            <label class="input-group-text" for="scheduled_date"><i class="fa fa-calendar-alt"></i></label>
                            <input type="text" class="form-control example1" name="scheduled_date" style="direction: rtl" />
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="category-select-box" class="form-group">
                        <label>{{ __('category') }}*</label>
                        <div id="custom-category-drop-down-title">
                            @foreach ($post->category as $item)
                                <span class="badge ml-1" style="background: #ccc" data-category-id="{{ $item->id }}">
                                    <span class="fa fa-times" data-category-id="{{ $item->id }}" title="حذف این گروه"></span>
                                    {{ $item->category_name }}
                                </span>
                            @endforeach
                        </div>
                        <div class="form-control" id="category-select">
                            @foreach ($categories as $category)
                                <div class="option" style="margin-bottom: 2px" data-category-id="{{ $category->id }}">
                                    <input data-category-id="{{ $category->id }}" data-category-name="{{ $category->category_name }}" type="checkbox" @foreach ($post->category as $item) @if ($item->id == $category->id)
                                                checked @endif @endforeach
                                    >
                                    {{ $category->category_name }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" id="sub-category-box">
                        <label>{{ __('sub_category') }}</label>
                        <div id="custom-drop-down-box">
                            @foreach ($post->subCategory as $item)
                                <span class="badge ml-1" style="background: #ccc" data-category-id="{{ $item->category_id }}" data-sub-category-id="{{ $item->id }}">
                                    <span class="fa fa-times" data-sub-category-id="{{ $item->id }}" title="حذف این زیر گروه"></span>
                                    {{ $item->sub_category_name }}
                                </span>
                            @endforeach
                        </div>
                        <div id="custom-drop-down" style="display: block">
                            @foreach ($post->category as $category)
                                <div class="category-box" data-category-id="{{ $category->id }}">
                                    <div class="category">{{ $category->category_name }}</div>
                                    @foreach ($category->subCategory as $sub_category)
                                        <div class="option">
                                            <input type="checkbox" data-category-id="{{ $category->id }}" data-sub-category-id="{{ $sub_category->id }}" data-sub-category-name="{{ $sub_category->sub_category_name }}" @foreach ($post->subCategory as $item) @if ($item->id == $sub_category->id)
                                                    checked @endif @endforeach
                                            >
                                            {{ $sub_category->sub_category_name }}
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-sm-3 offset-9">
                    <div class="form-group text-center">
                        <!-- Large modal -->
                        <button type="button" id="btn_image_modal" class="btn btn-primary btn-image-modal" data-id="1" data-toggle="modal" data-target=".image-modal-lg">تغییر عکس</button>
                        <input id="image_id" value="{{ $post->image_id }}" name="image_id" type="hidden" class="form-control image_id">
                    </div>
                    <div class="form-group text-center">
                        @if (isFileExist($post->image, $result = @$post->image->thumbnail))
                            <img src=" {{ basePath($post->image) }}/{{ $result }} " id="image_preview" width="200" height="200" class="img-responsive img-thumbnail image_preview" alt="{!! $post->title !!}">
                        @else
                            <img src="{{ static_asset('default-image/default-100x100.png') }} " id="image_preview" width="200" height="200" class="img-responsive img-thumbnail image_preview" alt="{!! $post->title !!}">
                        @endif
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="custom-control" for="btnSubmit"></label>
                        <button type="submit" name="btnSubmit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-content-save-all"></i>{{ __('save') }}
                        </button>
                        <label class="" for="btnSubmit"></label>
                    </div>
                </div>
                <!-- right sidebar end -->
            </div>

            {!! Form::close() !!}
            <!-- page info end-->
        </div>
    </div>

    <input type="hidden" value="{{ $content_count }}" id="content_number">
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


            $('#category_id').change(function() {
                $('#sub_category_id').val('');
            });


        });
    </script>
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
            //element.remove(1000);
            element.hide("slow", function() {
                $(this).remove();
            })
        });
    </script>

    <script type="text/javascript" src="{{ static_asset('js/post.js') }}"></script>
    <script src="{{ static_asset('js/tagsinput.js') }}"></script>

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
    </script>


    <script>
        $("#custom-category-drop-down-title").click(function(e) {
            $("#category-select").toggle();
        });

        $("#custom-drop-down-box").click(function(e) {
            $("#custom-drop-down").toggle();
        });

        $("body").on('click',
            function(e) {
                if ($(e.target).parents("#category-select-box").length === 0) {
                    $("#category-select").hide();
                }
            }
        );

        $("body").on('click', '#custom-drop-down-box',
            function(e) {
                if ($("#custom-drop-down-box .badge").length < 1) {
                    $("#custom-drop-down").toggle();
                }
            }
        );

        // changed category check box event
        $("#category-select-box input").click(function(e) {
            var category_id = $(this).data('category-id');
            var category_name = $(this).data('category-name');
            if ($(this).is(':checked')) {
                // category_ids.push(category_id);
                $(this).parent(".option").css("background", "#ccc");
                var content = `<span class="badge ml-1" style="background: #ccc" data-category-id="${category_id}">
                                    <span class="fa fa-times" data-category-id="${category_id}" title="حذف این گروه"></span>
                                    ${category_name}
                                </span>`;
                console.log($("#custom-category-drop-down-title .badge").length);
                if ($("#custom-category-drop-down-title .badge").length) {
                    $("#custom-category-drop-down-title").append(content);
                } else {
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
                        // $(this).prop('checked', false);
                        $(this).parents(".option").css("background", "white");
                    }
                    var count = $("#custom-category-drop-down-title span.badge").length;
                    if (count == 0) {
                        $("#custom-category-drop-down-title").html("--انتخاب نمائید--");
                        first_step = 0;
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


        $("#edit-post-form").submit(function(e) {
            category_ids = [];
            sub_category_ids = [];
            $("#category-select input").each(function() {
                if ($(this).is(":checked")) {
                    category_id = $(this).data('category-id');
                    category_ids.push(category_id);
                }
            });
            $("#custom-drop-down input").each(function() {
                if ($(this).is(":checked")) {
                    sub_category_id = $(this).data('sub-category-id');
                    sub_category_ids.push(sub_category_id);
                }
            });
            $("input[name='category_ids']").val(category_ids);
            $("input[name='sub_category_ids']").val(sub_category_ids);
            return true;
        });


        //press x button for delete sub_category
        $(document).on('click', '#custom-drop-down-box .fa-times', function() {
            var sub_category_id = $(this).parent(".badge").data('sub-category-id');
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

            }

        });




        //////////////////////////////////////////////////////////////////////////////////////////////////
    </script>
@endsection
