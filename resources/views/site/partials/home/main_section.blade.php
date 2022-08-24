<style>
    #side-ads::-webkit-scrollbar {
        width: 6px;
    }

    #side-ads::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey;
    }

    #side-ads::-webkit-scrollbar-thumb {
        background: var(--primary-color);
    }
</style>

<div style="width: 90%;margin: auto">
    <div class="section-box container-section" style="border-top: unset">
        <div class="row m-0">
            {{-- -----------------بخش اول--------------------- نمایش بخش اسلایدر ------------------------------------------------- --}}
            <div class="col-sm-10">
                <div class="sg-home-section mb-3">
                    <div class="row">
                        <div class="col-lg-6 p-0">
                            <div class="post-slider">
                                @if ($slider_posts->count())
                                    @foreach ($slider_posts as $post)
                                        <div class="sg-post featured-post">
                                            @include('site.partials.home.primary.slider')
                                            {{-- <div class="entry-content absolute">
                                                <div class="category">
                                                    <ul class="global-list">
                                                        @isset($post->category->category_name)
                                                            <li>
                                                                <a href="{{ url('category', $post->category->slug) }}" target="_blank">{{ $post->category->category_name }}</a>
                                                            </li>
                                                        @endisset
                                                    </ul>
                                                </div>
                                                <h2 class="entry-title">
                                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">{!! \Illuminate\Support\Str::limit($post->title, 50) !!}</a>
                                                </h2>
                                                <div class="entry-meta">
                                                    <ul class="global-list">
                                                        <li>
                                                            <a href="{{ route('site.author', ['id' => $post->user->id]) }}" target="_blank">{{ data_get($post, 'user.first_name') }} {{ data_get($post, 'user.last_name') }}</a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ route('article.date', date('Y-m-d', strtotime($post->updated_at))) }}">{{ miladi_to_jalali($post->updated_at) }}</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div> --}}

                                            <div class="meta-title-post">
                                                <div class="category">
                                                    <ul class="global-list">
                                                        @isset($post->category->category_name)
                                                            <li>
                                                                <a href="{{ url('category', $post->category->slug) }}" target="_blank">{{ $post->category->category_name }}</a>
                                                            </li>
                                                        @endisset
                                                    </ul>
                                                </div>
                                                <h2 class="entry-title" style="padding-top: 8px">
                                                    <a class="main-title" style="color: white;font-size: 20px" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                        {!! \Illuminate\Support\Str::limit($post->title, 250) !!}
                                                    </a>
                                                </h2>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div style="border-radius: 4px">
                                <div>
                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation" style="width: 33.3%;text-align: center">
                                            <a class="nav-link active" id="last-posts-tab" data-toggle="tab" href="#last-posts" role="tab" aria-controls="last-posts" aria-selected="true">
                                                <span class="desktop-view">آخرین اخبار</span>
                                                <span class="mobile-view">آخرین</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation" style="width: 33.3%;text-align: center">
                                            <a class="nav-link" id="populare-posts-tab" data-toggle="tab" href="#populare-posts" role="tab" aria-controls="populare-posts" aria-selected="false">
                                                <span class="desktop-view">اخبار پربازدید</span>
                                                <span class="mobile-view">پربازدید</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation" style="width: 33.3%;text-align: center">
                                            <a class="nav-link" id="other-posts-tab" data-toggle="tab" href="#other-posts" role="tab" aria-controls="other-posts" aria-selected="false">
                                                <span class="desktop-view">سایر اخبار</span>
                                                <span class="mobile-view">سایر</span>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="myTabContent" style="padding-top: 15px;padding-bottom: 10px;padding-right: 5px">
                                        {{-- ---------------------------------------------------------آخرین اخبار ---------------------------------------------------- --}}
                                        <div class="tab-pane fade show active box-background" id="last-posts" role="tabpanel" aria-labelledby="last-posts-tab">
                                            @if ($last_posts->count())
                                                @foreach ($last_posts as $post)
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
                                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display:inline">
                                                            <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                                {{ Str::limit($post->title, 98) }}
                                                            </a>
                                                        </li>

                                                        {{-- comment by majid molaea --}}
                                                        {{-- @if ($post->rss)
                                                            <span style="font-size: 13px;padding: 4px;float: left;">
                                                                {{ $post->feed }}
                                                            </span>
                                                        @else
                                                            <span style="font-size: 13px;padding: 4px;float: left;">
                                                                {{ env('APP_NAME') }}
                                                            </span>
                                                        @endif --}}
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- -------------------------------------------------- اخبار پربازدید --------------------------------------------------------------- --}}
                                        <div class="tab-pane fade box-background" id="populare-posts" role="tabpanel" aria-labelledby="profile-tab">
                                            @if ($populare_posts->count())
                                                {{-- {{dd($populare_posts)}} --}}
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
                                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display:inline">
                                                            <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                                {{ Str::limit($post->title, 98) }}
                                                                {{-- @if ($post->rss)
                                                                {{ $post->feed }}
                                                            @else
                                                                {{ env('APP_NAME') }}
                                                            @endif --}}
                                                            </a>
                                                        </li>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                        {{-- -------------------------------------------------- سایر اخبار --------------------------------------------------------------- --}}
                                        <div class="tab-pane fade box-background" id="other-posts" role="tabpanel" aria-labelledby="other-posts-tab">
                                            @if ($other_posts->count())
                                                @foreach ($other_posts as $post)
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
                                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display:inline">
                                                            <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                                {{ Str::limit($post->title, 98) }}
                                                            </a>
                                                            {{-- @if ($post->rss)
                                                                {{ $post->feed }}
                                                            @else
                                                                {{ env('APP_NAME') }}
                                                            @endif --}}
                                                        </li>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- ------------------------------- نمایش بخش تبلیغات کناری -------------------------------- --}}
            <div id="side-ads" class="col-sm-2 text-center p-0">
                <style>
                    img {
                        height: unset;
                    }
                </style>
                @if ($side_ads->count())
                    @foreach ($side_ads as $item)
                        <div class="mb-1">
                            <a href="{{ $item->url }}" target="_blank">
                                <img src="{{ url($item->path) }}" style="height: 100px;width:100%">
                            </a>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>

        {{-- ------------------------------------------- ویژه ها-------------------------------- --}}

        @if ($featured_posts->count())
            <div class="row mt-2">
                @foreach ($featured_posts as $post)
                    <div class="col-sm-3 mb-1">
                        <div style="position: relative">
                            <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                @if (isFileExist(@$post->image, $result = @$post->image->medium_image))
                                    <img src="{{ safari_check() ? basePath(@$post->image) . '/' . $result : static_asset('default-image/default-358x215.png') }} " data-original=" {{ basePath(@$post->image) }}/{{ $result }} " class="img-fluid lazy" alt="{!! $post->title !!}" style="width: 100%">
                                @else
                                    <img src="{{ static_asset('default-image/default-358x215.png') }} " class="img-fluid" alt="{!! $post->title !!}">
                                @endif
                                <div class="meta-title-post">
                                    {!! \Illuminate\Support\Str::limit($post->title, 200) !!}
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
        {{-- ------- بخش دوم ------ --}}
        <div class="row mt-4">
            {{-- ------------------------------------------- اتاق گفتگو -------------------------------- --}}
            @if ($chat_room_posts->count())
                <div class="col-sm-4">
                    <div style="border-radius: 4px">
                        <span style="font-weight: 600;color:var(--primary-color)">اتاق گفتگو</span>
                        <div style="border-top: solid var(--primary-color);border-radius: 5px;padding-top: 15px;margin-top: 7px">
                            <ul id="populare-section" class="box-background">
                                <a href="{{ route('article.detail', ['id' => $chat_room_posts[0]->slug]) }}" target="_blank">
                                    <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                        @if ($chat_room_posts[0]->image)
                                            <img src="{{ static_asset($chat_room_posts[0]->image->medium_image) }}" alt="" width="100%">
                                        @else
                                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="" width="100%">
                                        @endif
                                        <div class="meta-title-post">
                                            {!! \Illuminate\Support\Str::limit($chat_room_posts[0]->title, 150) !!}
                                        </div>
                                    </div>
                                </a>
                                @foreach ($chat_room_posts as $i => $post)
                                    @php
                                        if ($i == 0) {
                                            continue;
                                        }
                                    @endphp
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
                                        <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display:inline;line-height: 25px">
                                            <a class="main-leanier-title" href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                {{ Str::limit($post->title, 50) }}
                                            </a>
                                            {{-- @if ($post->rss)
                                                {{ $post->feed }}
                                            @else
                                                {{ env('APP_NAME') }}
                                            @endif --}}
                                            {{-- حذف زمان از صفحه اصلی --}}
                                            {{-- --<span style="color: #a99f9f">{{ ago_time($post->created_at) }}</span> --}}
                                        </li>
                                    </div>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif
            {{-- ---------------------------------- ویژه نگار  ----------------------------------------- --}}
            @if ($persons_of_day->count())
                <div class="col-sm-4">
                    <div style="border-radius: 4px">
                        <span style="font-weight: 600;color:var(--primary-color)">ویژه نگار</span>
                        <div class="person-slick" style="border-top: solid var(--primary-color);border-radius: 5px;padding-top: 15px;margin-top: 7px">
                            @foreach ($persons_of_day as $person_of_day)
                                <a href="{{ route('article.detail', ['id' => $person_of_day->slug]) }}" target="_blank">
                                    <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                        @if ($person_of_day->image)
                                            <img src="{{ static_asset($person_of_day->image->medium_image) }}" alt="" style="height: 384px">
                                        @else
                                            <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                        @endif
                                        <div class="entry-content" style="margin-bottom: 10px;position: relative">
                                            <div class="meta-title-post" style="font-size: 24px;padding: 60px 10px;text-shadow: 0 0 40px black">
                                                {!! \Illuminate\Support\Str::limit($person_of_day->title, 200) !!}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- ------------------------------------ دیدگاه ---------------------------------------- --}}
            @if ($opinions->count())
                <div class="col-sm-4">
                    <div style="border-radius: 4px">
                        <span style="font-weight: 600;color:var(--primary-color)">دیدگاه</span>
                        <div style="border-top: solid var(--primary-color);border-radius: 5px;padding-top: 15px;margin-top: 7px">
                            @foreach ($opinions as $opinion)
                                <a href="{{ route('article.detail', ['id' => $opinion->slug]) }}" target="_blank">
                                    <div style="margin-bottom: 10px;display: flex;align-items: center">
                                        <div style="width: 30%">
                                            @if ($opinion->user->profile_image)
                                                <img src="{{ static_asset($opinion->user->profile_image) }}" alt="" style="border-radius: 50%;width: 85px;height: 85px;float: right;max-width: unset !important;">
                                            @else
                                                <img src="{{ static_asset('default-image/user.jpg') }}" alt="" style="border-radius: 50%;width: 85px;height: 85px;float: right;max-width: unset !important;">
                                            @endif
                                        </div>
                                        <div>
                                            <div class="main-title">
                                                {{ Str::limit($opinion->title, 100) }}
                                            </div>
                                            <div>
                                                <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-user"></i> {{ $opinion->user->first_name }} {{ $opinion->user->last_name }}</span>
                                                {{-- <span style="color: #a99f9f;font-size: 13px"><i class="fa fa-calendar"></i> {{ ago_time($opinion->created_at) }}</span> --}}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
            {{-- ------------------ بخش چهارم--------------------  نمایش بخش تبلیغات میانی ------------------ --}}
            @if ($center_ads->count() && $section)
                <div class="col-sm-12">
                    @include('site.partials.home.center_ads', ['color' => 'var(--primary-color)'])
                </div>
            @endif
        </div>
    </div>
</div>
