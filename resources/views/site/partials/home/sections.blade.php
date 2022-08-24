<style>
    #section-{{ $section->id }} a:hover {
        color: {{ $section->color }};
    }

    #section-{{ $section->id }} li.nav-item a.active {
        background-color: {{ $section->color }} !important;
    }

    #section-{{ $section->id }} .nav-tabs {
        border-bottom: 1px solid {{ $section->color }};
    }

    #section-{{ $section->id }} .nav-link.active {
        border-color: {{ $section->color }} !important;
    }

    #section-{{ $section->id }} .mb-4 li:before {
        background-color: {{ $section->color }};
    }

    #section-{{ $section->id }} .tab-pane li:before {
        background-color: {{ $section->color }};
    }

</style>

<div id="section-{{ $section->id }}" class="section-box" style="border-color: {{ $section->color }}">

    <div class="section-seprator" style="border-bottom: solid 3px {{ $section->color }}">
        <a href="{{ $section->url }}" target="_blank">
            <span style="background-color: {{ $section->color }}">{{ $section->name }}</span>
        </a>
        @php
            $breaking_news = Modules\Post\Entities\Post::where('visibility', 1)
                ->where('status', 1)
                ->where('section_id', $section->id)
                ->where('breaking', 1)
                ->orderBy('breaking', 'asc')
                ->orderBy('created_at', 'desc')
                ->get();
        @endphp
        <div>
            @include('site.partials.breaking_news')
        </div>
        <div style="clear: both"></div>
    </div>


    @if ($section->slider)
        <div class="row m-0">
            {{-- نمایش بخش اسلایدر --}}
            <div class="col-sm-10">
                @include('site.partials.home.primary.style_1')
            </div>
            {{-- نمایش بخش تبلیغات کناری --}}
            <div class="col-sm-2 text-center p-0">
                @include('site.partials.home.side_ads')
            </div>
        </div>
    @endif



    <div class="row mb-4 mt-2">
        {{-- نمایش بخش آخرین اخبار --}}
        @if ($section->last_post)
            <div class="col-sm-6 mb-2">
                <div class="p-2" style="background-color: rgb(235, 235, 235);padding-right: 20px !important;border-radius: 4px">
                    <span style="font-weight: 600;color:{{ $section->color }}">آخرین اخبار</span>
                    <hr style="height: 2px;margin-top: 8px;background-color: {{ $section->color }}">
                    <div>
                        <ul>
                            @php
                                $last_posts = $posts->sortByDesc('created_at')->take(10);
                            @endphp
                            {{-- بابت آخرین اخبار --}}
                            @foreach ($last_posts as $last_post)
                                <div>
                                    @switch($last_post->post_type)
                                        @case('video')
                                            <i class="fa fa-file-video-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @case('audio')
                                            <i class="fa fa-file-audio-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @default
                                            <i class="fa fa-file-text-o" style="color: {{ $section->color }}"></i>
                                    @endswitch
                                    <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                        <a href="{{ route('article.detail', ['id' => $last_post->slug]) }}" target="_blank">
                                            {{ Str::limit($last_post->title, 50) }} |
                                        </a>
                                        {{ $last_post->feed }} 
                                        {{-- -- <span style="color: #a99f9f">{{ ago_time($last_post->created_at) }}</span> --}}
                                    </li>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 mb-2">
                <div class="p-2" style="background-color: rgb(235, 235, 235);padding-right: 20px !important;border-radius: 4px">
                    <span style="font-weight: 600;color: {{ $section->color }}">اخبار پربیننده</span>
                    <hr style="height: 2px;margin-top: 8px;background-color: {{ $section->color }}">
                    <div>
                        <ul>
                            @php
                                $popular_posts_level_1 = $posts
                                    ->where('popular', 1)
                                    ->sortByDesc('total_hit')
                                    ->take(10);
                                $popular_posts_level_2 = $posts
                                    ->where('popular', '!=', 1)
                                    ->sortByDesc('total_hit')
                                    ->take(10);
                                $popular_posts = $popular_posts_level_1->concat($popular_posts_level_2)->take(10);
                            @endphp
                            {{-- اخبار پربیننده --}}
                            @foreach ($popular_posts as $popular_post)
                                <div>
                                    @switch($last_post->post_type)
                                        @case('video')
                                            <i class="fa fa-file-video-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @case('audio')
                                            <i class="fa fa-file-audio-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @default
                                            <i class="fa fa-file-text-o" style="color: {{ $section->color }}"></i>
                                    @endswitch
                                    <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                        <a href="{{ route('article.detail', ['id' => $popular_post->slug]) }}" target="_blank">
                                            {{ Str::limit($popular_post->title, 50) }} |
                                        </a>
                                        {{ $popular_post->feed }} 
                                        {{-- -- <span style="color: #a99f9f">{{ ago_time($popular_post->created_at) }}</span> --}}
                                    </li>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

        {{-- نمایش بخش گالری --}}

        @if ($section->video)
            {{-- گالری صوت و ویدئو --}}
            @php
                $video_posts = $posts
                    ->where('post_type', 'video')
                    ->where('featured_main_page', 1)
                    ->sortbydesc('featured_main_page_order')
                    ->sortbydesc('created_at')
                    ->take(10);
                $audio_posts = $posts
                    ->where('post_type', 'audio')
                    ->where('featured_main_page', 1)
                    ->sortbydesc('featured_main_page_order')
                    ->sortbydesc('created_at')
                    ->take(10);
                $media = $video_posts
                    ->merge($audio_posts)
                    ->sortbydesc('featured_main_page_order')
                    ->sortbydesc('created_at')
                    ->take(10);
            @endphp
            <div class="col-sm-4 mb-2 majid3">
                @foreach ($media as $item)
                    {{-- @foreach ($videos as $video)
                            <div class="entry-header">
                                <a href="{{ route('article.detail', ['id' => $video->slug]) }}"></a>
                                <img src="{{ static_asset($video->image->big_image) }}" width="426" height="240" style="height: 240px !important">
                                <a href="{{ url("category/{$video->category->category_name}") }}">
                                    <span class="post-lable">{{ $video->category->category_name }}</span>
                                </a>
                                <a href="{{ route('article.detail', ['id' => $last_post->slug]) }}">
                                    <div class="post-title">{{ $video->title }}</div>
                                </a>
                                @if ($video->post_type == 'video')
                                    <div class="video-icon">
                                        <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                    </div>
                                @elseif($item->post_type == 'audio')
                                    <div class="video-icon">
                                        <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                    </div>
                                @endif
                            </div>
                            @endforeach --}}
                    <div style="position: relative" class="entry-header">
                        <a href="{{ url("media-albums?section_id=$section->id") }}" target="_blank">
                            <span class="post-lable-all">همه ویدئوها</span>
                        </a>
                        <a href="{{ url("media-albums?id=$item->id") }}" target="_blank">
                            <img src="{{ static_asset($item->image->medium_image) }}" style="width: 100%">
                            <div class="post-title">{{ $item->title }}</div>

                            @if ($item->post_type == 'video')
                                <div class="video-icon">
                                    <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                </div>
                            @elseif($item->post_type == 'audio')
                                <div class="video-icon">
                                    <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                </div>
                            @endif
                        </a>
                    </div>
                @endforeach
            </div>


            {{-- گالری عکس --}}
            @php
                $albums = $section->albums;
            @endphp
            <div class="col-sm-4 mb-2 majid3">
                @foreach ($albums as $album)
                    <div style="position: relative">
                        <a id="img-album-cover" data-id="{{ $album->id }}">
                            <img src="{{ static_asset($album->original_image) }}" data-caption="{{ $album->name }}" class="lightboxed" rel="img-{{ $album->id }}" style="width: 100%">
                        </a>
                        @foreach ($album->galleryImages as $image)
                            <img src="{{ static_asset($image->original_image) }}" data-caption="{{ $image->title }}" class="lightboxed" rel="img-{{ $album->id }}" style="display: none">
                        @endforeach
                        <a href="{{ url('albums') }}" target="_blank">
                            <span class="post-lable" style="left: 20px;right: unset;">عکس های بیشتر</span>
                        </a>
                        <div class="post-title">{{ $album->name }}</div>
                    </div>
                @endforeach
            </div>

            {{-- اخبار استان ها --}}
            <div class="col-sm-4 mb-2 majid3">
                <a href="{{ url("state?section_id=$section->id") }}"></a>
            </div>
        @endif

        {{-- نمایش بخش تبلیغات --}}
        @if ($section->ads)
            @php
                $center_ads = $section->center_ads;
            @endphp
            <div class="col-sm-12 mb-2 majid2">
                @foreach ($center_ads as $item)
                    <a href="{{ $item->url }}" target="_blank">
                        <img src="{{ url($item->path) }}">
                    </a>
                @endforeach
            </div>
        @endif

    </div>
</div>
