<a href="{{ url("state/$state->id") }}" target="_blank">
    <h2 class="section-title" style="color:{{ $section->color }}; @if($state->id == 16) font-size:.9em @endif">
        {{ $section->name }} : {{ $state->name }}
    </h2>
</a>
<a href="{{ url("states") }}" target="_blank" style="float:left">
    <h2 class="section-title" style="color:{{ $section->color }}">
        تمام استان ها
    </h2>
</a>
<div class="section-box" style="border-top: solid {{ $section->color }}">
    <div class="row">
        @foreach ($state_posts as $state_post)
            <div class="col-sm-3 mb-1">
                <div style="border-radius: 5px;box-shadow: 0 0 5px #ccc;position: relative;">
                    <a href="{{ route('article.detail', ['id' => $state_post->slug]) }}">
                        @if ($state_post->image)
                            <img src="{{ static_asset($state_post->image->medium_image) }}" alt="" style="border-radius: 5px">
                        @else
                            <img src="{{ static_asset('default-image/default-255x175.png') }}" width="100%" alt="">
                        @endif
                        {{-- <div class="p-2" style="font-size: 14px;font-weight: 700">
                            {{ Str::limit($state_post->title, 30) }}
                        </div> --}}
                        <div class="meta-title-post">
                            {!! \Illuminate\Support\Str::limit($state_post->title, 50) !!}
                        </div>
                    </a>
                </div>
            </div>
        @endforeach
    </div>
</div>
