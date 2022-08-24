<div class="entry-header">
    <div class="entry-thumbnail" height="100%">
        @include('site.pages.article.partials.detail_image')
    </div>
</div>


<div class="entry-content p-4">
    <h3 class="entry-title">{!! $post->title ?? '' !!}</h3>
    <div class="entry-meta mb-2">
        <ul class="global-list">
            <li>
                <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                <a href="{{ route('article.date', date('Y-m-d', strtotime($post->updated_at))) }}">{{ miladi_to_jalali($post->updated_at) }}</a>
            </li>
        </ul>
    </div>
    @if (@$post->post_type == 'audio')
        @include('site.pages.article.partials.audio')
    @endif
    <div class="paragraph">
        {!! $post->content !!}
    </div>
    @if (isset($post->read_more_link))
        <div class="rss-content-actual-link mb-2">
            <a href="{{ url("rss/$post->id") }}" class="btn btn-primary" target="_blank">متن کامل خبر</a>
        </div>
    @endif
    @include('site.pages.article.partials.content')
    @if (settingHelper('adthis_option') == 1 and settingHelper('addthis_public_id') != null and settingHelper('addthis_toolbox') != null)
        {!! base64_decode(settingHelper('addthis_toolbox')) !!}
    @endif

    @if (@$post->post_type == 'trivia-quiz')
        @include('site.pages.article.partials.trivia-quiz')
    @endif
    @if (@$post->post_type == 'personality-quiz')
        @include('site.pages.article.partials.personality-quiz')
    @endif

    @if (@$post->user->permissions['author_show'] == 1)
        @include('site.pages.article.partials.author')
    @endif

</div>
