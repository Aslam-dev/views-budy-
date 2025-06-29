
@forelse ($users as $user)



 <div class="col-lg-4">
    <div class="tf-author-box mb-4">
        <div class="author-avatar">
            <a href="{{ route('user', ['id' => $user->user_id, 'slug' => $user->user_slug]) }}">
                <img src="{{ my_asset('uploads/users/'.$user->user_image) }}" alt="User">
            </a>
        </div>
        <div class="author-infor">
            <h5><a href="{{ route('user', ['id' => $user->user_id, 'slug' => $user->user_slug]) }}">{{ $user->user_name }}</a></h5>
            <h6 class="gem">{{ get_setting('currency_symbol'). $user->sum_score }} {{ trans('earnings') }}</h6>
            @foreach ($week as $w)
                @if ($w->user_id == $user->user_id)
                    @if ($w->sum_score_week != '')
                    <span class="tf-color small">(<i class="bi bi-capslock me-1"></i>{{ get_setting('currency_symbol'). $w->sum_score_week }} {{ trans('this_week') }})</span>
                    @endif
                @endif
            @endforeach
        </div>

        @foreach ($total_users as $key => $rank)
            @if ($rank->user_id == $user->user_id)
            <div class="order
                @if ($key == '0' || $key == '1' || $key == '2') tf-color @endif
            ">{{'#'.($key+1) }}</div>
            @endif
        @endforeach
    </div>
  </div>

@empty

    <div class="dashboard-card">
        <div class="dashboard-body">
            <div class="upload-image my-3">
                <h4 class="mb-3">{{ trans('no_users_available') }}.</h4>
            </div>

        </div>
    </div><!--/dashboard-card-->

@endforelse

@if ($users->hasPages())
    <div>
        {!! $users->appends(request()->all())->links('layouts.pagination') !!}
    </div>
@endif

