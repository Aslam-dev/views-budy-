@extends('layouts.front')

@section('content')

<div class="row">
    <div class="col-lg-9 pe-lg-5">
        @if (Auth::check())
            @if (Auth::user()->expiry_count($video->id) == 0)
                <div class="video-player">
                    <div id="player" class="rounded w-100"></div>
                </div>
                <h4 id="volume" class="mt-4"></h4>
                <h4 id="warning" class="mt-4"></h4>
            @else
                @if (\Carbon\Carbon::now() >= Auth::user()->expiry($video->id))
                    <div class="video-player">
                        <div id="player" class="rounded w-100"></div>
                    </div>
                    <h4 id="volume" class="mt-4"></h4>
                    <h4 id="warning" class="mt-4"></h4>
                @else
                    <div class="content-locked" style="background-image: linear-gradient( rgba(35, 37, 38, 0.80), rgba(35, 37, 38, 0.80) ),
                    url({{ ytThumbnail($video->video_id) }});">
                        <h1><i class="bi bi-shield-lock"></i></h1>
                        <div id="countdown">
                            <ul>
                            <li><span id="hours"></span>{{ trans('hours') }}</li>
                            <li><span id="minutes"></span>{{ trans('minutes') }}</li>
                            <li><span id="seconds"></span>{{ trans('seconds') }}</li>
                            </ul>
                        </div>
                        <h4 class="text-red">{{ trans('wait_for_time_to_expire') }}</h4>
                    </div>
                @endif
            @endif

            @if (Auth::user()->id == $video->user_id)
                <h4 class="mt-4"><span class="badge bg-red">{{ trans('you_are_the_owner_of_this_video') }}</span></h4>
            @endif
        @else

            <div class="content-locked" style="background-image: linear-gradient( rgba(35, 37, 38, 0.80), rgba(35, 37, 38, 0.80) ),
            url({{ ytThumbnail($video->video_id) }});">
                <h1><i class="bi bi-shield-lock"></i></h1>
                <a href="{{ route('auth.login') }}" class="btn btn-lg btn-border w-50">{{ trans('login_to_watch_&_earn') }}</a>
            </div>

        @endif


        @include('front.partials.other')

    </div>

    <div class="col-lg-3">

        <div class="mo-box mb-4" id="secCard">
            <h1 id="message"></h1>
            <p class="small">{{ trans('seconds_remaining') }}</p>
        </div>

         @include('front.partials.sidebar')

    </div>

</div>

@endsection

@section('scripts')

    @if (Auth::check())
        <script>
            var tag = document.createElement('script');
            tag.src = "https://www.youtube.com/iframe_api";
            var firstScriptTag = document.getElementsByTagName('script')[0];
            firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

            var player;
            let watchSeconds = '{{ timeToSeconds($video->video_duration) }}';
            let watchedTime = '0';
            const minVol = 0;
            let timer = null;
            let volumeCheck = null;
            let volumeWarningShown = false;
            const messageDiv = document.getElementById('message');
            const volumeDiv = document.getElementById('volume');
            const warningDiv = document.getElementById('warning');
            const pauseOnVisibilityChange = true;


            function onPlayerStateChange(event) {
                if (event.data == YT.PlayerState.PLAYING) {

                    @if ($video->amount < $video->view_cost || $video->amount == 0)

                        player.stopVideo();
                        const warningMessage = '{{ trans('this_video_does_not_have_enough_money') }}';
                        warningDiv.innerHTML = `<span class="badge bg-red">${warningMessage}</span>`;

                    @else

                        @if (Auth::user()->id != $video->user_id)

                            $("#secCard").show();
                            startVolumeCheck();
                            startTimer();

                        @endif

                    @endif

                } else if (event.data == YT.PlayerState.PAUSED || event.data == YT.PlayerState.ENDED) {
                    stopTimer();
                }
            }

            function checkVolume() {
                const volume = player.getVolume();
                const isMuted = player.isMuted();
                const volWarning = '{{ trans('the_volume_is_muted') }}';

                if ((isMuted || volume < minVol) && !volumeWarningShown) {
                    player.pauseVideo();
                    stopTimer();

                    volumeDiv.innerHTML = `<span class="badge bg-red">${volWarning}</span>`;
                    volumeWarningShown = true;
                } else if (volume >= minVol && !isMuted && volumeWarningShown) {

                    volumeDiv.innerHTML = ``;
                    volumeWarningShown = false;
                    if (player.getPlayerState() !== YT.PlayerState.PLAYING) {
                        player.playVideo();
                        startTimer();
                    }
                }
            }

            function startVolumeCheck() {
                if (!volumeCheck) {
                    volumeCheck = setInterval(checkVolume, 500);
                }
            }

            function stopVolumeCheck() {
                clearInterval(volumeCheck);
                volumeCheck = null;
                volumeWarningShown = false;
            }

            function startTimer() {
                if (!timer) {
                    timer = setInterval(function() {
                        watchedTime++;
                        let remainingTime = watchSeconds - watchedTime;
                        const waitMessage = remainingTime;
                        messageDiv.innerHTML = '<span class="badge bg-red">' + waitMessage + '</span>';
                        if (watchedTime >= watchSeconds) {
                            clearInterval(timer);
                            timer = null;


                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });

                            $.ajax({
                                method: 'POST',
                                url: '{{ route('earning', ['id' => $video->id]) }}',
                                cache: false,
                                contentType: false,
                                processData: false,
                                dataType: 'json',
                                success: function(response) {

                                    tata.success("Success", response.messages, {
                                    position: 'tr',
                                    duration: 3000,
                                    animate: 'slide'
                                    });
                                }
                            });

                            setTimeout(
                                function(){
                                    location.reload()
                            }, 2000);

                        }
                    }, 1000);
                }
            }

            function stopTimer() {
                clearInterval(timer);
                timer = null;
            }

            if (pauseOnVisibilityChange) {
                document.addEventListener('visibilitychange', function() {
                    if (document.hidden) {
                        player.pauseVideo();
                        stopTimer();
                        stopVolumeCheck();
                    }
                });
            }

            function onYouTubeIframeAPIReady() {
                player = new YT.Player('player', {
                    videoId: '{{ $video->video_id }}',
                    events: {
                        'onStateChange': onPlayerStateChange
                    },
                    playerVars: { 'rel': 0 }
                });
            }
        </script>

        @if (\Carbon\Carbon::now() < Auth::user()->expiry($video->id))
            <script>
                (function () {
                    var second = 1000;
                    var minute = second * 60;
                    var hour = minute * 60;
                    var day = hour * 24;
                    var date = '{{ \Carbon\Carbon::parse(Auth::user()->expiry($video->id))->isoFormat('D MMMM YYYY H:m:s') }}';


                    // Set the date we're counting down to
                    var countDownDate = new Date(date).getTime();

                    x = setInterval(function() {

                        const now = new Date().getTime(),
                            distance = countDownDate - now;

                        document.getElementById("hours").innerText = Math.floor((distance % (day)) / (hour)),
                        document.getElementById("minutes").innerText = Math.floor((distance % (hour)) / (minute)),
                        document.getElementById("seconds").innerText = Math.floor((distance % (minute)) / second);

                            // If the count down is over, write some text
                            if (distance < 0) {
                                clearInterval(x);
                                window.location.reload();
                            }
                    }, 0)
                }());
            </script>
        @endif

        <script src="https://www.youtube.com/iframe_api"></script>
    @endif
@endsection
