
<div class="mt-4 pt-2 is-hidden popular-people">
    <div class="search-meta">
        <div class="section-title mb-3">
            <p class="title h4 mb-0">{{ trans('users') }}</p>
        </div>

        <div class="people-grid">

            @foreach ($users as $user)
                <a href="{{ route('user', ['id' => $user->id, 'slug' => $user->slug]) }}" class="people-grid-item">
                    <div class="people-grid-image">
                    <img src="{{ my_asset('uploads/users/'.$user->image) }}" alt="Browse Vectors">
                    </div>
                    <p class="people-grid-title">{{ $user->name }}</p>
                </a>
            @endforeach
        </div>
    </div>
</div>
<div class="mt-4 pt-2 is-hidden popular-tags">
    <div class="search-meta">
        <div class="section-title mb-3">
            <p class="title h4 mb-0">{{ trans('categories') }}</p>
        </div>
        <div class="tags">
            <a href="{{ route('categories') }}" class="tag-link green">{{ trans('all_categories') }} <i class="bi bi-arrow-right"></i></a>
            @foreach ($categories as $category)
                <a href="{{ route('category', ['slug' => $category->slug]) }}" class="tag-link">{{ $category->name }} ({{ $category->videos()->count() }})</a>
            @endforeach
        </div>
    </div>
</div>
<div class="mt-4 pt-2 is-hidden">
    <div class="search-meta">
        <div class="section-title mb-3 pb-1">
            <p class="title h4 mb-0">{{ trans('videos') }}</p>
        </div>
        <div class="row">

            @foreach ($videos as $video)
                <div class="col-lg-4 mb-3">

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
            @endforeach

        </div>
    </div>
</div>
