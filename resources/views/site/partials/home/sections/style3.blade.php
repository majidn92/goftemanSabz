@php
$posts = $section->posts->sortByDesc('created_at')->take(9);
$posts = $posts->values();
$count = $posts->count();
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

    <section id="section-{{ $section->id }}" target="_blank">
        <div style="width: 90%;margin: auto">
            @if ($section->ads && $center_top_ad)
                <div class="mt-2">
                    <a href="{{ $center_top_ad->url }}">
                        <img src="{{ url($center_top_ad->path) }}" style="height: 150px !important" alt="">
                    </a>
                </div>
            @endif
            <a href="{{ url("section/$section->id") }}">
                <h2 class="section-title" style="color:{{ $section->color }}">
                    {{ $section->name }}
                </h2>
            </a>
            <div class="section-box" style="border-top: solid {{ $section->color }}">
                <div class="row section-parent">
                    <div class="col-sm-4">
                        <a href="{{ route('article.detail', ['id' => $posts[0]->slug]) }}">
                            <div>
                                @if ($posts[0]->image)
                                    <img src="{{ static_asset($posts[0]->image->medium_image) }}" alt="">
                                @else
                                    <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                                @endif
                            </div>

                            {{-- <div class="pt-1" style="font-size: 13px">
                                <i class="fa fa-calendar"></i>
                                <span>{{ ago_time($posts[0]->created_at) }}</span>
                            </div> --}}
                            <div class="my-1 main-title">
                                {{ Str::limit($posts[0]->title, 150) }}
                            </div>
                            <div class="main-sub-title">
                                {{ Str::limit($posts[0]->sub_title, 190) }}
                            </div>
                        </a>
                    </div>
                    @php
                        if ($count > 1) {
                            $mid_posts = $posts->skip(1)->take(4);
                        } else {
                            $mid_posts = collect();
                        }
                    @endphp
                    @if ($mid_posts->count())
                        <div class="col-sm-4">
                            <div style="display: flex;flex-wrap: wrap">
                                @foreach ($mid_posts as $post)
                                    <div style="margin-bottom: 10px;display: flex;flex-wrap: wrap;align-items: center">
                                        <div style="width: 33%">
                                            @if ($post->image)
                                                <img src="{{ static_asset($post->image->medium_image) }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                                            @else
                                                <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                                            @endif
                                        </div>
                                        <div style="padding-right: 10px;width: 67%">
                                            <div class="main-title">
                                                <a class="main-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                    {{ Str::limit($post->title, 90) }}
                                                </a>
                                            </div>
                                            {{-- بابت حذف نویسنده خبر --}}
                                            {{-- <div>
                                                <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-user"></i> {{ $post->user->first_name }} {{ $post->user->last_name }}</span>
                                                <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-calendar"></i> {{ ago_time($post->created_at) }}</span>
                                            </div> --}}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @php
                        if ($count > 5) {
                            $left_posts = $posts->skip(5)->take(4);
                        } else {
                            $left_posts = collect();
                        }
                    @endphp
                    @if ($left_posts->count())
                        <div class="col-sm-4">
                            <div style="display: flex;flex-wrap: wrap">
                                @foreach ($left_posts as $post)
                                    <div style="margin-bottom: 10px;display: flex;flex-wrap: wrap;align-items: center">
                                        <div style="width: 33%">
                                            @if ($post->image)
                                                <img src="{{ static_asset($post->image->medium_image) }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                                            @else
                                                <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" style="border-radius: 5px;width: 100%;float: right">
                                            @endif
                                        </div>
                                        <div style="padding-right: 10px;width: 67%">
                                            <div class="main-title">
                                                <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                    {{ Str::limit($post->title, 50) }}
                                                </a>
                                            </div>
                                            <div>
                                                {{-- <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-user"></i> {{ $post->user->first_name }} {{ $post->user->last_name }}</span> --}}
                                                {{-- <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-calendar"></i> {{ ago_time($post->created_at) }}</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            @if ($section->ads && $center_ads->count())
                @include('site.partials.home.center_ads', ['color' => $section->color])
            @endif
        </div>
    </section>
@endif
