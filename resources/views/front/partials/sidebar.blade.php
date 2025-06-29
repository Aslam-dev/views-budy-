

<div class="mo-box">
    <h1>{{ get_setting('currency_symbol'). $video->amount }}</h1>
    <p class="small">{{ trans('watch_&_earn') }}</p>
</div>

<div class="mo-box mt-4">
    <div class="price-wrapper_card-price">
        <div class="price-wrapper_card-price-text">{{ get_setting('currency_symbol'). round($video->view_cost, 3) }}</div>
        <div class="price-wrapper_card-secondary-text">/ {{ trans('per_view') }}</div>
    </div>
</div>

<div class="mo-box mt-4">
    <h3>{{ $video->view_count }} {{ trans('hrs') }}</h3>
    <p class="small text-green">{{ trans('view_count') }} / {{ trans('per_user') }}</p>
</div>

<div class="flext-author-entry flext-slide has-cover-image mt-5 mb-4">
    <div class="flext-author-content">
        <div class="flext-author-header">
            <div class="flext-author-avatar">
                <a href="{{ route('user', ['id' => $video->user->id, 'slug' => $video->user->slug]) }}">
                <img alt="Image" src="{{ my_asset('uploads/users/'.$video->user->image) }}" class="avatar avatar-lg">
            </a>
        </div>
        </div>
        <div class="flext-author-detail">
            <h4 class="flext-author-title"><a href="{{ route('user', ['id' => $video->user->id, 'slug' => $video->user->slug]) }}">{{ $video->user->name }}</a></h4>
            <span class="flext-author-follow-numbers">
                <p class="flext-author-followers">{{ App\Models\Video::where('user_id', $video->user->id)->count() }} {{ trans('videos') }}</p>
                <p class="flext-author-following">{{ get_setting('currency_symbol'). App\Models\Payment::where('user_id', $video->user->id)->sum('amount') }} {{ trans('spent') }}</p>
            </span>
            <span class="flext-author-follow-numbers">
                <p class="flext-author-followers">{{ short(App\Models\Earning::where('user_id', $video->user->id)->count()) }} {{ trans('watch_views') }}</p>
                <p class="flext-author-following">{{ get_setting('currency_symbol'). App\Models\Earning::where('user_id', $video->user->id)->sum('amount') }} {{ trans('earnings') }}</p>
            </span>
        </div>
    </div>
</div>


@if ($video->views()->count() > 0)
<div class="top-users">

    <div class="mx-3 mb-2">
        <h5>{{ trans('latest_earners') }}</h5>
    </div>

    <ul class="list-group list-group-flush">

        @foreach (App\Models\Earning::where('video_id', $video->id)->limit(6)->get() as $view)

            <li class="list-group-item border-0">
                <div class="media align-items-center">
                    <div class="media-head me-3">
                        <div class="avatar avatar-sm">
                            <img src="{{ my_asset('uploads/users/'.App\Models\User::find($view->user_id)->image) }}" alt="user" class="avatar-img avatar-rounded">
                        </div>
                    </div>
                    <div class="media-body">
                        <a>{{ App\Models\User::find($view->user_id)->name }}</a>
                    </div>
                    <p>{{ get_setting('currency_symbol'). $view->amount }}</p>
                </div>
            </li>

        @endforeach
    </ul>
</div>
@endif
