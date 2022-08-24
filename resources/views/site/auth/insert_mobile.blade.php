@extends('site.layouts.app')
@section('content')
    <div class="ragister-account text-center">
        <div class="container text-center">
            <div class="account-content margin-top-70">
                <h1 class="text-center" style="background-color: var(--primary-color);color: white;text-align: center;">{{ __('login') }}</h1>
                {{-- @include('site.partials.error') --}}
                <form class="ragister-form pb-0" name="ragister-form" method="post" action="{{ url('insert-mobile') }}">
                    @csrf
                    <div class="form-group text-left mb-0">
                        <label>شماره موبایل</label>
                        <input name="mobile" value="{{ old('mobile') }}" type="text" maxlength="11" class="form-control" placeholder="09xxxxxxxxx">
                    </div>
                    @if (settingHelper('captcha_visibility') == 1)
                        <div class="mb-4" style="margin: -3px">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif
                    <button type="submit">بعدی</button>
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
            </div>
        </div>
    </div>
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
