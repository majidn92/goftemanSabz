@extends('site.layouts.app')

@section('content')
    <div style="width: 90%;margin: auto">
        <div>
            <h2 style="color: var(--primary-color);font-weight: 600;margin-top: 15px" class="category-title">
                آخرین اخبار استان
                <span> {{ $state->name }}</span>
            </h2>
        </div>
        @include('site.partials.header_inner_page')
        <div class="row container-section">
            @php
                $posts = $posts->skip(7)->take(99999);
            @endphp
            @if ($posts->count())
                <div class="col-sm-6">
                    @foreach ($posts as $item)
                        <div>
                            <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                <div class="row mb-1 p-1" style="background: white">
                                    <div class="col-sm-6 px-1 text-center">
                                        @if ($item->image)
                                            <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                        @else
                                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                        @endif
                                    </div>
                                    <div class="col-sm-6 px-1" style="font-weight: 600;font-size: 16px">
                                        <div>
                                            {{ \Illuminate\Support\Str::limit($item->title, 150) }}
                                        </div>
                                        <div style="margin-top: 10px;color: #ccc;font-size: 14px;overflow: hidden;">
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
                <div class="col-sm-6">
                    
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
