@extends('site.layouts.app')
@php
// dd(88)
@endphp

@section('content')
    <div class="sg-page-content">
        <div class="container">

            @if ($page->show_breadcrumb == 1)
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('') }}">{{ __('home') }}</a></li>
                        <li class="breadcrumb-item"><a href="#">{!! $page->title ?? '' !!}</a></li>
                    </ol>
                </nav>
            @endif

            <div class="row">

                <div class="{{ $page->template == 2 ? 'col-md-6 col-lg-6' : 'col-md-6 col-lg-6' }} sg-sticky pl-0">
                    <div class="theiaStickySidebar post-details">
                        <div class="sg-section">
                            <div class="section-content">
                                <div class="sg-post">
                                    <div class="entry-content p-4">
                                        @if ($page->show_title == 1)
                                            <h3>{!! $page->title ?? '' !!}</h3>
                                        @endif
                                        <div class="paragraph p-t-20">
                                            {!! $page->description !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($page->template == 2)
                    <div class="col-md-6 col-lg-6 sg-sticky pr-0">
                        <div class="sg-sidebar theiaStickySidebar">
                            @include('site.partials.right_sidebar_widgets')
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
    </div>
@endsection
