@php
$slider_posts = $posts
    ->where('slider', 1)
    ->sortByDesc('created_at')
    ->take(10);
$block_posts = $posts
    ->where('featured', 1)
    ->sortByDesc('created_at')
    ->take(10);
$specialty_posts = $posts
    ->where('rss', 0)
    ->sortByDesc('created_at')
    ->take(10);
$rss_posts = $posts
    ->where('rss', 1)
    ->sortByDesc('created_at')
    ->take(10);
// dd(11);
@endphp

<style>
    /* li {
        list-style-type: none;
    }

    li::before {
        content: "• ";
        color: red;
        font-size: 2em;
    } */

</style>

{{-- <div class="sg-breaking-news">
    <div class="container">
        <div class="breaking-content d-flex">
            <span>{{ __('breaking_news') }}</span>
            <ul class="news-ticker">
                @foreach ($breakingNewss as $post)
                <li id="display-nothing">
                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}">{!! \Illuminate\Support\Str::limit($post->title, 100) !!}</a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div> --}}

<div class="sg-home-section mb-3">
    <div>
        <div class="row">
            <div class="col-lg-6 p-0">
                <div class="post-slider">
                    @foreach ($slider_posts as $post)
                        <div class="sg-post featured-post">
                            @include('site.partials.home.primary.slider')
                            <div class="entry-content absolute">
                                <div class="category">
                                    <ul class="global-list">
                                        @isset($post->category->category_name)
                                            <li>
                                                <a href="{{ url('category', $post->category->slug) }}">{{ $post->category->category_name }}</a>
                                            </li>
                                        @endisset
                                    </ul>
                                </div>
                                <h2 class="entry-title">
                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}" style="font-size: 18px">{!! \Illuminate\Support\Str::limit($post->title, 60) !!}</a>
                                </h2>
                                <div class="entry-meta">
                                    <ul class="global-list">
                                        <li><a href="{{ route('site.author', ['id' => $post->user->id]) }}">{{ data_get($post, 'user.first_name') }} {{ data_get($post, 'user.last_name') }}</a>
                                        </li>
                                        <li><a href="{{ route('article.date', date('Y-m-d', strtotime($post->updated_at))) }}">{{ miladi_to_jalali($post->updated_at) }}</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- <div class="row">
                    @foreach ($blockPosts as $post)
                    <div class="col-md-6">
                        <div class="sg-post position-relative">
                            <div class="entry-header">
                                <div class="entry-thumbnail">
                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                        @if (isFileExist(@$post['image'], $result = @$post['image']->medium_image))
                                        <img src="{{ safari_check()? basePath(@$post['image']) . '/' . $result: static_asset('default-image/default-358x215.png') }} " data-original=" {{ basePath(@$post['image']) }}/{{ $result }} " class="img-fluid lazy" alt="{!! $post->title !!}">
                                        @else
                                        <img src="{{ static_asset('default-image/default-358x215.png') }} " class="img-fluid" alt="{!! $post->title !!}">
                                        @endif
                                    </a>
                                </div>
                                @if ($post->post_type == 'video')
                                <div class="video-icon block">
                                    <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                </div>
                                @elseif($post->post_type == 'audio')
                                <div class="video-icon block">
                                    <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                </div>
                                @endif
                                <div class="category">
                                    <ul class="global-list">
                                        @isset($post->category->category_name)
                                        <li>
                                            <a href="{{ url('category', $post['category']->slug) }}">{{ $post['category']->category_name }}</a>
                                        </li>
                                        @endisset
                                    </ul>
                                </div>
                            </div>
                            <div class="entry-content block position-absolute" style="top: 70px">
                                <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                    <p>{!! \Illuminate\Support\Str::limit($post->title, 70) !!}</p>
                                </a>
                                <div class="entry-meta">
                                    <ul class="global-list">
                                        <li><a href="{{ route('article.date', date('Y-m-d', strtotime($post->updated_at))) }}"> {{ miladi_to_jalali($post->updated_at) }}</a></li>
                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div> --}}

                <div class="majid">
                    @foreach ($block_posts as $post)
                        <div style="position: relative">
                            {{-- <img src="{{ url($post) }}" width="150">
                        <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                            <p>{!! \Illuminate\Support\Str::limit($post->title, 70) !!}</p>
                        </a> --}}
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                @if (isFileExist(@$post->image, $result = @$post->image->medium_image))
                                    <img src="{{ safari_check() ? basePath(@$post->image) . '/' . $result : static_asset('default-image/default-358x215.png') }} " data-original=" {{ basePath(@$post->image) }}/{{ $result }} " class="img-fluid lazy" alt="{!! $post->title !!}" width="100%" height="100%">
                                @else
                                    <img src="{{ static_asset('default-image/default-358x215.png') }} " class="img-fluid" alt="{!! $post->title !!}">
                                @endif
                            </a>
                            <div style="position: absolute;bottom:0;right:0;left:0;padding:3px;height:35%;background-color: black;background-color:rgba(0,0,0,0.65);color:white;display: flex; align-items: flex-end;direction: rtl;border-radius: 0px 0px 5px 5px;font-size: 14px">
                                <a href="{{ route('article.detail', ['id' => $post->slug]) }}" style="color: white">
                                    {!! \Illuminate\Support\Str::limit($post->title, 60) !!}
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- بخش میانی --}}
            <div class="col-lg-6">
                <div class="pb-2" style="background-color: rgb(235, 235, 235);border-radius: 4px">
                    <div>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation" style="width: 50%;text-align: center">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">اخبار تخصصی</a>
                            </li>
                            <li class="nav-item" role="presentation" style="width: 50%;text-align: center">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">دیگر خبرها</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="myTabContent" style="padding-top: 15px;padding-bottom: 10px;padding-right: 5px">
                            {{-- بابت اخبار تخصصی --}}
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                @foreach ($specialty_posts as $post)
                                    <div>
                                        @switch($post->post_type)
                                            @case('video')
                                                <i class="fa fa-file-video-o" style="color: {{ $section->color }}"></i>
                                            @break

                                            @case('audio')
                                                <i class="fa fa-file-audio-o" style="color: {{ $section->color }}"></i>
                                            @break

                                            @case('article')
                                                <i class="fa fa-file-text-o" style="color: {{ $section->color }}"></i>
                                            @break

                                            @default
                                                <i class="fa fa-rss" style="color: {{ $section->color }}"></i>
                                        @endswitch
                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                {{ Str::limit($post->title, 50) }} |
                                            </a>
                                            {{ $post->feed }} --
                                            <span style="color: #a99f9f">{{ ago_time($post->created_at) }}</span>
                                        </li>
                                    </div>
                                @endforeach
                            </div>
                            {{-- RSS بابت --}}
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                @foreach ($rss_posts as $post)
                                    <div>
                                        <i class="fa fa-rss" style="color: {{ $section->color }}"></i>
                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px">
                                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                {{ Str::limit($post->title, 65) }} |
                                            </a>
                                            {{ $post->feed }} --
                                            <span style="color: #a99f9f">{{ ago_time($post->created_at) }}</span>
                                        </li>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
