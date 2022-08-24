@php
$header_posts = $posts->take(6);
$header_posts_1 = $posts->take(1);
$header_posts_2 = $posts->skip(1)->take(3);
$header_posts_3 = $posts->skip(4)->take(2);
$posts = $posts->skip(6)->take(99999);
@endphp

<div class="row pt-2 mb-5" style="border-top:solid var(--primary-color) ;border-radius: 5px">
    @if ($header_posts_1->count())
        <div class="col-sm-4">
            <a href="{{ route('article.detail', ['id' => $header_posts_1->first()->slug]) }}">
                <div>
                    @if ($header_posts_1->first()->image)
                        <img src="{{ static_asset($header_posts_1->first()->image->medium_image) }}" alt="" style="border-radius: 5px;width: 100%;">
                    @else
                        <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" style="border-radius: 5px;width: 100%;">
                    @endif
                </div>
                <div class="my-1" style="font-weight: 600;font-size: 14px;overflow: hidden">
                    {{ Str::limit($header_posts_1->first()->title, 50) }}
                </div>
                <div>
                    @if ($header_posts_1->first()->rss)
                        {{ Str::limit($header_posts_1->first()->content, 100) }}
                    @else
                        {{ Str::limit($header_posts_1->first()->sub_title, 100) }}
                    @endif
                </div>
            </a>
        </div>
    @endif
    @if ($header_posts_2->count())
        <div class="col-sm-5">
            @foreach ($header_posts_2 as $post)
                <div style="margin-bottom: 10px;display: flex;flex-wrap: wrap;align-items: center">
                    <div style="width: 33%">
                        @if ($post->image)
                            <img src="{{ static_asset($post->image->medium_image ?? 'default-image/default-240x160.png') }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                        @else
                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                        @endif
                    </div>
                    <div style="padding-right: 10px;width: 66%">
                        <div style="font-weight: 600;font-size: 15px">
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                {{ Str::limit($post->title, 60) }}
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
    @if ($header_posts_3->count())
        <div class="col-sm-3">
            @foreach ($header_posts_3 as $post)
                <div style="position: relative" class="mb-1">
                    <div>
                        <div class="entry-thumbnail">
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                @if (isFileExist($post->image, $result = @$post->image->medium_image))
                                    <img src="{{ safari_check() ? basePath(@$post->image) . '/' . $result : static_asset('default-image/default-358x215.png') }} " data-original=" {{ basePath($post->image) }}/{{ $result }} " class="img-fluid" alt="{!! $post->title !!}">
                                @else
                                    <img src="{{ static_asset('default-image/default-358x215.png') }} " class="img-fluid" alt="{!! $post->title !!}">
                                @endif
                            </a>
                        </div>
                        @if ($post->post_type == 'video')
                            <div class="video-icon large-block">
                                <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                            </div>
                        @elseif($post->post_type == 'audio')
                            <div class="video-icon large-block">
                                <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                            </div>
                        @endif
                    </div>
                    <div style="position: absolute;width: 100%;bottom: 0;background: rgba(0,0,0,.5);border-radius: 0 0 5px 5px">
                        <h3 class="entry-title" style="padding: 5px;line-height: 15px">
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}" style="color: white;font-size: 14px;">{!! \Illuminate\Support\Str::limit($post->title, 100) !!}</a>
                        </h3>
                        {{-- <p>{!! strip_tags(\Illuminate\Support\Str::limit($post->content, 120)) !!}</p> --}}
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
