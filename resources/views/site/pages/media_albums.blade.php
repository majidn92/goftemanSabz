@extends('site.layouts.app')

@section('style')
    <style>
        audio,
        video {
            display: block;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary-color);
        }

        .entry-header img {
            width: 100%;
        }

        audio::-webkit-media-controls-enclosure {
            border-radius: 0px;
            background-color: var(--primary-color);
        }
    </style>
@endsection


@section('content')
    @if ($media_posts->count())
        <div style="margin-top: -10px">

            {{-- ----------------------------------------------- بخش اول  ---------------------------------------------- --}}

            <div style="background-color: {{ $back_ground_color }};margin-bottom: 20px" class="p-1">
                <div id="top-section" style="width: 90%;margin: auto">
                    <div style="border-bottom: 2px solid white;color: white;margin-bottom: 20px;margin-top: 20px">
                        <span>گروه فیلم و صوت</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div id="frame-box">
                                @if ($last_media_post->post_type == 'video')
                                    <div class="main-video-player">
                                        <video src="{{ static_asset($last_media_post->video->original) }}" controls width="100%"></video>
                                        <div style="color: white;padding: 3px;margin-top: 5px">
                                            <div style="text-align: left;font-size: 14px;color: #a99f9f;">
                                                <span><i class="fa fa-calendar"></i></span>
                                                <span>{{ miladi_to_jalali($last_media_post->created_at, 1) }}</span>
                                            </div>
                                            <div>{{ $last_media_post->title }}</div>
                                            <div>{{ $last_media_post->sub_title }}</div>
                                        </div>
                                    </div>
                                @else
                                    <div class="main-audio-player">
                                        <div class="entry-header">
                                            <div style="position: relative">
                                                <img src="{{ static_asset($last_media_post->image->medium_image) }}" alt="" width="100%">
                                                <div style="position: relative">
                                                    <audio style="width:100%;position: absolute;bottom:0px" id="main-audio-player" src="{{ static_asset($last_media_post->audio[0]->original) }}" controls></audio>
                                                </div>
                                            </div>
                                            <div style="color: white;padding: 3px;margin-top: 5px">
                                                <div style="text-align: left;font-size: 14px;color: #a99f9f;">
                                                    <span><i class="fa fa-calendar"></i></span>
                                                    <span>{{ miladi_to_jalali($last_media_post->created_at, 1) }}</span>
                                                </div>
                                                <div>{{ $last_media_post->title }}</div>
                                                <div>{{ $last_media_post->sub_title }}</div>
                                            </div>
                                            <div class="video-icon">
                                                <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>
                        {{-- اخبار پر بیننده --}}
                        <div class="col-sm-4">
                            <div style="height: 400px;overflow-y: auto;">
                                <div class="container">
                                    @foreach ($popular_media_posts as $item)
                                        <div class="media-item" data-type="{{ $item->post_type }}" @if ($item->post_type == 'video') data-src="{{ static_asset($item->video->original) }}" @else data-src="{{ static_asset($item->audio[0]->original) }}" @endif data-title="{{ $item->title }}" data-sub_title="{{ $item->sub_title }}" data-date="{{ miladi_to_jalali($item->created_at, 1) }}">
                                            <a href="{{ url("media-albums?id=$item->id") }}">
                                                <div class="row my-1">
                                                    <div class="col-6 text-light" style="font-size: 12px;display: flex;flex-direction: column">
                                                        <div>
                                                            {{ $item->title }}
                                                        </div>
                                                        <div style="margin-top: 5px;color: #a99f9f">
                                                            <span>
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <span>
                                                                {{ miladi_to_jalali($item->created_at, 1) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="entry-header">
                                                            <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                                            @if ($item->post_type == 'video')
                                                                <div class="video-icon">
                                                                    <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon" style="width: 50px;opacity:0.8;">
                                                                </div>
                                                            @elseif($item->post_type == 'audio')
                                                                <div class="video-icon">
                                                                    <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon" style="width: 50px;opacity:0.8;">
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                        </div>

                    </div>

                </div>
            </div>

            {{-- ---------------------------------------------------- بخش دوم  --------------------------------------------- --}}

            <div id="bottom-section" style="width: 90%;margin: auto">
                <div class="row">
                    @foreach ($media_posts as $item)
                        <div class="col-sm-3 mb-4 media-item" data-type="{{ $item->post_type }}" @if ($item->post_type == 'video') data-src="{{ static_asset($item->video->original) }}" @else data-src="{{ static_asset($item->audio[0]->original) }}" @endif data-title="{{ $item->title }}" data-sub_title="{{ $item->sub_title }}" data-date="{{ miladi_to_jalali($item->created_at, 1) }}">
                            <a href="{{ url("media-albums?id=$item->id") }}">
                                <div class="entry-header">
                                    <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                    @if ($item->post_type == 'video')
                                        <div class="video-icon">
                                            <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                        </div>
                                    @elseif($item->post_type == 'audio')
                                        <div class="video-icon">
                                            <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                        </div>
                                    @endif
                                </div>
                                <div style="color: black;font-weight: 600">{{ $item->title }}</div>
                                <div style="text-align: left;color: #6c6c6c;font-size: 14px">{{ miladi_to_jalali($item->created_at, true) }}</div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <div style="width: 90%;margin: auto">
            <div class="alert alert-primary" role="alert">
                ویدئو یا صوتی جهت نمایش وجود ندارد
            </div>
        </div>
    @endif
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".media-item").click(function(e) {
                e.preventDefault();
                $(window).scrollTop($("#frame-box").offset().top - 50);
                var src = $(this).data('src');
                var img = $(this).find('img').attr('src');
                var type = $(this).data('type');
                var title = $(this).data('title');
                var sub_title = $(this).data('sub_title');
                var date = $(this).data('date');
                // console.log(img);
                $("#title").html(title);
                $("#sub-title").html(sub_title);
                if (type == 'video') {
                    var content = `
                                <div class="main-video-player">
                                    <div class="entry-header">
                                        <video id="main-video-player" src="${src}" controls width="100%"></video>
                                        <div style="color: white;padding: 3px;margin-top: 5px">
                                            <div style="text-align: left;font-size: 14px;color: #a99f9f;">
                                                <span><i class="fa fa-calendar"></i></span>
                                                <span>${date}</span>
                                            </div>
                                            <div>${title}</div>
                                            <div>${sub_title}</div>
                                        </div>
                                    <div>
                                </div>`;
                    $("#frame-box").html(content);
                    $("#main-video-player")[0].play();
                } else {
                    var content =
                        `<div class="main-audio-player">
                            <div class="entry-header">
                                <div style="position: relative">
                                    <img src="${img}" alt="" width="100%">
                                    <div style="position: relative">
                                        <audio id="main-audio-player" style="width:100%;position: absolute;bottom:0px" id="main-audio-player" src="${src}" controls></audio>
                                    </div>
                                </div>
                                <div style="color: white;padding: 3px;margin-top: 5px">
                                    <div style="text-align: left;font-size: 14px;color: #a99f9f;">
                                        <span><i class="fa fa-calendar"></i></span>
                                        <span>${date}</span>
                                    </div>
                                    <div>${title}</div>
                                    <div>${sub_title}</div>
                                </div>
                            </div>
                        </div>`;
                    $("#frame-box").html(content);
                    $("#main-audio-player")[0].play();
                }
            });
        });
    </script>
@endsection
