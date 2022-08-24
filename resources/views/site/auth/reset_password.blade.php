@php
use Illuminate\Support\Str;
$prev = url()->previous();
$flag = 0;
if (Str::contains($prev, 'forgot')) {
    $flag = 1;
}
@endphp

@extends('site.layouts.app')

@section('style')
    <style>
        .form-control {
            margin-bottom: 15px;
        }

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
                <h1 style="background: var(--primary-color);color:white">بازیابی رمز عبور</h1> {{-- @include('site.partials.error') --}}
                <form class="ragister-form" name="ragister-form" method="post" action="{{ url('reset-password') }}">
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
                    <div class="form-group">
                        <label for="">رمز عبور جدید</label>
                        <input class="form-control" id="password" value="{{ old('password') }}" name="password" data-parsley-minlength="4" type="password" placeholder="رمز عبور جدید" required />
                    </div>
                    <div class="form-group">
                        <label for="">تکرار رمز عبور جدید</label>
                        <input class="form-control" id="password_confirmation" value="{{ old('password_confirmation') }}" name="password_confirmation" data-parsley-minlength="4" type="password" placeholder="تکرار رمز عبور جدید" required />
                    </div>
                    <button type="submit">{{ __('change_password') }}</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function codeCounter() {
            $('#code-counter').each(function() {
                $(this).prop('Counter', 30).animate({
                    Counter: 0
                }, {
                    duration: 30000,
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
@endsection
