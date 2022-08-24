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
                        <div class="col-12 col-lg-12">
                            {!! Form::open(['route' => 'video.update.category', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
                            <div class="add-new-page  bg-white p-20 m-b-20">
                                <div class="block-header">
                                    <h2>ویرایش گروه</h2>
                                </div>

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="name" class="col-form-label">نام گروه
                                            *</label>
                                        <input id="name" name="name" value="{{ $category->name }}" type="text" class="form-control">
                                        <input name="category_id" value="{{ $category->id }}" type="hidden">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 m-t-20">
                                    <div class="form-group form-float form-group-sm text-right">
                                        <button type="submit" name="btnSubmit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-content-save-all"></i>{{ __('save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {!! Form::close() !!}
                    </div>
                    <!-- Main Content section end -->
                </div>
            </div>
        </div>
        <!-- page info end-->
    </div>
    </div>
@section('script')
    <script src="{{ static_asset('js/tagsinput.js') }}"></script>
@endsection
@endsection
