@extends('common::layouts.master')

@section('section-aria-expanded')
    aria-expanded="true"
@endsection

@section('section-show')
    show
@endsection

@section('section')
    active
@endsection

@section('section-index')
    active
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
            <div class="row" style="justify-content: flex-end">
                <a href="{{ url('setting/sections') }}" class="btn btn-primary float-left m-2"><i class="fa fa-bars"></i>
                    بخش ها
                </a>
            </div>
            <form action="{{ url('setting/section-update') }}" method="post">
                @csrf
                <input type="hidden" name="section_id" value="{{ $section->id }}">
                <input type="hidden" name="style" value="{{ $section->style }}">
                <div class="row mb-2" style="box-shadow: 0px 0px 2px">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">نام</label>
                            <input name="name" value="{{ $section->name }}" value="{{ old('name') }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">جایگاه نمایش</label>
                            <input name="rank" value="{{ $section->rank }}" value="{{ old('rank') }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">رنگ</label>
                            <input name="color" value="{{ $section->color }}" value="{{ old('color') }}" type="color" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2" style="display: flex;align-items: center">
                        <label class="custom-control custom-checkbox pt-1">
                            <input type="checkbox" name="show" value="{{ $section->show }}" value="{{ old('show') }}" class="custom-control-input" @if ($section->show == 1) checked @endif>
                            <span class="custom-control-label"></span>
                            <label for="show">نمایش بخش</label>
                        </label>
                    </div>

                    @if (!(($section->style == 'photo') || ($section->style == 'video')))
                        <div class="col-sm-2" style="display: flex;align-items: center">
                            <label class="custom-control custom-checkbox pt-1">
                                <input type="checkbox" name="ads" value="{{ $section->ads }}" value="{{ old('ads') }}" class="custom-control-input" @if ($section->ads == 1) checked @endif>
                                <span class="custom-control-label"></span>
                                <label for="ads">نمایش تبلیغات</label>
                            </label>
                        </div>
                    @endif
                </div>
                @if (!(($section->style == 'photo') || ($section->style == 'video') || ($section->style == 'state')))
                    <div class="row mb-2" style="box-shadow: 0px 0px 2px">
                        <div class="col-sm-12 mb-2">
                            <label class="custom-control custom-checkbox pt-1"> ظاهر
                                <div class="row">
                                    <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                        <input type="radio" id="style1" name="style" value="style1" class="custom-control-input" @if ($section->style == 'style1') checked @endif>
                                        <span class="custom-control-label"></span>
                                        <label>حالت 1</label>
                                        <div style="margin-right: -25px">
                                            <img src="{{ static_asset('default-image/Section/Section_1.png') }}" style="width: 60%">
                                        </div>
                                    </label>
                                    <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                        <input type="radio" id="style2" name="style" value="style2" class="custom-control-input" @if ($section->style == 'style2') checked @endif>
                                        <span class="custom-control-label"></span>
                                        <label>حالت 2</label>
                                        <div style="margin-right: -25px">
                                            <img src="{{ static_asset('default-image/Section/Section_3.png') }}" style="width: 60%">
                                        </div>
                                    </label>
                                    <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                        <input type="radio" id="style3" name="style" value="style3" class="custom-control-input" @if ($section->style == 'style3') checked @endif>
                                        <span class="custom-control-label"></span>
                                        <label>حالت 3</label>
                                        <div style="margin-right: -25px">
                                            <img src="{{ static_asset('default-image/Section/Section_5.png') }}" style="width: 60%">
                                        </div>
                                    </label>
                                </div>
                            </label>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-sm-6 p-l-15 pr-0">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#show").change(function(e) {
            e.preventDefault();
            if ($(this).is(':checked')) {
                $(".option").show();
            } else {
                $(".option").hide();
                $(".option input").prop('checked', false);
            }
        });
    </script>
@endsection
