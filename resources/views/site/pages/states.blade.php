@extends('site.layouts.app')

@section('content')
    <div style="width: 90%;margin: auto">
        <div class="row mb-3">
            <div class="col-sm-12">
                <h2 style="color: var(--primary-color);font-weight: 600;margin-top: 15px">آخرین اخبار استان ها</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($states as $state)
                @php
                    $state_posts = $state->posts->sortByDesc('created_at')->take(5);
                @endphp
                @if ($state_posts->count())
                    <div class="col-sm-4 bg-light mb-2 p-2">
                        <div class="container">
                            <div class="row ml-0" style="border-bottom: solid 2px var(--primary-color)">
                                <a href="{{ url("state/$state->id") }}">
                                    <span style="background: var(--primary-color);color:white;padding: 3px;font-size: 12px">{{ $state->name }}</span>
                                </a>
                            </div>
                            <div style="border-left: solid 2px var(--primary-color);padding-left: 15px">
                                @foreach ($state_posts as $item)
                                    <a href="{{ route('article.detail', ['id' => $item->slug]) }}">
                                        <div class="row mb-1 p-1" style="background: white">
                                            <div class="col-sm-6 px-1" style="font-weight: 600;font-size: 14px">
                                                {{ \Illuminate\Support\Str::limit($item->title, 60) }}
                                            </div>
                                            <div class="col-sm-6 px-1">
                                                @if ($item->image)
                                                    <img src="{{ static_asset($item->image->medium_image) }}" alt="">
                                                @else
                                                    <img src="{{ static_asset('default-image/default-255x175.png') }}" alt="">
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
