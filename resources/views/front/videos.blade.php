
<div class="row">

    @forelse ($videos as $video)
        <div class="col-xl-3 col-sm-6 mb-3">

            <div class="video-post">
                <a href="{{ route('video', ['video_id' => $video->video_id, 'slug' => $video->slug]) }}">
                    <!-- Blog Post Thumbnail -->
                    <div class="video-post-thumbnail">
                        <span class="video-post-count">{{ get_setting('currency_symbol'). round($video->amount) }}</span>
                        <span class="video-post-time">{{ $video->video_duration }}</span>
                        <div class="video-overlay"> </div>
                        <span class="play-btn-trigger"></span>
                        <!-- option menu -->
                        <span class="btn-option" aria-expanded="false">
                            <i class="icon-feather-more-vertical"></i>
                        </span>
                        <img src="{{ ytThumbnail($video->video_id) }}" alt="Thumbnail">

                    </div>

                    <!-- Blog Post Content -->
                    <div class="video-post-content">
                        <h3>{{ $video->title }}</h3>
                        <div class="media align-items-center">
                            <div class="media-head me-2">
                                <div class="avatar avatar-xs">
                                    <img src="{{ my_asset('uploads/users/'.$video->user->image) }}" alt="user" class="avatar-img rounded-circle">
                                </div>
                            </div>
                            <div class="media-body">
                                <h6>{{ $video->user->name }}</h6>
                                <div class="fn__meta">
                                    <p>
                                        <span class="meta_item">{{ $video->created_at->diffForHumans() }}</span>
                                        <span class="meta_sep"></span>
                                        <span class="meta_item">{{ short($video->views()->count()) }} {{ trans('views') }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </a>
            </div>

        </div>
    @empty

        <div class="dashboard-card">
            <div class="dashboard-body">
                <div class="upload-image my-3">
                    <h4 class="mb-3">{{ trans('no_videos_available') }}.</h4>
                </div>

            </div>
        </div><!--/dashboard-card-->

    @endforelse

    @if ($videos->hasPages())
    <div id="videos">
        {!! $videos->appends(request()->all())->links('layouts.pagination') !!}
    </div>
    @endif

</div>
