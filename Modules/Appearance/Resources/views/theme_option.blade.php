@extends('common::layouts.master')

@section('settings')
    aria-expanded="true"
@endsection
@section('s-show')
    show
@endsection
@section('settings_active')
    active
@endsection
@section('theme_option')
    active
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->
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
            <div class="row clearfix">
                <div class="col-sm-3">
                    <div class="add-new-page  bg-white p-0 m-b-20">
                        <nav>
                            <div class="nav m-b-20 setting-tab" id="nav-tab" role="tablist">

                                <a class="nav-item nav-link active" id="themes-options-settings" href="{{ route('themes-options') }}" role="tab">تنظیمات ظاهری</a>
                                <a class="nav-item nav-link" id="general-settings" href="{{ route('setting-general') }}" role="tab">{{ __('general_settings') }}</a>
                                <a class="nav-item nav-link" id="contact-settings" href="{{ route('setting-company') }}" role="tab">{{ __('company_informations') }}</a>
                                <a class="nav-item nav-link" id="mail-settings" href="{{ route('setting-email') }}" role="tab">{{ __('email_settings') }}</a>
                                <a class="nav-item nav-link" id="storage-settings" href="{{ route('setting-storage') }}" role="tab">{{ __('storage_settings') }}</a>
                                <a class="nav-item nav-link" id="seo-settings" href="{{ route('setting-seo') }}" role="tab">{{ __('seo_settings') }}</a>
                                <a class="nav-item nav-link" id="recaptcha-settings" href="{{ route('setting-recaptcha') }}" role="tab">{{ __('recaptcha_settings') }}</a>
                                <a class="nav-item nav-link" id="setting-url" href="{{ route('settings-url') }}" role="tab">{{ __('url_settings') }}</a>
                                <a class="nav-item nav-link" id="setting-ffmpeg" href="{{ route('settings-ffmpeg') }}" role="tab">{{ __('ffmpeg_settings') }}</a>

                                <a class="nav-item nav-link" id="setting-custom" href="{{ route('setting-custom-header-footer') }}">{{ __('custom_header_footer') }}</a>
                                <a class="nav-item nav-link" id="cron-information" href="{{ route('cron-information') }}">{{ __('cron_information') }}</a>
                                <a class="nav-item nav-link" id="preference-control" href="{{ route('preferene-control') }}">{{ __('preference_setting') }}</a>
                                <a class="nav-item nav-link" id="setting-social-login" href="{{ route('setting-social-login') }}">{{ __('social_login_settings') }}</a>
                                <a class="nav-item nav-link" id="setting-config-cache" href="{{ route('cache') }}">{{ __('cache') }}</a>
                                <a class="nav-item nav-link" id="update-database" href="{{ route('update-database') }}">{{ __('update') }}</a>
                            </div>
                        </nav>
                    </div>

                </div>
                <div class="col-sm-9">
                    <div class="col-12 col-lg-12 mb-2">
                        {!! Form::open(['route' => 'update-theme-option', 'method' => 'post']) !!}
                        <div class="add-new-page  bg-white p-20 m-b-20">
                            <div class="block-header">
                                <h2>تنظیمات ظاهری</h2>
                            </div>
                            {{-- <div class="row p-l-15">
                            <div class="col-12 col-md-12">
                                <div class="form-title">
                                    <label for="header_style">{{ __('header') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_1" value="header_1" {{(data_get($activeTheme, 'options.header_style' )=="header_1" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_1.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_2" value="header_2" {{(data_get($activeTheme, 'options.header_style' )=="header_2" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_2.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_3" value="header_3" {{(data_get($activeTheme, 'options.header_style' )=="header_3" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_3.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_4" value="header_4" {{(data_get($activeTheme, 'options.header_style' )=="header_4" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_4.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_5" value="header_5" {{(data_get($activeTheme, 'options.header_style' )=="header_5" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_5.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 mb-3">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="header_style" id="header_style_6" value="header_6" {{(data_get($activeTheme, 'options.header_style' )=="header_6" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Header/Header_6.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>

                        </div>
                        <div class="row p-l-15">
                            <div class="col-12 col-md-12">
                                <div class="form-title">
                                    <label for="footer_style">{{ __('footer') }}</label>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="footer_style" id="footer_style_1" value="footer_1" {{(data_get($activeTheme, 'options.footer_style' )=="footer_1" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Footer/Footer_1.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="footer_style" id="footer_style_2" value="footer_2" {{(data_get($activeTheme, 'options.footer_style' )=="footer_2" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Footer/Footer_2.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="section_section_style">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="footer_style" id="footer_style_3" value="footer_3" {{(data_get($activeTheme, 'options.footer_style' )=="footer_3" ? 'checked' :'')}} class="custom-control-input">
                                        <span class="custom-control-label"></span>
                                    </label>
                                    <img src="{{static_asset('default-image/Footer/Footer_3.png') }}" alt="" class="img-responsive cat-block-img">
                                </div>
                            </div>
                        </div> --}}
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="page-title" class="col-form-label">{{ __('primary_color') }}</label>
                                        <input id="page-title" value="{{ data_get($activeTheme, 'options.primary_color') }}" name="primary_color" type="color" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="page-title-2" class="col-form-label">{{ __('رنگ دوم فوتر') }}</label>
                                        <input id="page-title-2" value="{{ data_get($activeTheme, 'options.second_color') }}" name="second_color" type="color" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="language" class="col-form-label">{{ __('default_mode') }}</label>
                                        <select class="form-control" name="mode" id="mode">
                                            @foreach (\Config::get('site.modes') as $key => $mode)
                                                <option value="{{ $mode }}" @if (data_get($activeTheme, 'options.mode') == $mode) selected @endif>{{ __($key) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- <div class="col-sm-3">
                                <div class="form-group">
                                    <label for="language" class="col-form-label">{{ __('font') }}</label>
                                    <select class="form-control" name="fonts" id="language">
                                        @foreach (\Config::get('site.fonts') as $key => $font)
                                        <option value="{{ $key }}" @if (data_get($activeTheme, 'options.fonts') == $key) selected @endif>
                                            @php
                                            $font = explode(',', $font);
                                            @endphp {{ $font[0] }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> --}}
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="language" class="col-form-label">{{ __('font') }}</label>
                                        <select class="form-control" name="fonts" id="language">
                                            @php
                                                $fonts = [];
                                            @endphp
                                            @foreach ($fonts as $key => $font)
                                                <option value="{{ $key }}" @if (data_get($activeTheme, 'options.fonts') == $key) selected @endif>

                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 m-t-20">
                                    <div class="form-group form-float form-group-sm text-right">
                                        <button type="submit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-content-save-all"></i>{{ __('save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <div class="col-12 col-lg-12">
                        {!! Form::open(['route' => 'update-settings', 'method' => 'post', 'enctype' => 'multipart/form-data', 'id' => 'update-settings']) !!}
                        <div class="add-new-page bg-white p-20 m-b-20">
                            <div class="row p-l-15">
                                <div class="col-sm-12">
                                    <div class="m-b-20">
                                        <span class=""><strong> {{ __('preloader') }}</strong> </span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="form-title">
                                        <label for="visibility">{{ __('status') }}</label>
                                    </div>
                                </div>
                                <div class="col-3 col-md-2">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="preloader_option" id="visibility_show" value="1" {{ settingHelper('preloader_option') == 1 ? 'checked' : '' }} class="custom-control-input">
                                        <span class="custom-control-label">{{ __('enable') }}</span>
                                    </label>
                                </div>
                                <div class="col-3 col-md-2">
                                    <label class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" name="preloader_option" id="visibility_hide" value="0" class="custom-control-input" {{ settingHelper('preloader_option') == 0 ? 'checked' : '' }}>
                                        <span class="custom-control-label">{{ __('disable') }}</span>
                                    </label>
                                </div>
                                <div class="w-100"></div>
                                <div class="col-3 m-t-20">
                                    <label class="btn btn-primary pull-right">
                                        تغییر فایل پیش نمایش
                                        <input type="file" id="imgInp" name="preloader" style="display: none">
                                    </label>
                                </div>
                                <div class="col-6 m-t-20">
                                    <img id="blah" src="{{ static_asset('site/images/preloader.gif') }}" style="border: 1px solid #ccc" width="100" height="auto">
                                </div>
                                <div class="col-12 m-t-20">
                                    <div class="form-group form-float form-group-sm text-right">
                                        <button type="submit" class="btn btn-primary pull-right"><i class="m-l-10 mdi mdi-content-save-all"></i>{{ __('save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
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
        imgInp.onchange = evt => {
            const [file] = imgInp.files
            if (file) {
                blah.src = URL.createObjectURL(file)
            }
        }
    </script>
@endsection
