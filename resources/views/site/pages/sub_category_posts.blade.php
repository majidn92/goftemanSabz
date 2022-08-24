@extends('site.layouts.app')

@section('content')
    <div class="sg-main-content mb-4">
        <div style="width: 90%;margin: auto">
            <div>
                <h2 class="category-title" style="color: var(--primary-color);font-weight: 600;margin-top: 15px">
                    {{ $category->category_name }}/ {{ $sub_category->sub_category_name }}
                </h2>
            </div>
            @include('site.partials.header_inner_page')
            <div class="row container-section">
                <div class="col-md-6 sg-sticky inner-subcategory-page">
                    <div class="theiaStickySidebar">
                        <div class="sg-section">
                            <div class="section-content">
                                <div class="latest-post-area">
                                    @php
                                        $posts = $posts->skip(7)->take(99999);
                                    @endphp
                                    @foreach ($posts as $post)
                                        <div class="sg-post medium-post-style-1">
                                            <div class="entry-header">
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
                                            {{-- <div class="category">
                                                <ul class="global-list">
                                                    @isset($post->category->category_name)
                                                        <li><a href="{{ url('category', $post->category->slug) }}">{{ $post->category->category_name }}</a></li>
                                                    @endisset
                                                </ul>
                                            </div> --}}
                                            <div class="entry-content align-self-center">
                                                <h3 class="entry-title">
                                                    <a href="{{ route('article.detail', ['id' => $post->slug]) }}">
                                                        {{ \Illuminate\Support\Str::limit($post->title, 65) }}
                                                    </a>
                                                </h3>
                                                {{-- حذف بابت عدم نمایش زمان و نویسنده خبر --}}
                                                {{-- <div class="entry-meta mb-2">
                                                    <ul class="global-list">
                                                        <li>{{ __('post_by') }} <a href="{{ route('site.author', ['id' => $post->user->id]) }}">{{ $post->user->first_name }} </a></li>
                                                        <li><a href="{{ route('article.date', date('Y-m-d', strtotime($post->updated_at))) }}"> {{ $post->updated_at->format('F j, Y') }}</a></li>
                                                    </ul>
                                                </div> --}}
                                                <p>{{ \Illuminate\Support\Str::limit($post->sub_title, 150) }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($posts->count() != 0)
                                    <input type="hidden" id="last_id" value="1">
                                    <input type="hidden" id="sub_category_id" value="{{ $id }}">
                                    <div class="col-sm-12 col-xs-12 d-none" id="latest-preloader-area">
                                        <div class="row latest-preloader">
                                            <div class="col-md-7 offset-md-5">
                                                <img src="{{ static_asset('site/images/') }}/preloader-2.gif" alt="Image" class="tr-preloader img-fluid">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">
                                        <div class="row">
                                            <button class="btn-load-more {{ $totalPostCount > 6 ? '' : 'd-none' }}" id="btn-load-more-subcategory"> {{ __('load_more') }} </button>
                                            <button class="btn-load-more {{ $totalPostCount > 6 ? 'd-none' : '' }}" id="no-more-data">
                                                {{ __('no_more_records') }} </button>
                                            <input type="hidden" id="url" value="{{ url('') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>


                    </div>
                </div>
                <div class="col-md-6 sg-sticky">
                    <div class="sg-sidebar theiaStickySidebar">
                        @include('site.partials.right_sidebar_widgets')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
