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
            <form action="{{ url('setting/section-store') }}" method="post">
                @csrf
                <div class="row mb-2" style="box-shadow: 0px 0px 2px">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">نام</label>
                            <input name="name" value="{{ old('name') }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">جایگاه نمایش</label>
                            <input name="rank" value="{{ old('rank') }}" type="text" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-1">
                        <div class="form-group">
                            <label for="post_on_title" class="col-form-label">رنگ</label>
                            <input name="color" value="{{ old('color') }}" type="color" class="form-control">
                        </div>
                    </div>
                    <div class="col-sm-2" style="display: flex;align-items: center">
                        <label class="custom-control custom-checkbox pt-1">
                            <input type="checkbox" name="show" class="custom-control-input">
                            <span class="custom-control-label"></span>
                            <label for="show">نمایش بخش</label>
                        </label>
                    </div>
                    <div class="col-sm-2"  style="display: flex;align-items: center">
                        <label class="custom-control custom-checkbox pt-1">
                            <input type="checkbox" name="ads" class="custom-control-input">
                            <span class="custom-control-label"></span>
                            <label for="ads">نمایش تبلیغات</label>
                        </label>
                    </div>
                </div>
                <div class="row mb-2" style="box-shadow: 0px 0px 2px">
                    <div class="col-sm-12">
                        <label class="custom-control custom-checkbox pt-1"> ظاهر
                            <div class="row">
                                <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                    <input type="radio" id="style1" name="style" value="style1" class="custom-control-input">
                                    <span class="custom-control-label"></span>
                                    <label>حالت 1</label>
                                    <div style="margin-right: -25px">
                                        <img src="{{ static_asset('default-image/Section/Section_1.png') }}" style="width: 60%">
                                    </div>
                                </label>
                                <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                    <input type="radio" id="style2" name="style" value="style2" class="custom-control-input">
                                    <span class="custom-control-label"></span>
                                    <label>حالت 2</label>
                                    <div style="margin-right: -25px">
                                        <img src="{{ static_asset('default-image/Section/Section_2.png') }}" style="width: 60%">
                                    </div>
                                </label>
                                <label class="custom-control custom-checkbox pt-1 col-sm-3">
                                    <input type="radio" id="style3" name="style" value="style3" class="custom-control-input">
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
                <div class="row">
                    <div class="col-sm-6 p-l-15  pr-0">
                        <button type="submit" class="btn btn-primary">ذخیره</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

