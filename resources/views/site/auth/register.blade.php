@extends('site.layouts.app')
@php
use Illuminate\Support\Str;
$prev = url()->previous();
$flag = 0;
if (Str::contains($prev, 'mobile')) {
    $flag = 1;
}
@endphp

@section('style')
    <link rel="stylesheet" href="{{ url('public/vendor/persian-datepicker/persian-datepicker.css') }}">
    <style>
        input[name='mobile'] {
            text-align: center;
            color: #b5b0b0;
        }

        input[name='code'] {
            text-align: center;
        }
    </style>
@endsection

@section('content')
    <div class="ragister-account text-center">
        <div class="container">
            <div class="account-content margin-top-70">
                <h1 style="background-color: var(--primary-color);color: white;text-align: center;">تکمیل اطلاعات کاربری</h1>
                {{-- @include('site.partials.error') --}}
                <form class="ragister-form pb-0" name="ragister-form" method="post" action="{{ route('site.register') }}">
                    @csrf
                    <div class="row">
                        <div class="col-sm-12 form-group text-left mb-0">
                            <label>
                                <span>شماره موبایل</span>
                                <span style="float: left">
                                    <a href="{{ url('insert-mobile') }}" class="text-primary"> ویرایش</a>
                                </span>
                            </label>
                            <input name="mobile" type="text" value="{{ $mobile }}" class="form-control" disabled>
                        </div>
                        <div class="col-sm-12 form-group text-left mb-0">
                            <label>
                                کد ارسال شده به موبایل
                                <span style="float: left">
                                    <span id="dsp-code" @if ($flag == 0) style="display:none" @endif>
                                        <span id="code-counter"></span>
                                        ثانیه
                                    </span>
                                    <span id="resend-code" @if ($flag == 0) style="cursor: pointer;margin-right: 5px;color: #007bff;pointer-events:auto" @else style="cursor: not-allowed;margin-right: 5px;color: #b5b0b0;pointer-events:none" @endif>
                                        ارسال مجدد کد
                                    </span>
                                </span>
                            </label>
                            <input name="code" type="text" class="form-control" placeholder="- - - -">
                        </div>
                        <div class="col-sm-4 offset-8 form-group text-left mb-0">
                            <label>حقیقی/حقوقی *</label>
                            <select name="hoghooghi" class="form-control">
                                <option value="0">حقیقی</option>
                                <option value="1" @if(session()->has('hoghooghi')) selected @endif>حقوقی</option>
                            </select>
                        </div>
                        <div class="@if(session()->has('hoghooghi')) col-sm-6 @else col-sm-4 @endif  form-group text-left mb-0">
                            <label>@if(session()->has('hoghooghi')) *نام سازمان یا شرکت @else *نام  @endif</label>
                            <input name="first_name" value="{{ old('first_name') }}" type="text" class="form-control" placeholder="{{ __('first_name') }}">
                        </div>
                        <div class="col-sm-4 form-group text-left mb-0" @if(session()->has('hoghooghi')) style='display:none' @endif>
                            <label>{{ __('last_name') }} *</label>
                            <input name="last_name" value="{{ old('last_name') }}" type="text" class="form-control" placeholder="{{ __('last_name') }}">
                        </div>
                        <div class="@if(session()->has('hoghooghi')) col-sm-6 @else col-sm-4 @endif form-group text-left mb-0">
                            <label>{{ __('password') }} *</label>
                            <input name="password" type="password" class="form-control" placeholder="***********">
                        </div>
                        {{-- <div class="col-sm-6 form-group text-left mb-0">
                            <label>{{ __('dob') }} *</label>
                            <input name="dob" type="text" class="form-control example1" required>
                        </div> --}}
                    </div>
                    @if (settingHelper('captcha_visibility') == 1)
                        <div class="mb-4" style="margin: -3px">
                            {!! NoCaptcha::renderJs() !!}
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif
                    <button type="submit">{{ __('sign_up') }}</button>
                    <div class="middle-content">
                        <p style="font-size: 14px">{{ __('already_have_an_account') }} <a href="{{ url('insert-mobile') }}">{{ __('login') }}</a></p> {{-- <a href="#">Forgot your password?</a> --}}
                    </div>
                </form>
                <div class="widget-social">
                    <ul class="global-list">
                        @if (settingHelper('facebook_visibility') == 1)
                            <li class="facebook login"><a href="{{ url('/login/facebook') }}" style="background:#056ED8"><span style="background:#0061C2"><i class="fa fa-facebook" aria-hidden="true"></i></span>{{ __('sign_up_with_facebook') }} </a></li>
                        @endif
                        @if (settingHelper('google_visibility') == 1)
                            <li class="google login"><a href="{{ url('/login/google') }}" style="background:#FF5733"><span style="background:#CD543A"><i class="fa fa-google" aria-hidden="true"></i></span>{{ __('sign_up_with_google') }}</a></li>
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

    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-date.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-datepicker.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(".example1").pDatepicker({
                'timePicker': {
                    'enabled': false,
                },
                format: ' YYYY/MM/DD ',

            });
        });
    </script>

    <script>
        function codeCounter() {
            $('#code-counter').each(function() {
                $(this).prop('Counter', 15).animate({
                    Counter: 0
                }, {
                    duration: 15000,
                    easing: 'swing',
                    step: function(now) {
                        $(this).text(Math.ceil(now));
                    },
                    complete: function() {
                        $('#resend-code').css({
                            "color": "#007bff",
                            "cursor": "pointer",
                            "pointer-events": "auto"
                        });
                        $("#dsp-code").hide();
                    }
                })
            });
        }
    </script>

    <?php if ($flag) {
        echo '<script>codeCounter();</script>';
    } ?>

    <script>
        $("#resend-code").click(function(e) {
            $.ajax({
                type: "get",
                url: "{{ url('resend-code') }}",
                success: function(response) {
                    console.log(response);
                }
            });
            $('#resend-code').css({
                "color": "#b5b0b0",
                "cursor": "not-allowed",
                "pointer-events": "none"
            });
            $("#dsp-code").show();
            codeCounter();
        });
    </script>

    <script>
        $("[name='hoghooghi']").change(function(e) {
            var val = $(this).val();
            $("[name='first_name']").val('');
            $("[name='last_name']").val('');
            $("[name='password']").val('');
            $("[name='first_name']").parent().toggleClass("col-sm-4 col-sm-6");
            $("[name='password']").parent().toggleClass("col-sm-4 col-sm-6");
            if (val == 1) {
                $("[name='last_name']").parent().hide();
                $("[name='first_name']").siblings("label").html('نام سازمان یا شرکت*');
            } else {
                $("[name='last_name']").parent().show();
                $("[name='first_name']").siblings("label").html('نام*');
            }
        });
    </script>
@endsection
