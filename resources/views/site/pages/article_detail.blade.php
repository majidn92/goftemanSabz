@extends('site.layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ static_asset('site/css/plyr.css') }}" />
    <link rel="stylesheet" href="{{ static_asset('reaction/reaction.css') }}" />
    <link rel="stylesheet" href="{{ static_asset('reaction/reaction-2.css') }}" />
@endsection
@section('content')
    <div class="sg-page-content">
        <div class="container inner-detail-page" style="max-width: 90%">
            <div class="row margin-top-70">
                <div class="col-md-6 col-lg-6 sg-sticky">
                    <div class="theiaStickySidebar post-details">
                        <div class="sg-section">
                            <div class="section-content">
                                <div class="sg-post">
                                    @include('site.pages.article.style_2')
                                </div>
                                @if ($post->tags != null)
                                    <div class="sg-section mb-4">
                                        <div class="section-content">
                                            <div class="section-title">
                                                <h1>{{ __('tags') }}</h1>
                                            </div>

                                            <div class="tagcloud tagcloud-style-1">
                                                @if (!blank($tags = explode(',', $post->tags)))
                                                    @foreach ($tags as $tag)
                                                        <a href="{{ url('tags/' . $tag) }}">{{ $tag }}</a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (settingHelper('inbuild_comment') == 1)
                                    <div class="sg-section">
                                        <div class="section-content">
                                            <div class="section-title">
                                                <h1>نظر خود را درباره این خبر ثبت نمائید</h1>
                                            </div>
                                            <form id="post-comment" class="contact-form" name="contact-form" method="post" action="{{ route('article.save.comment') }}">
                                                @csrf
                                                <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="form-group" style="margin-bottom: 5px !important">
                                                            <textarea style="margin-bottom: 10px" name="comment" required="required" class="form-control" rows="7" id="four" placeholder="نظر خود را وارد نمائید ..."></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group" style="margin-bottom: 6px">
                                                    @if (Cartalyst\Sentinel\Laravel\Facades\Sentinel::check())
                                                        <button type="submit" class="btn btn-primary">{{ __('send') }} {{ __('comment') }}</button>
                                                    @else
                                                        <a class="btn btn-primary" href="{{ route('site.login.form') }}">{{ __('send') }}</a>
                                                    @endif
                                                </div>
                                            </form>
                                            <div id="comment-box" style="text-align: center"></div>
                                        </div>
                                    </div>

                                    @if (!blank($comments = data_get($post, 'comments')))
                                        <div class="sg-section">
                                            <div class="section-content">
                                                <div class="sg-comments-area">
                                                    <div class="section-title">
                                                        <h1>{{ __('comments') }}</h1>
                                                    </div>
                                                    @include('site.post.comment', ['comments' => $comments])
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif

                                @if (settingHelper('facebook_comment') == 1)
                                    <div class="fb-comments" data-href="{{ url()->current() }}" data-numposts="5" data-width="100%"></div>
                                @endif

                                @if (settingHelper('disqus_comment') == 1)
                                    <!-- disqus comments -->
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div id="disqus_thread"></div>
                                            <script>
                                                var disqus_config = function() {
                                                    this.page.url = "{{ url()->current() }}"; // Replace PAGE_URL with your page's canonical URL variable
                                                    this.page.identifier = "{{ $post->id }}"; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
                                                };

                                                (function() { // DON'T EDIT BELOW THIS LINE
                                                    var d = document,
                                                        s = d.createElement('script');
                                                    s.src = 'https://{{ settingHelper('disqus_short_name') }}.disqus.com/embed.js';
                                                    s.setAttribute('data-timestamp', +new Date());
                                                    (d.head || d.body).appendChild(s);
                                                })();
                                            </script>
                                            <noscript><a href="https://disqus.com/?ref_noscript"></a></noscript>
                                            <script id="dsq-count-scr" src="//{{ settingHelper('disqus_short_name') }}.disqus.com/count.js" async></script>
                                        </div>
                                    </div>
                                    <!-- END disqus comments -->
                                @endif


                                @if (!blank($relatedPost))
                                    <div class="sg-section">
                                        <div class="section-content">
                                            <div class="mb-2" style="border-radius: 4px">
                                                <div style="background-color: var(--primary-color);color:white;padding: 5px;margin-bottom: 10px">اخبار مرتبط</div>
                                                <ul class="pr-2 box-background">
                                                    @foreach ($relatedPost as $post)
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
                                                            <li style="font-size: 13px;list-style-type: none;padding-bottom:2px;display: inline">
                                                                <a href="{{ route('article.detail', ['id' => $post->slug]) }}" target="_blank">
                                                                    {{ Str::limit($post->title, 150) }}
                                                                </a>
                                                                {{-- @if ($post->post_type == 'rss')
                                                                    <span style="color: #a99f9f">{{ $post->feed }}</span>
                                                                @else
                                                                    <span style="color: #a99f9f">{{ env('APP_NAME') }}</span>
                                                                @endif --}}
                                                                {{-- حذف زمان --}}
                                                                {{-- <span style="color: #a99f9f">--{{ ago_time($post->created_at) }}</span> --}}
                                                            </li>
                                                        </div>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 sg-sticky">
                    <div class="sg-sidebar theiaStickySidebar">
                        @include('site.partials.right_sidebar_widgets')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <input type="hidden" id="url" value="{{ url('/') }}">
    <input type="hidden" id="post_id" value="{{ $post->id }}">
@endsection

@section('player')
    <script src="{{ static_asset('site/js') }}/plyr.js"></script>
    <script src="{{ static_asset('site/js') }}/plyr_ini.js"></script>
@endsection

@section('script')
    <script>
        $(".emoji-2").on("click", function() {
            var url = $('#url').val();

            $('[data-toggle="tooltip"]').tooltip();

            var formData = {
                data_reaction: $(this).attr("data-reaction"),
                id: $('#post_id').val()
            };

            // get section for student
            $.ajax({
                type: "GET",
                data: formData,
                dataType: 'json',
                url: url + '/' + 'post/reaction',
                success: function(data) {

                    console.log(data['reactions']);
                    console.log(data['is_you']);

                    if (data['total'] == 0) {

                        $('.like-details').html('Like');

                    } else if (data['is_you'] != null) {

                        var total = data['total'] - 1;

                        $('.like-details').html(' you and ' + total + ' others');

                    } else {

                        $('.like-details').html(data['total'] + ' others');

                    }

                    console.log(data['is_you']);

                    if (data['is_you'] == null || data['is_you']['data_reaction'] == 'Like') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-like');
                    } else if (data['is_you']['data_reaction'] == 'Love') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-love');
                    } else if (data['is_you']['data_reaction'] == 'HaHa') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-haha');
                    } else if (data['is_you']['data_reaction'] == 'Wow') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-wow');
                    } else if (data['is_you']['data_reaction'] == 'Sad') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-sad');
                    } else if (data['is_you']['data_reaction'] == 'Angry') {
                        $('.like-emo span').removeAttr('class');
                        $('.like-emo span').attr('class', 'like-btn-angry');
                    }

                    jQuery.each(data['reactions'], function(key, val) {

                        if (key == "Like") {
                            $('.emo-like-2').attr('data-original-title', 'Like ' + val);
                        }
                        if (key == "Love") {
                            $('.emo-love-2').attr('data-original-title', 'Love ' + val);
                        }
                        if (key == "HaHa") {
                            $('.emo-haha-2').attr('data-original-title', 'HaHa ' + val);
                        }
                        if (key == "Wow") {
                            $('.emo-wow-2').attr('data-original-title', 'Wow ' + val);
                        }
                        if (key == "Sad") {
                            $('.emo-sad-2').attr('data-original-title', 'Sad ' + val);
                        }
                        if (key == "Angry") {
                            $('.emo-angry-2').attr('data-original-title', 'Angry ' + val);
                        }

                    });


                    var reactions = ['Like', 'Love', 'HaHa', 'Wow', 'Sad', 'Angry'];

                    jQuery.each(reactions, function(key, val) {

                        if (!data['reactions'].hasOwnProperty(val)) {
                            $('.emo-' + val.toLowerCase() + '-2').attr('data-original-title', val + ' 0');
                        }

                    });

                    $('[data-toggle="tooltip"]').tooltip();


                },
                error: function(data) {
                    // console.log('Error:', data);
                }
            });
        });

        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    <script src="{{ url('public/js/printThis.js') }}"></script>
    <script>
        // $("#print_post").on("click", function() {
        //     $(" .post-content .post-image, .post-content .post-summary ,  .post-content .title, .post-content .post-player img , .post-content .post-text ").printThis({
        //         importCSS: false,
        //         loadCSS: "<?= url('assets/css/print.css') ?>",
        //         header: "",
        //     })
        // });

        $(".print").click(function(e) {
            e.preventDefault();
            $('.on-title ,.title ,.sub-title , .img-print , .paragraph').printThis({
                importCSS: false,
                loadCSS: "{{ url('public/css/majid-print.css') }}",
                header: "<h1>پایگاه خبری اخبار ساخته ها</h1><div style='direction:ltr;text-align:left'><img src='{{ static_asset(settingHelper('logo')) }}' width='200px' height='auto'></div><div style='margin-top:-100px'><div>کد خبر {{ $post->id }}</div><div>تاریخ {{ miladi_to_jalali($post->created_at) }}</div><div>نویسنده {{ $post->user->first_name }} {{ $post->user->last_name }}</div></div>"
            });
        });
    </script>
    <script>
        $(".comment-reply").click(function(e) {
            $(this).parents(".comment-box").find("form").toggle();
        });

        $("form.form-reply").submit(function(e) {
            e.preventDefault();
            var src = "{{ static_asset('default-image/loading.gif') }}";
            var container_message = $(this).siblings(".loading-tag-container");
            var loading_tag = `<img src="${src}" width="150" height="auto">`;
            container_message.html(loading_tag);
            $(this).hide();
            let myform = $(this)[0];
            let fd = new FormData(myform);

            $.ajax({
                url: "{{ route('article.save.reply') }}",
                type: 'POST',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'success') {
                        container_message.html('<div class="alert alert-success" role="alert" style="text-align: center;font-size: 14px">نظر شما ثبت شد و پس از تائید نمایش داده خواهد شد</div>');
                        setTimeout(
                            function() {
                                $(".alert").slideUp(1000)
                            }, 2500);
                    }
                }
            });
            elem = $(this).find('textarea');
            elem.val('');
        });

        $(".display-reply").click(function(e) {
            e.preventDefault();
            $(this).parents(".comment-box").siblings("ul.children.global-list").slideToggle(1000);

        });

        $("#post-comment").submit(function(e) {
            e.preventDefault();
            // alert(77);
            var myForm = $(this)[0];
            var fd = new FormData(myForm);
            var src = "{{ static_asset('default-image/loading.gif') }}";
            var loading_tag = `<img src="${src}" width="150" height="auto">`;
            $("#comment-box").html(loading_tag);
            $(this).hide();
            console.log($("#comment-box"));
            // return false;
            $.ajax({
                url: "{{ route('article.save.comment') }}",
                type: 'POST',
                data: fd,
                cache: false,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.status == 'success') {
                        $("#comment-box").html('<div class="alert alert-success" role="alert" style="text-align: center;font-size: 14px">نظر شما ثبت شد و پس از تائید نمایش داده خواهد شد</div>');
                        setTimeout(
                            function() {
                                $(".alert").slideUp(1000)
                            }, 2500);
                    }
                }
            });
            $(this).show();
        });

        $(".short-link").click(function() {
            let link = $(this).data('link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(link).select();
            document.execCommand("copy");
            $temp.remove();
            $(".link-msg").show();
            setTimeout(
                function() {
                    $(".link-msg").hide();
                }, 4000);
        });
    </script>
@endsection
