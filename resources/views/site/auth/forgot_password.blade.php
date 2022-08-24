@extends('site.layouts.app') @section('content')
    <div class="ragister-account text-center">
        <div class="container">
            <div class="account-content margin-top-70">
                <h1 style="background: var(--primary-color);color:white">بازیابی رمز عبور</h1> {{-- @include('site.partials.error') --}}
                <form class="ragister-form" name="ragister-form" method="post" action="{{route('do-forget-password')}}">
                    @csrf
                    <div class="form-group text-left mb-0">
                        <label for="">شماره موبایل</label>
                        <input name="mobile" type="text" value="{{old('mobile')}}" class="form-control" required="required" placeholder="09xxxxxxxxx">
                    </div>
                    <button type="submit">ارسال کد</button>
                </form>
                <hr style="margin-top: 0">
                <div style="font-size: 14px;margin-bottom: 12px">
                    کاربر جدید هستید؟ <a href="{{url('insert-mobile')}}" class="text-primary">ثبت نام کنید</a>
                </div>
                {{--            <!-- /.contact-form -->--}}
            </div>
            {{--        <!-- /.account-content -->--}}
        </div>
        {{--    <!-- /.container -->--}}
    </div>
    {{--<!-- /.ragister-account -->--}}
@endsection
