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
                    <div class="col-12">
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-6">
                                        <div class="block-header">
                                            <h2>آلبوم تصاویر</h2>
                                        </div>
                                    </div>
                                    @if (Sentinel::getUser()->hasAccess(['album_write']))
                                        <div class="col-6 text-left">
                                            <a href="{{ route('add-gallery-image') }}" class="btn btn-primary btn-sm btn-add-new"><i class="mdi mdi-plus"></i>
                                                افزودن آلبوم
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive all-pages">
                                <table class="table table-bordered table-striped" role="grid">
                                    <thead>
                                        <tr role="row">
                                            <th>#</th>
                                            <th>آلبوم</th>
                                            <th>{{ __('title') }}</th>
                                            <th>{{ __('added_date') }}</th>
                                            @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                <th>{{ __('options') }}</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($galleryImages as $key => $item)
                                            <tr id="row_{{ $item->id }}">
                                                <td>{{ $key + 1 }}</td>
                                                <td>
                                                    <div class="post-image">
                                                        @if (isFileExist(@$item, $result = @$item->original_image))
                                                            <img src=" {{ static_asset($item->original_image) }}" alt="image" class="img-responsive img-thumbnail lazyloaded">
                                                        @else
                                                            <img src="{{ static_asset('default-image/default-100x100.png') }} " width="200" height="200" alt="image" class="img-responsive img-thumbnail">
                                                        @endif
                                                    </div>
                                                </td>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ miladi_to_jalali($item->created_at, true) }}</td>
                                                @if (Sentinel::getUser()->hasAccess(['album_write']) || Sentinel::getUser()->hasAccess(['album_delete']))
                                                    <td>
                                                        <div class="dropdown">
                                                            <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...<span class="caret"></span>
                                                            </button>
                                                            <ul class="dropdown-menu options-dropdown">

                                                                @if (Sentinel::getUser()->hasAccess(['album_write']))
                                                                    <li>
                                                                        <a href="{{ route('edit-gallery-image', ['id' => $item->id]) }}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                        </a>
                                                                    </li>
                                                                @endif
                                                                @if (Sentinel::getUser()->hasAccess(['album_delete']))
                                                                    <li>
                                                                        <a href="javascript:void(0)" onclick="delete_item_image_gallery({{ $item->id }})"><i class="fa fa-trash option-icon"></i>{{ __('delete') }}
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
                                        <h2>{{ __('showing') }} {{ $galleryImages->firstItem() }} {{ __('to') }} {{ $galleryImages->lastItem() }} {{ __('of') }} {{ $galleryImages->total() }} {{ __('entries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $galleryImages->render() !!}
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
@endsection

@section('script')
    <script>
        function delete_item_image_gallery(id) {
            swal({
                    title: "{{ __('are_you_sure?') }}",
                    icon: "warning",
                    buttons: true,
                    buttons: ["{{ __('no') }}", "{{ __('yes') }}"],
                    dangerMode: true,
                    closeOnClickOutside: false
                })
                .then(function(confirmed) {
                    $.ajax({
                        type: "get",
                        url: "{{ url('gallery/delete-image') }}",
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if (response == 'ok') {
                                location.reload();
                            }
                        }
                    });
                })
        }
    </script>
@endsection
