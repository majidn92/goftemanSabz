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
            <div class="admin-section">
                <div class="row clearfix m-t-30">
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
                        </div>
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="block-header">
                                            <h2>ویدئوها</h2>
                                        </div>
                                    </div>
                                    @if (Sentinel::getUser()->hasAccess(['album_write']))
                                        <div class="col-6 text-left">
                                            <a href="{{ route('video.create.video') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                افزودن ویدئو
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive all-pages">
                                <!-- Table Filter -->
                                <div class="row table-filter-container m-b-20">
                                    <div class="col-sm-12">
                                        {!! Form::open(['route' => 'filter-image', 'method' => 'GET']) !!}
                                        <div class="item-table-filter">
                                            <p class="text-muted"><small>{{ __('language') }}</small></p>
                                            <select class="form-control dynamic-album" id="language" name="language" data-dependent="album_id">
                                                @foreach ($activeLang as $lang)
                                                    <option @if (App::getLocale() == $lang->code) Selected @endif value="{{ $lang->code }}">{{ $lang->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="item-table-filter">
                                            <p class="text-muted"><small>{{ __('album') }}</small></p>
                                            <select class="form-control dynamic-album-tab text-capitalize" id="album_id" name="album_id" data-dependent="album_tab">
                                                <option value="">{{ __('all') }}</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

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
                                            <th>#</th>
                                            <th>کاور</th>
                                            <th>عنوان</th>
                                            <th>گروه</th>
                                            <th>بخش یا صنعت</th>
                                            <th>{{ __('added_date') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                <th>{{ __('options') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($videos as $key => $video)
                                            <tr id="row_{{ $video->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <img src=" {{ static_asset($video->cover) }} " alt="image" class="img-responsive img-thumbnail lazyloaded" width="100" height="70">
                                                </td>
                                                <td> {{ $video->title }} </td>
                                                <td> {{ $video->video_category->name }} </td>
                                                <td> {{ $video->section->name }} </td>
                                                <td>{{ miladi_to_jalali($video->created_at, true) }}</td>
                                                @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">

                                                                @if (Sentinel::getUser()->hasAccess(['album_write']))
                                                                    <li>
                                                                        <a href="{{ route('video.edit.video', ['id' => $video->id]) }}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (Sentinel::getUser()->hasAccess(['album_delete']))
                                                                    <li>
                                                                        <a id="delete-video" data-video-id="{{ $video->id }}" href="javascript:void(0)"><i class="fa fa-trash option-icon"></i>{{ __('delete') }}
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
                                        <h2>{{ __('showing') }} {{ $videos->firstItem() }} {{ __('to') }} {{ $videos->lastItem() }} {{ __('of') }} {{ $videos->total() }} {{ __('entries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $videos->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>

@section('script')
    <script>
        $("#delete-video").click(function(e) {
            e.preventDefault();
            video_id = $(this).data("video-id");
            swal({
                    title: "{{ __('are_you_sure?') }}",
                    icon: "warning",
                    buttons: true,
                    buttons: ["{{ __('cancel') }}", "{{ __('delete') }}"],
                    dangerMode: true,
                    closeOnClickOutside: false
                })
                .then(function(confirmed) {
                    if (confirmed) {
                        url = "{{ route('video.delete.video') }}";
                        data = {
                            video_id: video_id
                        };
                        $.ajax({
                                url: url,
                                type: 'post',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: data,
                                dataType: 'JSON',
                            })
                            .done(function(response) {
                                swal.stopLoading();
                                if (response.status == "success") {
                                    swal("{{ __('deleted') }}!", response.message, response.status);
                                    location.reload();
                                } else {
                                    swal("خطا", response.message, response.status);
                                }
                            })
                            .fail(function() {
                                swal('خطا', '{{ __('something_went_wrong_with_ajax') }}', 'error');
                            })
                    }
                })

        });
    </script>
@endsection
@endsection
