@if ($featured_media->count())
    <style>
        audio {
            display: block
        }

        audio::-webkit-media-controls-enclosure {
            border-radius: 0px;
            background-color: var(--primary-color);
        }

        .other-video div::-webkit-scrollbar {
            width: 6px;
        }

        .other-video div::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        .other-video div::-webkit-scrollbar-thumb {
            background: var(--primary-color);
        }
    </style>
    <section style="background: {{ $section->color }};margin: 0;padding: 15px">
        <div style="width: 90%;margin: auto">
            <h2 class="section-title text-light">{{ $section->name }}</h2>
            <div class="section-box" style="border-top-color: white">
                <div class="row">
                    {{-- بخش اصلی نمایش فیلم یا صوت --}}
                    <div class="col-sm-9 text-center">
                        <div id="frame-box">
                            @if ($featured_media[0]->post_type == 'video')
                                <div class="entry-header entry-content" style="margin-bottom: 10px;position: relative;">
                                    <video id="main-dsp-video" src="{{ static_asset($featured_media[0]->video->original) }}" controls width="100%" poster=@php
                                        echo $featured_media[0]->image ? static_asset($featured_media[0]->image->medium_image) : static_asset('default-image/default-100x100.png');
                                    @endphp>
                                    </video>
                                    <div style="color: white;margin-top: 10px">
                                        <span id="title" style="font-weight: bold">
                                            {{ $featured_media[0]->title }}
                                        </span>
                                        <br>
                                        <span id="sub-title">
                                            {{ $featured_media[0]->sub_title }}
                                        </span>
                                    </div>
                                    <div class="video-icon">
                                        <img src="{{ static_asset('default-image/video-icon.svg') }} " alt="video-icon">
                                    </div>
                                </div>
                            @else
                                <div class="entry-header">
                                    <div style="position: relative">
                                        @if ($featured_media[0]->image)
                                            <img src="{{ static_asset($featured_media[0]->image->medium_image) }}" alt="">
                                        @else
                                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                        @endif
                                        <div style="position: relative">
                                            <audio style="width:100%;position: absolute;bottom:0px" id="main-audio-player" src="{{ static_asset($featured_media[0]->audio->original) }}" controls></audio>
                                        </div>
                                    </div>
                                    <div style="color: white;text-align: right;margin-top: 10px">
                                        <span id="title" style="font-weight: bold">
                                            {{ $featured_media[0]->title }}
                                        </span>
                                        <br>
                                        <span id="sub-title">
                                            {{ $featured_media[0]->sub_title }}
                                        </span>
                                    </div>
                                    <div class="video-icon">
                                        <img src="{{ static_asset('default-image/audio-icon.svg') }} " alt="audio-icon">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    {{-- نوار اسکرول بار کناری آخرین ویدئوها و صوت ها --}}
                    <div class="col-sm-3 text-center other-video">
                        <div style="height: 460px;overflow: auto">
                            @foreach ($featured_media as $i => $item)
                                <div class="last-media entry-header" style="margin-bottom: 5px;cursor:pointer" data-type="{{ $item->post_type }}" @if ($item->post_type == 'video') data-src="{{ static_asset($item->video->original) }}" @else data-src="{{ static_asset($item->audio->original) }}" @endif data-title="{{ $item->title }}" data-sub_title="{{ $item->sub_title }}">
                                    @if ($item->image)
                                        <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                    @else
                                        <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                    @endif
                                    <div class="entry-content" style="position: relative">
                                        <div class="meta-title-post">
                                            {{ $item->title }}
                                        </div>
                                    </div>
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
                            @endforeach
                        </div>
                        <a href="{{ url('media-albums') }}" target="_blank" class="show-more-btn">نمایش بیشتر</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
