<!-- msater layout -->
@extends('common::layouts.master')
<!-- active menu -->
@section('widgets')
    active
@endsection

@section('content')

    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <!-- page info start-->

            <div class="admin-section">
                <div class="row clearfix m-t-30">
                    <div class="col-12">
                        <div class="navigation-list bg-white p-20">
                            <div class="add-new-header clearfix m-b-20">
                                <div class="row">
                                    <div class="col-12">
                                        @if(session('error'))
                                            <div id="error_m" class="alert alert-danger">
                                                {{session('error')}}
                                            </div>
                                        @endif
                                        @if(session('success'))
                                            <div id="success_m" class="alert alert-success">
                                                {{session('success')}}
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
                                <div class="row">
                                    <div class="block-header col-6">
                                        <h2>{{ __('widgets') }}</h2>
                                    </div>
                                    {{-- @if(Sentinel::getUser()->hasAccess(['users_write'])) --}}
                                    <div class="col-6 text-left">
                                        <a href="{{ route('create-widget') }}" class="btn btn-primary btn-sm"><i
                                                class="m-l-10 mdi mdi-plus"></i>{{__('add_widget')}}</a>
                                    </div>
                                    {{-- @endif --}}
                                </div>
                            </div>
                            <div class="table-responsive all-pages">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                    <tr role="row">
                                        <th>#</th>
                                        <th>{{ __('title') }}</th>
                                        <th>{{ __('content_type') }}</th>
                                        <th>{{ __('language') }}</th>
                                        <th>{{ __('location') }}</th>
                                        <th>{{ __('order') }}</th>
                                        <th>{{ __('type') }}</th>
                                        <th>{{ __('status') }}</th>
                                        <th>{{ __('added_date') }}</th>
                                        @if(Sentinel::getUser()->hasAccess(['widget_write']) || Sentinel::getUser()->hasAccess(['widget_delete']))
                                            <th>{{ __('options') }}</th>
                                        @endif
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($widgets as $widget)

                                        <tr role="row" id="row_{{ $widget->id }}" class="odd">
                                            <td class="sorting_1">{{ $widget->id}}</td>
                                            <td>{{ $widget->title }}</td>
                                            <td>
                                                @if($widget->content_type == Modules\Widget\Enums\WidgetContentType::POPULAR_POST)
                                                    {{ __('Popular Posts') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::TAGS)
                                                    {{ __('Tags') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::CUSTOM)
                                                    {{ __('Custom') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::NEWS_LETTER)
                                                    {{ __('News Letter') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::RECENT_POST)
                                                    {{ __('Recent Posts') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::RECOMMENDED_POSTS)
                                                    {{ __('Recommended Posts') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::VOTING_POLL)
                                                    {{ __('Voting Poll') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::AD)
                                                    {{ __('Ad') }}
                                                 @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::CATEGORIES)
                                                    {{ __('Categories') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::EDITORS_PICKS)
                                                    {{ __('Editor Picks') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::FEATURED_POST)
                                                    {{ __('Featured Posts') }}

                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::FOLLOW_US)
                                                    {{ __('Follow Us') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::ARCHIVE)
                                                    {{ __('Archive') }}
                                                @elseif($widget->content_type == Modules\Widget\Enums\WidgetContentType::QUIZ)
                                                    {{ __('Quiz') }}
                                                @endif

                                            </td>
                                            <td>{{ __($widget->language) }}</td>
                                            <td>
                                                @if($widget->location ==  \Modules\Widget\Enums\WidgetLocation::HEADER)
                                                    {{__('header')}}
                                                @elseif($widget->location ==  \Modules\Widget\Enums\WidgetLocation::FOOTER)
                                                    {{__('footer')}}
                                                @else
                                                    {{__('right_sidebar')}}
                                                @endif
                                            </td>
                                            <td>{{ $widget->order }}</td>
                                            <td>@if($widget->is_custom==1) {{ __('custom') }} @else {{ __('default') }} @endif</td>
                                            <td>@if($widget->status==1) {{ __('active') }} @else {{ __('inactive') }} @endif</td>
                                            <td>{{miladi_to_jalali($widget->created_at,true)}}</td>
                                            @if(Sentinel::getUser()->hasAccess(['widget_write']) || Sentinel::getUser()->hasAccess(['widget_delete']))
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn bg-primary dropdown-toggle btn-select-option"
                                                                type="button" data-toggle="dropdown">... <span
                                                                class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu options-dropdown">
                                                            @if(Sentinel::getUser()->hasAccess(['widget_write']))
                                                                <li>
                                                                    <a href="{{ route('edit-widget',['id'=>$widget->id]) }}"><i
                                                                            class="fa fa-edit option-icon"></i>{{ __('edit') }}
                                                                    </a>
                                                                </li>
                                                            @endif
                                                            @if(Sentinel::getUser()->hasAccess(['widget_delete']))
                                                                <li>
                                                                    <a href="javascript:void(0)"
                                                                       onclick="delete_item('widgets','{{ $widget->id }}')"><i
                                                                            class="fa fa-trash option-icon"></i>{{ __('delete') }}
                                                                    </a>
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
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="block-header">
                                        <h2>{{ __('showing') }} {{ $widgets->firstItem()}} {{  __('to') }} {{ $widgets->lastItem()}} {{ __('of') }} {{ $widgets->total()}} {{ __('entries') }}</h2>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 text-right">
                                    <div class="table-info-pagination float-right">
                                        {!! $widgets->render() !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- page info end-->
        </div>
    </div>
@endsection
