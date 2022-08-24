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
@section('ads_side')
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
            <!-- page info start-->
            {!! Form::open(['route' => 'side.store-ad', 'method' => 'post', 'enctype' => 'multipart/form-data']) !!}
            <input type="hidden" id="imageCount" value="1">
            <div class="row clearfix">
                <div class="col-12">
                    <div class="add-new-page  bg-white">
                        <div class="add-new-header clearfix">
                            <div class="row">
                                <div class="col-6">
                                    <div class="block-header">
                                        <h2>{{ __('create_ad') }}</h2>
                                    </div>
                                </div>
                                <div class="col-6 text-left">
                                    <a href="{{ route('side') }}" class="btn btn-primary btn-add-new btn-sm"><i class="fas fa-arrow-left"></i>
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
                    <div class="row add-new-page  bg-white p-20 m-b-20">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <h4 class="border-bottom">{{ __('ads_details') }}</h4>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="url" class="col-form-label">لینک تبلیغ*</label>
                                <input name="url" value="{{ old('url') }}" type="text" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label for="rank" class="col-form-label">جایگاه نمایش*</label>
                                <input id="rank" name="rank" required value="{{ old('rank') }}" type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-3" style="display: flex;align-items: flex-end;justify-content: end">
                            <div class="form-group">
                                <input name="set_date" value="1" type="checkbox" class="form-control" style="display: inline;width:unset">
                                <label class="col-form-label">
                                    تعیین زمان نمایش
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 date-range">
                            <div class="form-group">
                                <label for="start_date" class="col-form-label">زمان شروع نمایش</label>
                                <input id="start_date" value="" name="start_date" required type="text" class="form-control start_date" disabled>
                            </div>
                        </div>
                        <div class="col-sm-2 date-range">
                            <div class="form-group">
                                <label for="end_date" class="col-form-label">زمان پایان نمایش</label>
                                <input id="end_date" value="" name="end_date" required type="text" class="form-control end_date" disabled>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <label for="upload"  class="btn btn-primary">عکس تبلیغ</label>
                                    <input id="upload" name="image" type="file" style="display: none">
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="form-group text-center">
                                    <img src="{{ static_asset('default-image/default-100x100.png') }} " id="image_preview" width="200" height="200" alt="image" class="img-responsive img-thumbnail">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
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
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-date.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-datepicker.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(".start_date").pDatepicker({
                'timePicker': {
                    'enabled': true,
                },
                format: ' H:m:s YYYY/MM/DD ',

            });

            $(".end_date").pDatepicker({
                'timePicker': {
                    'enabled': true,
                },
                format: ' H:m:s YYYY/MM/DD ',

            });
        });
    </script>
    <script>
        $("input[name='set_date']").click(function(e) {
            if ($(this).is(':checked')) {
                $("#start_date").prop('disabled', false);
                $("#end_date").prop('disabled', false);
                $(".date-range").css('opacity', '1');
            } else {
                $("#start_date").prop('disabled', true);
                $("#end_date").prop('disabled', true);
                $(".date-range").css('opacity', '0.5');
            }
        });

        $(".date-range").css('opacity', '0.5');

        $("#upload").change(function(e) {
            e.preventDefault();
            image_preview.src = URL.createObjectURL(this.files[0]);
        });
    </script>
@endsection
