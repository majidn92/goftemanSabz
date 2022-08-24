@php
$posts = $section->posts->sortByDesc('created_at')->take(15);
$posts = $posts->values();
$center_ads = $section->center_ads
    ->where('top', 0)
    ->sortBy('rank')
    ->take(6);
$center_top_ad = $section->center_ads->where('top', 1)->first();
@endphp

@if ($posts->count())
    <style>
        #section-{{ $section->id }} a:hover {
            color: {{ $section->color }}
        }
    </style>

    <section id="section-{{ $section->id }}">
        <div style="width: 90%;margin: auto">
            @if ($section->ads && $center_top_ad)
                <div class="mt-2">
                    <a href="{{ $center_top_ad->url }}">
                        <img src="{{ url($center_top_ad->path) }}" style="height: 150px !important" alt="">
                    </a>
                </div>
            @endif
            <a href="{{ url("section/$section->id") }}" target="_blank">
                <h2 class="section-title" style="color:{{ $section->color }}">{{ $section->name }}</h2>
            </a>
            <div class="section-box" style="border-top: solid {{ $section->color }}">
                <div class="row">
                    <div class="col-sm-7">
                        <div class="row">
                            @php
                                $right_posts = $posts->take(3);
                            @endphp
                            @foreach ($right_posts as $item)
                                <div class="col-sm-4">
                                    <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                        <div>
                                            @if ($item->image)
                                                <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                            @else
                                                <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                            @endif
                                        </div>
                                        {{-- <div class="pt-1" style="font-size: 13px">
                                            <i class="fa fa-calendar"></i>
                                            <span>{{ ago_time($item->created_at) }}</span>
                                        </div> --}}
                                        <div class="my-1 main-title">
                                            {{ Str::limit($item->title, 59) }}
                                        </div>
                                        <div class="main-sub-title">
                                            {{ Str::limit($item->sub_title, 114) }}
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="col-sm-5">
                        <ul class="box-background" style="list-style-type: none">
                            @php
                                if ($posts->count() > 3) {
                                    $left_posts = $posts->skip(3)->take(7);
                                } else {
                                    $left_posts = collect();
                                }
                            @endphp
                            @foreach ($left_posts as $item)
                                <div>
                                    @switch($item->post_type)
                                        @case('video')
                                            <i class="fa fa-file-video-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @case('audio')
                                            <i class="fa fa-file-audio-o" style="color: {{ $section->color }}"></i>
                                        @break

                                        @default
                                            <i class="fa fa-file-text-o" style="color: {{ $section->color }}"></i>
                                    @endswitch
                                    <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display:inline;line-height: 30px">
                                        <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $item->slug]) }}">{{ Str::limit($item->title, 82) }}</a>
                                    </li>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @if ($section->ads && $center_ads->count())
                @include('site.partials.home.center_ads', ['color' => $section->color])
            @endif
        </div>
    </section>
@endif
