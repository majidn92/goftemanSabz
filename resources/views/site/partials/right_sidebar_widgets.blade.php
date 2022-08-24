@php

$rightWidgets = data_get($widgets, \Modules\Widget\Enums\WidgetLocation::RIGHT_SIDEBAR, []);
$posts = \Modules\Post\Entities\Post::where('status', 1)
    ->where('visibility', 1)->get();
$lates_posts = \Modules\Post\Entities\Post::where('status', 1)
    ->where('visibility', 1)
    ->orderBy('created_at', 'desc')
    ->take(15)
    ->get();

//اخبار پربازدید
$our = $posts
    ->where('populare', 1)
    ->sortByDesc('created_at')
    ->sortBy('populare_order')
    ->take(4);
$other = $posts
    ->where('populare', 0)
    ->sortByDesc('created_at')
    ->sortByDesc('total_hit')
    ->take(5);
$populare_posts = $our->merge($other)->shuffle();

@endphp

@foreach ($rightWidgets as $widget)
    @php
        $viewFile = null;
    @endphp
    @if (view()->exists($viewFile))
        @include($viewFile, $widget)
    @endif
@endforeach

<div class="row">
    <div class="col-sm-8 pr-0 middle-column-inner-page">
        @if ($populare_posts->count())
            <div class="mb-2" style="border-radius: 4px">
                <div style="background-color: var(--primary-color);color:white;padding: 5px;margin-bottom: 10px">اخبار پربازدید</div>
                <ul class="box-background">
                    @foreach ($populare_posts as $post)
                        <div>
                            @switch($post->post_type)
                                @case('video')
                                    <i class="fa fa-file-video-o" style="color: var(--primary-color)"></i>
                                @break

                                @case('audio')
                                    <i class="fa fa-file-audio-o" style="color: var(--primary-color)"></i>
                                @break

                                @default
                                    <i class="fa fa-file-text-o" style="color: var(--primary-color)"></i>
                            @endswitch
                            <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                    {{ Str::limit($post->title, 100) }}
                                </a>
                                {{-- @if ($post->post_type == 'rss')
                                    <span style="color: #a99f9f">{{ $post->feed }}</span>
                                @else
                                    <span style="color: #a99f9f">{{ env('APP_NAME') }}</span>
                                @endif --}}
                                {{-- حذف زمان --}}
                                {{-- <span style="color: #a99f9f">--{{ ago_time($post->created_at) }}</span> --}}
                            </li>
                        </div>
                    @endforeach
                </ul>
            </div>
        @endif

        @if ($lates_posts->count())
            <div class="mb-2" style="border-radius: 4px">
                <div style="background-color: var(--primary-color);color:white;padding: 5px;margin-bottom: 10px">آخرین اخبار</div>
                <ul class="box-background">
                    @foreach ($lates_posts as $post)
                        <div>
                            @switch($post->post_type)
                                @case('video')
                                    <i class="fa fa-file-video-o" style="color: var(--primary-color)"></i>
                                @break

                                @case('audio')
                                    <i class="fa fa-file-audio-o" style="color: var(--primary-color)"></i>
                                @break

                                @default
                                    <i class="fa fa-file-text-o" style="color: var(--primary-color)"></i>
                            @endswitch
                            <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                    {{ Str::limit($post->title, 100) }}
                                </a>
                                {{-- @if ($post->post_type == 'rss')
                                    <span style="color: #a99f9f">{{ $post->feed }}</span>
                                @else
                                    <span style="color: #a99f9f">{{ env('APP_NAME') }}</span>
                                @endif --}}
                                {{-- حذف تاریخ --}}
                                {{-- <span style="color: #a99f9f">--{{ ago_time($post->created_at) }}</span> --}}
                            </li>
                        </div>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
    <div class="col-sm-4 px-0">
        @php
            $side_ads = DB::table('side_ads')
                ->orderBy('rank', 'asc')
                ->get();
        @endphp
        @include('site.partials.home.side_ads', ['side_ads' => $side_ads])
    </div>
</div>
