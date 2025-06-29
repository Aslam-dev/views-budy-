
@forelse($users as $user)

<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12">
    <div class="flext-author-entry flext-slide has-cover-image mt-5 mb-4">
        <div class="flext-author-content">
            <div class="flext-author-header">
                <div class="flext-author-avatar">
                    <a href="{{ route('user', ['id' => $user->id, 'slug' => $user->slug]) }}">
                    <img alt="Image" src="{{ my_asset('uploads/users/'.$user->image) }}" class="avatar avatar-lg">
                </a>
            </div>
            </div>
            <div class="flext-author-detail">
                <h4 class="flext-author-title"><a href="{{ route('user', ['id' => $user->id, 'slug' => $user->slug]) }}">{{ $user->name }}</a></h4>
                <span class="flext-author-follow-numbers">
                    <p class="flext-author-followers">{{ App\Models\Video::where('user_id', $user->id)->count() }} {{ trans('videos') }}</p>
                    <p class="flext-author-following">{{ get_setting('currency_symbol'). App\Models\Payment::where('user_id', $user->id)->sum('amount') }} {{ trans('spent') }}</p>
                </span>
                <span class="flext-author-follow-numbers">
                    <p class="flext-author-followers">{{ short(App\Models\Earning::where('user_id', $user->id)->count()) }} {{ trans('watch_views') }}</p>
                    <p class="flext-author-following">{{ get_setting('currency_symbol'). App\Models\Earning::where('user_id', $user->id)->sum('amount') }} {{ trans('earnings') }}</p>
                </span>
            </div>
        </div>
    </div>
</div>

@empty

<div class="dashboard-card">
    <div class="dashboard-body">
        <div class="upload-image my-3">
            <h4 class="mb-3">{{ trans('no_users_available') }}</h4>
        </div>

    </div>
</div><!--/dashboard-card-->

@endforelse

@if ($users->hasPages())
<div>
    {!! $users->appends(request()->all())->links('layouts.pagination') !!}
</div>
@endif
