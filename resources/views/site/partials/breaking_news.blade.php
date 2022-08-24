<div class="sg-breaking-news">
    <div class="container">
        <div class="breaking-content d-flex">
            {{-- <span>{{ __('breaking_news') }}</span> --}}
            <ul class="news-ticker">
            	@foreach($breaking_news as $item)
                    <li><a href="{{ route('article.detail', [$item->slug]) }}" @isset($section) style="color:{{$section->color}} " @endisset>{{$item->title}}</a></li>
                @endforeach
            </ul><!-- #ticker -->
        </div><!-- /.breaking-content -->
    </div><!-- /.container -->
</div>
