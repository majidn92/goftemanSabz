@extends('site.layouts.app')
@section('content')
    <div style="width: 90%;margin: auto">
        <div class="row margin-top-70">
            @if ($section->ads && $top_center_ads->count())
                <div class="w-100">
                    <a href="{{ $top_center_ads[0]->url }}">
                        <img src="{{ url($top_center_ads[0]->path) }}" style="height: 150px !important" alt="">
                    </a>
                </div>
            @endif
            @if ($posts->count())
                <div>
                    <h2 style="color: var(--primary-color);font-weight: 600;margin-top: 15px" class="category-title">
                        اخبار
                        <span class="category-title"> {{ $section->name }} </span>
                    </h2>
                </div>
                @include('site.partials.header_inner_page')
                <div class="col-sm-6">
                    @php
                        $posts = $posts->skip(7)->take(99999);
                    @endphp
                    @foreach ($posts as $item)
                        <div>
                            <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                <div class="row mb-1 p-1" style="background: white">
                                    <div class="col-sm-6 px-1">
                                        @if ($item->image)
                                            <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                        @else
                                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="col-sm-6 px-1" style="font-weight: 600;font-size: 14px">
                                        <div>
                                            {{ \Illuminate\Support\Str::limit($item->title, 150) }}
                                        </div>
                                        <div style="margin-top: 10px;color: #ccc;font-size: 12px;overflow: hidden;">
                                            {{ $item->sub_title }}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                    {{-- {{ $posts->links() }} --}}
                </div>
            @else
                <div class="col-sm-6 alert alert-warning" role="alert">
                    خبری از این بخش یافت نشد
                </div>
            @endif
            <div class="col-md-6">
                <div class="sg-sidebar theiaStickySidebar">
                    @include('site.partials.right_sidebar_widgets')
                </div>
            </div>
        </div>

    </div>
@endsection
