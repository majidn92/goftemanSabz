@extends('common::layouts.master')
@section('ads-aria-expanded')
    aria-expanded="true"
@endsection
@section('ads-show')
    show
@endsection
@section('ads')
    active
@endsection
@section('ads_active')
    active
@endsection
@section('ads_center')
    active
@endsection
@section('modal')
    @include('gallery::image-gallery')
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
            {!! Form::open(['route' => ['center.update-ad', $ad->id], 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            <div class="row clearfix">

                <div class="col-12">
                    <div class="add-new-page  bg-white px-4 py-0">
                        <div class="add-new-header clearfix">
                            <div class="row">
                                <div class="col-6">
                                    <div class="block-header">
                                        <h2>{{ __('edit_ad') }}</h2>
                                    </div>
                                </div>
                                <div class="col-6 text-left">
                                    <a href="{{ route('center') }}" class="btn btn-primary btn-add-new btn-sm"><i class="fas fa-arrow-left"></i>
                                        {{ __('back_to_ads') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

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
                    <div class="row add-new-page  bg-white p-20 pb-0">
                        <div class="col-sm-2">
                            <div class="form-group text-center">
                                <label for="rank" class="col-form-label">تبلیغ بالای بخش</label>
                                <input name="top" type="checkbox" class="form-control" @if ($ad->top == 1) checked @endif>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="url" class="col-form-label">لینک*</label>
                                <input id="url" value="{{ $ad->url }}" name="url" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-3 pt-2">
                            <label>بخش یا صنعت</label>
                            <select class="form-control" name="section_id">
                                @foreach ($sections as $section)
                                    <option @if ($section->id == $ad->section->id) selected @endif value="{{ $section->id }}">{{ $section->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-3" @if ($ad->top) style="display:none" @endif>
                            <div class="form-group">
                                <label for="rank" class="col-form-label">جایگاه*</label>
                                <input id="rank" value="{{ $ad->rank }}" name="rank" required type="text" class="form-control">
                            </div>
                        </div>
                        <div id="div_ad_image">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="btn btn-primary">
                                        {{ __('update_ad_image') }}*
                                        <input value="{{ $ad->ad_image_id }}" name="image" type="file" class="form-control" style="display: none">
                                    </label>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group text-center">
                                    @if ($ad->top)
                                    <img src="{{ url($ad->path) }}" id="image_preview" width="1200" height="150" alt="image" class="img-responsive img-thumbnail">
                                    <div id="hint-msg">از تصاویر باابعاد 150 * 1200 استفاده نمائید</div>
                                    @else
                                    <img src="{{ url($ad->path) }}" id="image_preview" width="200" height="200" alt="image" class="img-responsive img-thumbnail">
                                        <div id="hint-msg">از تصاویر باابعاد 100 * 200 استفاده نمائید</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group form-float form-group-sm">
                                <button type="submit" class="btn btn-primary float-right m-t-20">{{ __('save') }}</button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            {{ Form::close() }}
            <!-- page info end-->
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("input[name='top']").change(function() {
            if ($(this).is(':checked')) {
                $("#rank").parents(".col-sm-3").hide();
                $("#image_preview").css({
                    'width': '1200',
                    'height': '150'
                });
                $("#hint-msg").html("از تصاویر باابعاد 150 * 1200 استفاده نمائید");
            } else {
                $("#rank").parents(".col-sm-3").show();
                $("#image_preview").css({
                    'width': '200',
                    'height': '200'
                });
                $("#hint-msg").html("از تصاویر باابعاد 100 * 200 استفاده نمائید");
            }
        });
    </script>
@endsection
