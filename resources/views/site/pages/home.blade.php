@extends('site.layouts.app')

@section('content')
    @include('site.partials.home.main_section', ['section' => false])
    {{-- @if ($_ENV['DSP'] == 1) --}}
    @if (1)
        @if ($hoghooghi_profiles->count())
            @include('site.partials.home.sections.hoghooghi_profile')
        @endif
        @if ($haghighi_profiles->count())
            @include('site.partials.home.sections.haghighi_profile')
        @endif
    @endif
    @foreach ($sections as $section)
        @include("site.partials.home.sections.$section->style")
    @endforeach
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".last-media").click(function(e) {
                var src = $(this).data('src');
                var img = $(this).find('img').attr('src');
                var type = $(this).data('type');
                var title = $(this).data('title');
                var sub_title = $(this).data('sub_title');
                $("#title").html(title);
                $("#sub-title").html(sub_title);
                if (type == 'video') {
                    var content = `
                            <div class="entry-content" style="margin-bottom: 10px;position: relative;">
                                <video id="main-video-player" src="${src}" poster="${img}" controls width="100%"></video>
                                <div style="color: white;margin-top: 10px">
                                    <span id="title" style="font-weight: bold">
                                        ${title}
                                    </span>
                                    <br>
                                    <span id="sub-title">
                                        ${sub_title}
                                    </span>
                                </div>
                            </div>`;
                    $("#frame-box").html(content);
                    $("#main-video-player")[0].play();
                } else {
                    var content =
                        `<div>
                                <div style="position: relative">
                                    <img src=${img} alt="" width="100%">
                                    <div style="position: relative">
                                        <audio id="main-audio-player" style="width:100%;position: absolute;bottom:0px" id="main-audio-player" src="${src}" controls></audio>
                                    </div>
                                </div>
                                <div style="color: white;text-align: right;margin-top: 10px">
                                    <span id="title" style="font-weight: bold">
                                        ${title}
                                    </span>
                                    <br>
                                    <span id="sub-title">
                                        ${sub_title}
                                    </span>
                                </div>
                            </div>`;
                    $("#frame-box").html(content);
                    $("#main-audio-player")[0].play();
                }
            });

            function state_content_ajax() {
                state_id = $("input[name='state_id']").val();
                if (state_id == 32) state_id = 1;
                data = {
                    _token: "{{ csrf_token() }}",
                    state_id: state_id,
                }
                state_id = parseInt(state_id) + 1;
                $("input[name='state_id']").val(state_id);
                $.ajax({
                    type: "post",
                    url: "{{ url('refresh-state-content') }}",
                    data: data,
                    success: function(response) {
                        if (response != 'no_data') {
                            $("#refresh-content-ajax").fadeOut(150).html(response).fadeIn(150);
                            setTimeout(state_content_ajax, 10000);
                        } else {
                            state_content_ajax();
                        }
                    }
                });
            };
            state_content_ajax();
        });
    </script>
@endsection
