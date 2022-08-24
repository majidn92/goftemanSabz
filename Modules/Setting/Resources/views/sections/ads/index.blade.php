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
    <div class="container">
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
    </div>
    <div>
        <a href="{{ url('setting/section-create') }}" class="btn btn-primary float-left m-2">افزودن بخش جدید</a>
    </div>
    <div class="table-responsive all-pages">
        <table class="table table-bordered table-striped" role="grid">
            <thead>
                <tr role="row">
                    <th width="20">#</th>
                    <th>جایگاه نمایش</th>
                    <th>نام</th>
                    <th>لینک</th>
                    <th>رنگ</th>
                    <th>نمایش اسلایدر</th>
                    <th>نمایش آخرین اخبار</th>
                    <th>نمایش اخبار ویدئویی</th>
                    <th>نمایش تبلیغات</th>
                    @if (Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                        <th>{{ __('options') }}</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($sections as $key => $section)
                    <tr id="row_{{ $section->id }}">
                        <td>{{ $section->id }}</td>
                        <td>{{ $section->rank }}</td>
                        <td>{{ $section->name }}</td>
                        <td>{{ $section->url }}</td>
                        <td><span style="display:inline-block;width: 20px;height: 20px;background-color: {{ $section->color }}"></span></td>
                        <td>
                            @if ($section->slider)
                                <span class="fa fa-check text-success"></span>
                            @else
                                <span class="fa fa-times text-danger"></span>
                            @endif
                        </td>
                        <td>
                            @if ($section->last_post)
                                <span class="fa fa-check text-success"></span>
                            @else
                                <span class="fa fa-times text-danger"></span>
                            @endif
                        </td>
                        <td>
                            @if ($section->video)
                                <span class="fa fa-check text-success"></span>
                            @else
                                <span class="fa fa-times text-danger"></span>
                            @endif
                        </td>
                        <td>
                            @if ($section->ads)
                                <span class="fa fa-check text-success"></span>
                            @else
                                <span class="fa fa-times text-danger"></span>
                            @endif
                        </td>
                        @if (Sentinel::getUser()->hasAccess(['post_write']) || Sentinel::getUser()->hasAccess(['post_delete']))
                            <td>
                                <div class="dropdown">
                                    <button class="btn bg-primary dropdown-toggle btn-select-option" type="button" data-toggle="dropdown">...<span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu options-dropdown">
                                        @if (Sentinel::getUser()->hasAccess(['post_write']))
                                            <li>
                                                <a href="{{url("setting/section-edit/$section->id")}}"><i class="fa fa-edit option-icon"></i>{{ __('edit') }}</a>
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
