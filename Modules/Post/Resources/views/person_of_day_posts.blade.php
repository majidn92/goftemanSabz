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
@section('person-of-day-post-active')
    active
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <form id="delete-post-from" action="{{ url('post/delete-post-from') }}" method="post" style="display: inline">
            @csrf
            <input type="hidden" name="ids">
            <input type="hidden" name="column" value="person_of_day">
        </form>

        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            {!! Form::open(['route' => 'update-person-of-day-order', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            <div class="admin-section">
                <div class="row clearfix m-t-30">
                    <div class="col-12">
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="block-header">
                                            <h2>ویژه نگار</h2>
                                        </div>
                                    </div>
                                    @if (Sentinel::getUser()->hasAccess(['post_write']))
                                        <div class="col-6 text-left">
                                            <button type="submit" form="delete-post-from" class="btn btn-danger btn-sm post-delete" style="display: none">
                                                <i class="fa fa-trash"></i>
                                                حذف از ویژه نگار
                                            </button>
                                        </div>
                                    @endif
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
                            </div>
                            <div class="table-responsive all-pages">
                                <!-- Table Filter -->
                                <table class="table table-bordered table-striped" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>
                                                <input type="checkbox" style="margin-right: 5px" id="input-post">
                                                <span style="margin-right: 8px">#</span>
                                            </th>
                                            <th>{{ __('post') }}</th>
                                            <th>{{ __('language') }}</th>
                                            <th>{{ __('post_type') }}</th>
                                            <th>{{ __('category') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['access_all_user_posts']))
                                                        <th>{{ __('post_by') }}</th>
                                                    @endif
                                            <th>{{ __('visibility') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['set_order_post']))
                                                <th>{{ __('order') }}</th>
                                            @endif
                                            @if (Sentinel::getUser()->hasAccess(['page_views']))
                                                        <th>{{ __('view') }}</th>
                                                    @endif
                                            <th>{{ __('added_date') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['post_write']) && Sentinel::getUser()->hasAccess(['post_options']))
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
                                                        @if (isFileExist(@$post->image, $result = @$post->image->thumbnail))
                                                            <img src=" {{ basePath($post->image) }}/{{ $result }} " data-src="{{ basePath($post->image) }}/{{ $result }}" alt="image" class="img-responsive img-thumbnail lazyloaded">
                                                        @else
                                                            <img src="{{ static_asset('default-image/default-100x100.png') }} " width="200" height="200" alt="image" class="img-responsive img-thumbnail">
                                                        @endif
                                                    </div> <a href="{{ route('article.detail', [$post->slug]) }}">{{ $post->title }} </a>
                                                </td>
                                                <td>{{ __($post->language) }} </td>
                                                <td class="td-post-type">{{ __($post->post_type) }}</td>
                                                <td>
                                                    @foreach (@$post->category as $item)
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
                                                @if (Sentinel::getUser()->hasAccess(['set_order_post']))
                                                <td width="10%">
                                                    <input type="number" class="form-control btn btn-light" name="order[]" value="{{ $post->person_of_day_order }}">
                                                    <input type="hidden" class="btn btn-light" name="post_id[]" value="{{ $post->id }}">
                                                </td>
                                                @endif
                                                @if (Sentinel::getUser()->hasAccess(['page_views']))
                                                            <td>{{ $post->total_hit }}</td>
                                                        @endif
                                                <td>{{ miladi_to_jalali($post->created_at, true) }}</td>
                                                @if (Sentinel::getUser()->hasAccess(['post_write']) && Sentinel::getUser()->hasAccess(['post_options']))
                                                    <td>
                                                        <a href="javascript:void(0)" onclick="remove_post_form('other','person_of_day','{{ $post->id }}')" name="option" class="btn btn-light active btn-xs">
                                                            <i class="fa fa-minus option-icon"></i>حذف از ویژه نگار</a>
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
                                        @if ($posts->count())
                                            <h2>{{ __('showing') }} {{ $posts->firstItem() }} {{ __('to') }} {{ $posts->lastItem() }} {{ __('of') }} {{ $posts->total() }} {{ __('entries') }}</h2>
                                        @else
                                            <h2>نتیجه ای یافت نشد</h2>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $posts->render() !!}

                                    </div>
                                </div>
                            </div>
                        </div>
                        @if (Sentinel::getUser()->hasAccess(['post_write']) && Sentinel::getUser()->hasAccess(['post_options']) && $posts->count() > 0)
                            <button type="submit" name="btnSubmit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-content-save-all"></i>به روز رسانی جایگاه نمایش</button>
                        @endif
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
            <!-- page info end-->
        </div>
    </div>
@endsection

@section('modal')
    @include('common::modal.change_author')
@endsection

@section('script')
    <script>
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
            var form = $("#delete-post-from");
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
    </script>
@endsection
