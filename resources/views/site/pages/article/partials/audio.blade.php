<div class="row">
    <div class="container">
        <div class="column add-bottom" style="margin-bottom: 0px !important">
            <div id="mainwrap">
                <div id="nowPlay">
                    <span id="npAction">متوقف ...</span><span id="npTitle"></span>
                </div>
                <div id="audiowrap">
                    <div id="audio0">
                        <audio id="audio1" preload controls>مرورگر شما از این فرمت پشتیبانی نمی کند 😢</audio>
                    </div>
                    <div id="tracks" style="direction: ltr">
                        <a id="btnPrev"><i class="fa fa-angle-double-left" aria-hidden="true"></i></a><a id="btnNext"><i class="fa fa-angle-double-right" aria-hidden="true"></i>                        </a>
                    </div>
                </div>
                <div id="plwrap">
                    <ul id="plList"></ul>
                </div>
            </div>
        </div>
    </div>
</div>
@section('audio')
    <script>
        jQuery(function ($) {
            'use strict'
            var supportsAudio = !!document.createElement('audio').canPlayType;
            if (supportsAudio) {
                // initialize plyr
                var player = new Plyr('#audio1', {
                    controls: [
                        'restart',
                        'play',
                        'progress',
                        'current-time',
                        'duration',
                        'mute',
                        'volume'
                    ]
                });
                // initialize playlist and controls
                var index = 0,
                    playing = false,
                    extension = '',

                    tracks = {!! $tracks !!},
                    buildPlaylist = $.each(tracks, function(key, value) {
                        var trackNumber = value.track,
                            trackName = value.name
                        if (trackNumber.toString().length === 1) {
                            trackNumber = '0' + trackNumber;
                        }
                        $('#plList').append('<li> \
                    <div class="plItem"> \
                        <span class="plNum">' + trackNumber + '.</span> \
                        <span class="plTitle">' + trackName + '</span> \
                    </div> \
                </li>');
                    }),
                    trackCount = tracks.length,
                    npAction = $('#npAction'),
                    npTitle = $('#npTitle'),
                    audio = $('#audio1').on('play', function () {
                        playing = true;
                        npAction.text('در حال پخش ... ');
                    }).on('pause', function () {
                        playing = false;
                        npAction.text('متوقف ...');
                    }).on('ended', function () {
                        npAction.text('متوقف شده ... ');
                        if ((index + 1) < trackCount) {
                            index++;
                            loadTrack(index);
                            audio.play();
                        } else {
                            audio.pause();
                            index = 0;
                            loadTrack(index);
                        }
                    }).get(0),
                    btnPrev = $('#btnPrev').on('click', function () {
                        if ((index - 1) > -1) {
                            index--;
                            loadTrack(index);
                            if (playing) {
                                audio.play();
                            }
                        } else {
                            audio.pause();
                            index = 0;
                            loadTrack(index);
                        }
                    }),
                    btnNext = $('#btnNext').on('click', function () {
                        if ((index + 1) < trackCount) {
                            index++;
                            loadTrack(index);
                            if (playing) {
                                audio.play();
                            }
                        } else {
                            audio.pause();
                            index = 0;
                            loadTrack(index);
                        }
                    }),
                    li = $('#plList li').on('click', function () {
                        var id = parseInt($(this).index());
                        if (id !== index) {
                            playTrack(id);
                        }
                    }),
                    loadTrack = function (id) {
                        $('.plSel').removeClass('plSel');
                        $('#plList li:eq(' + id + ')').addClass('plSel');
                        npTitle.text(tracks[id].name);
                        index = id;
                        var path = "";
                        if(tracks[id].disk === "local"){
                            @php if ( strpos(php_sapi_name(), 'cli') !== false || defined('LARAVEL_START_FROM_PUBLIC') ) { @endphp
                                path = "{{url('/')}}";
                          @php }else{ @endphp
                                path =  "{{url('/public')}}";
                           @php } @endphp
                        }
                        else{
                            path =  " https://s3." + "{{config('filesystems.disks.s3.region')}}" + ".amazonaws.com/" + '{{config('filesystems.disks.s3.bucket')}}';
                        }
                        audio.src = path+'/'+ tracks[id].file;
                        updateDownload(id, audio.src);
                    },
                    updateDownload = function (id, source) {
                        player.on('loadedmetadata', function () {
                            $('a[data-plyr="download"]').attr('href', source);
                        });
                    },
                    playTrack = function (id) {
                        loadTrack(id);
                        audio.play();
                    };

                loadTrack(index);
            } else {
                // no audio support
                $('.column').addClass('hidden');
                var noSupport = $('#audio1').text();
                $('.container').append('<p class="no-support">' + noSupport + '</p>');
            }
        });


    </script>
@endsection
