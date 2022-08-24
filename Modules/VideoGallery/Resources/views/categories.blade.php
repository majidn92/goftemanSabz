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
@section('video-category-active')
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
                        <div class="col-12 col-lg-5">
                            {!! Form::open(['route' => 'video.store.category', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="block-header">
                                    <h2>افزودن گروه</h2>
                                </div>

                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="language">{{ __('select_language') }} *</label>
                                        <select class="form-control" name="language" id="language">
                                            @foreach ($activeLang as $lang)
                                                <option @if (App::getLocale() == $lang->code) Selected @endif value="{{ $lang->code }}">{{ $lang->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">نام گروه
                                            *</label>
                                        <input id="name" name="name" type="text" class="form-control" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 m-t-20">
                                        <div class="form-group form-float form-group-sm text-right">
                                            <button type="submit" name="btnsubmit" class="btn btn-primary pull-right"><i class="m-l-5 mdi mdi-plus"></i>افزودن گروه</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- Main Content section end -->

                        <!-- right sidebar start -->
                        <div class="col-12 col-lg-7">
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="block-header m-b-20">
                                    <h2>گروه ها</h2>
                                </div>
                                <div class="table-responsive all-pages">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr role="row">
                                                <th>#</th>
                                                <th>نام گروه</th>
                                                @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                    <th>{{ __('options') }}</th>
                                                @endif
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($categories as $key => $category)
                                                <tr role="row" class="odd" id="row_{{ $category->id }}">
                                                    <td class="sorting_1">{{ $key + 1 }}</td>
                                                    <td>{{ $category->name }}</td>

                                                    @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                        <td>
                                                            <div class="dropdown">
                                                                <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...
                                                                    <span class="caret"></span>
                                                                </button>
                                                                <ul class="dropdown-menu options-dropdown">
                                                                    @if (Sentinel::getUser()->hasAccess(['album_write']))
                                                                        <li>
                                                                            <a href="{{ route('video.edit.category', ['id' => $category->id]) }}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if (Sentinel::getUser()->hasAccess(['album_delete']))
                                                                        <li>
                                                                            <a id="delete-video-category" data-cat-id="{{ $category->id }}" href="javascript:void(0)"><i class="fa fa-trash option-icon"></i>{{ __('delete') }}</a>
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
                                            <h2>{{ __('showing') }} {{ $categories->firstItem() }} {{ __('to') }} {{ $categories->lastItem() }}
                                                از {{ $categories->total() }} {{ __('entries') }}</h2>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 text-right">
                                        <div class="table-info-pagination float-right">
                                            <nav aria-label="Page navigation example">
                                                {!! $categories->render() !!}
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- right sidebar end -->
                    </div>
                </div>
            </div>
            <!-- page info end-->
        </div>
    </div>

@section('script')
    <script src="{{ static_asset('js/tagsinput.js') }}"></script>
    <script src="{{ static_asset('js/tagsinput.js') }}"></script>
    <script>
        $("#delete-video-category").click(function(e) {
            e.preventDefault();
            cat_id = $(this).data("cat-id");
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
                        url = "{{ route('video.delete.category') }}";
                        data = {
                            cat_id: cat_id
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
