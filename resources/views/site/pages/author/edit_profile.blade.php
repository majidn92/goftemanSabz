@extends('site.layouts.app')
@section('my-profile-edit')
    active
@endsection
@php
// dd(Sentinel::getUser()->dob)
@endphp

@section('style')
    <link rel="stylesheet" href="{{ url('public/vendor/persian-datepicker/persian-datepicker.css') }}">
@endsection

@section('content')
    <div class="author-section">
        <div class="container">
            <div class="row">
                @include('site.pages.author.sidebar')
                <div class="col-md-8">
                    <div class="author-form-content">
                        <div class="author">
                            @if (Sentinel::getUser()->profile_image != null)
                                <img src="{{ static_asset('default-image/user.jpg') }}" data-original=" {{ static_asset(Sentinel::getUser()->profile_image) }}" id="profile-img" class="img-thumbnail" height="200">
                            @else
                                <img src="{{ static_asset('default-image/user.jpg') }}" height="200" id="profile-img" class="img-thumbnail">
                            @endif

                        </div>
                        <form class="author-form" name="author-form" method="post" action="{{ route('site.profile.save') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group text-left mb-0">
                                <input type="file" id="profile_image" name="profile_image">
                                <label for="profile_image">{{ __('select_image') }}</label>
                            </div>
                            <div class="form-group text-left mb-0">
                                <label>{{ __('first_name') }}</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="{{ Sentinel::getUser()->first_name }}" placeholder="admin">
                            </div>
                            @if (Sentinel::getUser()->hoghooghi == 0)
                                <div class="form-group text-left mb-0">
                                    <label>{{ __('last_name') }}</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ Sentinel::getUser()->last_name }}" placeholder="admin">
                                </div>
                            @endif
                            {{-- <div class="form-group text-left mb-0">
                                <label>{{ __('email') }}</label>
                                <input type="email" id="email" disabled value="{{ Sentinel::getUser()->email }}" class="form-control"  placeholder="{{ __('input_email') }}">
                            </div> --}}
                            <div class="form-group text-left mb-0">
                                <label>{{ __('phone') }}</label>
                                <input type="text" id="phone" name="phone" value="{{ Sentinel::getUser()->phone }}" class="form-control" placeholder="0912xxxxxxx">
                            </div>
                            {{-- <div class="form-group text-left mb-0">
                                <label>{{ __('dob') }}</label>
                                <input type="text"  name="dob"  value="{{ Sentinel::getUser()->dob }}" class="form-control example1" >
                            </div> --}}
                            {{-- <div class="form-group text-left mb-0">
                                <label>{{ __('gender') }}</label>
                                <select class="form-control" name="gender" id="gender">
                                    <option>{{ __('select_option') }}</option>
                                    @foreach (__('genders.genderType') as $value => $item)
                                        <option @if (Sentinel::getUser()->gender == $value) Selected @endif value="{{ $value }}">{{ $item }}</option>
                                    @endforeach
                                </select>
                            </div> --}}
                            <div class="form-group text-left mb-0">
                                <label>{{ __('about_me') }}</label>
                                <textarea class="form-control" name="about" placeholder="{{ __('input_message') }}">{{ Sentinel::getUser()->about_us }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">{{ __('save') }}</button>
                        </form>
                    </div><!-- /.author-form-content -->
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.author-section -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-date.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/vendor/persian-datepicker/persian-datepicker.js') }}"></script>


    <script>
        $(document).ready(function() {
            $(".example1").pDatepicker({
                'timePicker': {
                    'enabled': false,
                },
                format: 'YYYY/MM/DD ',

            });
        });
    </script>
@endsection
