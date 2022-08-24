<div class="sg-widget">
    <h3 class="widget-title">{{ data_get($detail, 'title') }}</h3>

    <ul class="global-list">
        @foreach($content as $post)
            <li>
                <div class="sg-post small-post post-style-1">
                    @include('site.partials.home.category.post_block')
                    <div class="entry-content">
                       <a href="{{ route('article.detail', ['id' => $post->slug]) }}"> <p>{{ \Illuminate\Support\Str::limit(data_get($post, 'title'), 25) }}</p></a>
                        <div class="entry-meta">
                            <ul class="global-list">
                                <li class="d-sm-none d-md-none d-lg-block">{{ __('post_by') }}<a href="{{ route('site.author',['id' => $post->user->id]) }}"> {{ data_get($post, 'user.first_name') }} {{ data_get($post, 'user.last_name') }}</a></li>
                                <li><a href="{{route('article.date', date('Y-m-d', strtotime($post->updated_at)))}}"> {{ miladi_to_jalali($post->updated_at) }}</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
</div>
