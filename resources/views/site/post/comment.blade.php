<style>
    textarea::placeholder {
        font-size: 14px
    }

</style>

<ul class="@if (isset($is_children) && $is_children) children @else comment-list @endif global-list">
    @foreach ($comments as $comment)
        @php
            // dd($comment->comment)
        @endphp
        <li class="media">
            <div class="commenter-avatar">
                @if ($profile_image = data_get($comment, 'user.profile_image'))
                    <a href="#"><img class="img-fluid" src="{{ static_asset($profile_image) }}" alt="Image"></a>
                @else
                    <a href="#"><img class="img-fluid" src="{{ static_asset('default-image/user.jpg') }}" alt="Image"></a>
                @endif
            </div>
            <div class="comment-box media-body">
                <div class="comment-meta" style="color: #757575">
                    <span class="title"><a href="#" class="url" style="color: var(--primary-color);font-size: 14px">{{ data_get($comment, 'user.first_name') }} {{ data_get($comment, 'user.last_name') }}</a></span>
                    <span style="font-size: 12px">{{ $diff = Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</span>
                    @if ($comment->reply->count() && !(isset($is_children) && $is_children))
                        <span style="font-size: 12px">-- {{ $comment->reply->count() }} پاسخ</span>
                    @endif
                    @if (!(isset($is_children) && $is_children))
                        <span class="comment-reply" style="font-size: 12px;float: left;cursor: pointer;">
                            <i class="fa fa-reply ml-1"></i>
                            پاسخ
                        </span>
                    @endif
                </div>
                <div class="comment-content">
                    <p style="font-size: 15px">{{ $comment->comment ?? '' }}</p>
                </div>
                <form id="majid-form" class="form-reply" class="contact-form" style="display: none" name="contact-form" method="post" action="{{ route('article.save.reply') }}">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $comment->post_id ?? '' }}">
                    <input type="hidden" name="comment_id" value="{{ $comment->id }}">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <textarea name="comment" rows="5" class="form-control text-area" id="one" placeholder="نظر خود را وارد نمائید"></textarea>
                                <button type="submit" class="btn btn-primary submit-comment-btn" style="position: absolute; bottom: 35px;left: 20px;">{{ __('reply') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="loading-tag-container" style="text-align: center;"></div>
                @if ($comment->reply->count() && !(isset($is_children) && $is_children))
                    <span class="display-reply" style="font-size: 14px;cursor: pointer;color:var(--primary-color)">
                        مشاهده پاسخ ها &#9662;
                    </span>
                @endif
            </div>


            @if (!blank($reply = data_get($comment, 'reply')->reverse()))
                @include('site.post.comment', [
                    'comments' => $reply,
                    'is_children' => true,
                ])
            @endif
        </li>
    @endforeach
</ul>
