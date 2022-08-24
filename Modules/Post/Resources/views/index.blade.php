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
@section('post-active')
    active
@endsection

@section('content')
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            <div class="admin-section">
                <div class="row clearfix m-t-30">
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
                    <div class="col-12 p-0">
                        <div class="navigation-list bg-white">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-2">
                                        <div class="block-header">
                                            <h2>{{ __('posts') }}</h2>
                                        </div>
                                    </div>
                                    @if (Sentinel::getUser()->hasAccess(['post_write']))
                                        <div class="col-10 text-left">
                                            <form id="form-delete-all-post" action="{{ url('post/delete-all-post') }}" method="post" style="display: inline">
                                                @csrf
                                                <input type="hidden" name="ids">
                                                <button type="submit" class="btn btn-danger btn-sm post-delete" style="display: none">
                                                    <i class="fa fa-trash"></i>
                                                    حذف
                                                </button>
                                            </form>
                                            <a href="{{ route('create-article') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                ایجاد خبر متنی
                                            </a>
                                            <a href="{{ route('create-video-post') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                {{ __('create_video_post') }}
                                            </a>
                                            <a href="{{ route('create-audio-post') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                {{ __('create_audio_post') }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @if ($posts->count())
                                <div>
                                    <div class="all-pages">
                                        <!-- Table Filter -->
                                        <div class="row table-filter-container m-b-20">
                                            <div class="col-sm-12">
                                                {!! Form::open(['route' => 'filter-post', 'method' => 'GET']) !!}
                                                {{-- <div class="item-table-filter">
                                                    <p class="text-muted"><small>{{ __('language') }}</small></p>
                                                    <select class="form-control" name="language">
                                                        <option value="">{{ __('all') }}</option>
                                                        @foreach ($activeLang as $lang)
                                                            <option value="{{ $lang->code }}">{{ $lang->name }} </option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                <div class="item-table-filter">
                                                    <p class="text-muted"><small>{{ __('post_type') }}</small></p>
                                                    <select name="post_type" class="form-control">
                                                        <option value="">{{ __('all') }}</option>
                                                        <option value="article">{{ __('article') }}</option>
                                                        <option value="video">{{ __('video') }}</option>
                                                        <option value="audio">{{ __('audio') }}</option>
                                                        <option value="rss">{{ __('RSS') }}</option>
                                                    </select>
                                                </div>

                                                {{-- <div class="item-table-filter">
                                                    <p class="text-muted"><small>{{ __('category') }}</small></p>
                                                    <select class="form-control dynamic" id="category_id" name="category_id" data-dependent="sub_category_id">
                                                        <option value="">{{ __('all') }}</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div> --}}

                                                {{-- <div class="item-table-filter">
                                                    <div class="form-group">
                                                        <p class="text-muted"><small>{{ __('sub_category') }}</small></p>
                                                        <select class="form-control dynamic" id="sub_category_id" name="sub_category_id">
                                                            <option value="">{{ __('all') }}</option>
                                                        </select>
                                                    </div>
                                                </div> --}}

                                                <div class="item-table-filter">
                                                    <p class="text-muted"><small>{{ __('search') }}</small></p>
                                                    <input name="search_key" class="form-control" placeholder="{{ __('search') }}" type="search" value="">
                                                </div>

                                                <div class="item-table-filter md-top-10 item-table-style">
                                                    <p class="mb-1">&nbsp;</p>
                                                    <button type="submit" class="btn bg-primary">{{ __('filter') }}</button>
                                                </div>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                        <!-- Table Filter -->
                                        <table class="table table-bordered table-striped" role="grid">
                                            <thead>
                                                <tr role="row">
                                                    <th>
                                                        <input type="checkbox" style="margin-right: 5px" id="input-post">
                                                        <span style="margin-right: 8px">#</span>
                                                    </th>
                                                    <th>{{ __('post') }}</th>
                                                    <th>{{ __('post_type') }}</th>
                                                    <th>{{ __('category') }}</th>
                                                    @if (Sentinel::getUser()->hasAccess(['access_all_user_posts']))
                                                        <th>{{ __('post_by') }}</th>
                                                    @endif
                                                    <th style="width: 10%">{{ __('visibility') }}</th>
                                                    @if (Sentinel::getUser()->hasAccess(['page_views']))
                                                        <th>{{ __('view') }}</th>
                                                    @endif
                                                    <th>{{ __('added_date') }}</th>
                                                    @if (Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                                                        <th>{{ __('options') }}</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($posts as $post)
                                                    <tr id="row_{{ $post->id }}">
                                                        <td>
                                                            <input type="checkbox" value="{{ $post->id }}" style="margin-right: 5px" class="input-post">
                                                            {{ $post->id }}
                                                        </td>
                                                        <td>
                                                            <div class="post-image">

                                                                @if (isFileExist(@$post->image, $result = @$post->image['thumbnail']))
                                                                    <img src=" {{ basePath($post->image) }}/{{ $result }} " data-src="{{ basePath($post->image) }}/{{ $result }}" alt="image" class="img-responsive img-thumbnail lazyloaded">
                                                                @else
                                                                    <img src="{{ static_asset('default-image/default-100x100.png') }} " width="200" height="200" alt="image" class="img-responsive img-thumbnail">
                                                                @endif
                                                            </div>
                                                            <a href="{{ route('article.detail', [$post->slug]) }}">{{ $post->title }} </a>
                                                        </td>
                                                        <td class="td-post-type">{{ __($post->post_type) }}</td>
                                                        <td>
                                                            @foreach ($post->category as $item)
                                                                <label class="category-label m-r-5 label-table" id="breaking-post-bgc">
                                                                    {{ $item->category_name }}
                                                                </label>
                                                            @endforeach
                                                        </td>
                                                        @if (Sentinel::getUser()->hasAccess(['access_all_user_posts']))
                                                            <td>
                                                                <a href="#" target="_blank" class="table-user-link">
                                                                    <strong>
                                                                        @php
                                                                            $roles = Sentinel::findById($post->user_id)->roles->first();
                                                                        @endphp
                                                                        {{ $post->user->first_name }} {{ $post->user->last_name }} ({{ __($roles->name) }})
                                                                    </strong>
                                                                </a>
                                                                @if (Sentinel::getUser()->hasAccess(['change_author']))
                                                                    <a href="#" style="display: inherit" data-toggle="modal" data-target="#change_author">
                                                                        <label data-post-id="{{ $post->id }}" class="label bg-warning label-table" style="cursor: pointer" title="تغییر نویسنده این خبر">تغییر نویسنده</label>
                                                                    </a>
                                                                @endif
                                                            </td>
                                                        @endif

                                                        <td class="td-post-sp">
                                                            @if ($post->visibility == 1)
                                                                <label class="label label-success label-table"><i class="fa fa-eye"></i></label>
                                                            @else
                                                                <label class="label label-default label-table"><i class="fa fa-eye-slash"></i></label>
                                                            @endif
                                                            @if ($post->status == 1)
                                                                <label class="label label-success label-table">منتشر شده</label>
                                                            @else
                                                                <label class="label label-warning label-table">در انتظار انتشار</label>
                                                            @endif
                                                            @if ($post->breaking == 1)
                                                                <label class="label bg-red label-table">{{ __('breaking') }}</label>
                                                            @endif
                                                            @if ($post->chat_room == 1)
                                                                <label class="label bg-red label-table">اتاق گفتگو</label>
                                                            @endif
                                                            @if ($post->featured == 1)
                                                                <label class="label bg-warning label-table">{{ __('featured') }}</label>
                                                            @endif
                                                            @if ($post->opinion == 1)
                                                                <label class="label bg-teal label-table">دیدگاه</label>
                                                            @endif
                                                            @if ($post->populare == 1)
                                                                <label class="label bg-aqua label-table">پر بازدید</label>
                                                            @endif
                                                            @if ($post->person_of_day == 1)
                                                                <label class="label bg-success label-table">ویژه نگار</label>
                                                            @endif
                                                            @if ($post->slider == 1)
                                                                <label class="label bg-teal label-table">{{ __('slider') }}</label>
                                                            @endif
                                                            @if ($post->featured_main_page == 1)
                                                                <label class="label bg-warning label-table">گالری فیلم و صوت</label>
                                                            @endif
                                                        </td>
                                                        @if (Sentinel::getUser()->hasAccess(['page_views']))
                                                            <td>{{ $post->total_hit }}</td>
                                                        @endif
                                                        <td>{{ miladi_to_jalali($post->created_at, true) }}</td>
                                                        @if (Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...<span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu options-dropdown" style="left:40px !important;z-index: 9999">
                                                                        @if (Sentinel::getUser()->hasAccess(['post_write']))
                                                                            <li>
                                                                                <a href="{{ route('edit-post', ['type' => $post->post_type, 'id' => $post->id]) }}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                                </a>
                                                                            </li>
                                                                            @if (Sentinel::getUser()->hasAccess(['post_options']))
                                                                                <div>
                                                                                    <li>
                                                                                        @if ($post->visibility == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','visibility','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fas fa-eye-slash option-icon"></i>{{ __('invisible') }}
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('visibility','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-eye option-icon"></i> {{ __('visible') }}
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->status == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','status','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fas fa-times option-icon"></i></i>عدم انتشار
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('status','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-check option-icon"></i>انتشار
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->slider == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','slider','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>{{ __('slider') }}
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('slider','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>{{ __('slider') }}
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->featured == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','featured','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>{{ __('featured') }}
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('featured','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>{{ __('featured') }}
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->breaking == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','breaking','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>{{ __('breaking') }}
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('breaking','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>{{ __('breaking') }}
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->populare == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','populare','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>پر بازدید
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('populare','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>پر بازدید
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->opinion == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','opinion','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>دیدگاه
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('opinion','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>دیدگاه
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->person_of_day == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','person_of_day','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>ویژه نگار
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('person_of_day','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>ویژه نگار
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                    <li>
                                                                                        @if ($post->chat_room == 1)
                                                                                            <a href="javascript:void(0)" onclick="remove_post_form('index','chat_room','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-minus option-icon"></i>اتاق گفتگو
                                                                                            </a>
                                                                                        @else
                                                                                            <a href="javascript:void(0)" onclick="add_post_to('chat_room','{{ $post->id }}')" name="option" class="btn-list-button">
                                                                                                <i class="fa fa-plus option-icon"></i>اتاق گفتگو
                                                                                            </a>
                                                                                        @endif
                                                                                    </li>
                                                                                </div>
                                                                            @endif
                                                                        @endif
                                                                        @if (Sentinel::getUser()->hasAccess(['post_delete']))
                                                                            <li>
                                                                                <a href="javascript:void(0)" onclick="delete_item('posts','{{ $post->id }}')"><i class="fa fa-trash option-icon"></i>{{ __('delete') }}
                                                                                </a>
                                                                            </li>
                                                                        @endif
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                            <div class="block-header">
                                                <h2>{{ __('showing') }} {{ $posts->firstItem() }} {{ __('to') }} {{ $posts->lastItem() }} {{ __('of') }} {{ $posts->total() }} {{ __('entries') }}</h2>
                                            </div>
                                        </div>
                                        <div class="col-12 col-sm-6 text-left">
                                            <div class="table-info-pagination float-left">
                                                {!! $posts->render() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="alert alert-primary" role="alert">
                                    خبری جهت نمایش وجود ندارد
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>


@endsection

@section('modal')
    @include('common::modal.change_author')
@endsection

@section('script')
    <script>
        $(document).ready(function() {

            $('.dynamic').change(function() {
                if ($(this).val() != '') {
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
                            $('#' + dependent).html(result);
                        }

                    })
                }
            });

            $('#category').change(function() {
                $('#sub_category').val('');
            });


            // added by majid molaea for delete all posts
            $("#input-post").change(function(e) {
                e.preventDefault();
                if ($(this).is(':checked')) {
                    $(".input-post").prop('checked', true);
                    $(".post-delete").show();
                } else {
                    $(".input-post").prop('checked', false);
                    $(".post-delete").hide();
                }
            });

            $(".input-post").change(function(e) {
                e.preventDefault();
                if ($(this).is(':checked')) {
                    $(".post-delete").show();
                } else if ($(".input-post:checked").length == 0) {
                    $(".post-delete").hide();
                }
            });

            $(".post-delete").click(function(e) {
                e.preventDefault();
                var form = $("#form-delete-all-post");
                var ids = [];
                $(".input-post").each(function() {
                    if ($(this).is(':checked')) {
                        var val = $(this).val();
                        ids.push(val);
                    }
                });
                $("input[name='ids']").val(ids);
                form.submit();
            });
        });


        $("label[data-post-id]").click(function() {
            var post_id = $(this).data("post-id");
            $("input[name='post_id']").val(post_id);
        });
    </script>
@endsection
