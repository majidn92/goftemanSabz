@extends('site.layouts.app')

@section('style')
    <style>
        input[name='mobile'] {
            text-align: center;
            color: #b5b0b0;
        }

    </style>
@endsection

@section('content')
    <div class="ragister-account text-center">
        <div class="container text-center">
            <div class="account-content margin-top-70">
                <h1 class="text-center" style="background-color: var(--primary-color);color: white;text-align: center;">{{ __('login') }}</h1>
                {{-- @include('site.partials.error') --}}
                <form class="ragister-form pb-0" name="ragister-form" method="post" action="{{ route('site.login') }}">
                    @csrf
                    <div class="form-group text-left mb-0">
                        <label>
                            <span>شماره موبایل</span>
                            <span style="float: left">
                                <a href="{{ url('insert-mobile') }}" class="text-primary"> ویرایش</a>
                            </span>
                        </label>
                        <input name="mobile" type="text" value="{{ $mobile }}" class="form-control" disabled>
                    </div>
                    <div class="form-group text-left mb-0">
                        <label>{{ __('password') }}</label>
                        <input name="password" type="password" class="form-control" required="required" placeholder="***********">
                    </div>
                    {{-- حذف ریکپچا از صفحه ورود رمزعبور --}}
                    {{-- @if (settingHelper('captcha_visibility') == 1)
                        <div class="col-lg-12 text-center mb-4">
                            <div class="row">
                                {!! NoCaptcha::renderJs() !!}
                                {!! NoCaptcha::display() !!}
                            </div>
                        </div>
                    @endif --}}
                    <button type="submit">{{ __('login') }}</button>
                    <div style="text-align: left">
                        <a href="{{ url('forgot-password') }}" class="text-primary" style="font-size: 14px">فراموشی رمز عبور</a>
                    </div>
                </form>
                <div class="widget-social">
                    <ul class="global-list">
                        @if (settingHelper('facebook_visibility') == 1)
                            <li class="facebook login"><a href="{{ url('/login/facebook') }}" style="background:#056ED8"><span style="background:#0061C2"><i class="fa fa-facebook" aria-hidden="true"></i></span>{{ __('login_with_facebook') }}</a></li>
                        @endif
                        @if (settingHelper('google_visibility') == 1)
                            <li class="google login"><a href="{{ url('/login/google') }}" style="background:#FF5733"><span style="background:#CD543A"><i class="fa fa-google" aria-hidden="true"></i></span>{{ __('login_with_google') }}</a></li>
                        @endif
                    </ul>
                </div>
                {{-- <!-- /.contact-form --> --}}
            </div>
            {{-- <!-- /.account-content --> --}}
        </div>
        {{-- <!-- /.container --> --}}
    </div>
    {{-- <!-- /.ragister-account --> --}}
@endsection

@section('script')
    @if (defaultModeCheck() == 'sg-dark')
        <script type="text/javascript">
            jQuery(function($) {
                $('.g-recaptcha').attr('data-theme', 'dark');
            });
        </script>
    @endif
@endsection
