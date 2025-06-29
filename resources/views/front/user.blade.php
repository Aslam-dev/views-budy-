@extends('layouts.front')

@section('content')


<div class="vine-header">
    <ul class="breadcrumbs">
        <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
        <li><a href="{{ route('users') }}">{{ trans('users') }}</a></li>
        <li>{{ $user->name }}</li>
    </ul>
</div>

<div class="leaderboard-box mb-2 border-bottom">
    <div class="d-flex flex-wrap flex-sm-nowrap">

        <div class="me-5 mb-4">
            <div class="leaderboard-box-img">
                <img src="{{ my_asset('uploads/users/'.$user->image) }}" alt="image">
            </div>
        </div>

        <div class="flex-grow-1">

            <div class="d-flex flex-column mb-4">
                <h3>{{ $user->name }}</h3>
            </div>

            <div class="d-flex flex-column flex-grow-1">

                <div class="d-flex flex-wrap">

                    <div class="leaderboard-box-stats py-3 px-4 me-2 mb-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-2 fw-bold">{{ App\Models\Video::where('user_id', $user->id)->count() }}</h3>
                        </div>
                        <p>{{ trans('videos') }}</p>
                    </div>

                    <div class="leaderboard-box-stats py-3 px-4 me-2 mb-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-2 fw-bold">{{ get_setting('currency_symbol'). App\Models\Payment::where('user_id', $user->id)->sum('amount') }}</h3>
                        </div>
                        <p class="fs-6">{{ trans('spent') }}</p>
                    </div>

                    <div class="leaderboard-box-stats py-3 px-4 me-2 mb-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-2 fw-bold">{{ short(App\Models\Earning::where('user_id', $user->id)->count()) }}</h3>
                        </div>
                        <p class="fs-6">{{ trans('watch_views') }}</p>
                    </div>


                    <div class="leaderboard-box-stats py-3 px-4 mb-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-2 fw-bold">{{ get_setting('currency_symbol'). App\Models\Earning::where('user_id', $user->id)->sum('amount') }}</h3>
                        </div>
                        <p class="fs-6">{{ trans('earnings') }}</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<h4 class="cat-title">{{ trans('videos') }}</h4>

<div class="videos" id="videos">
    @include('front.videos')
</div><!--/posts-->

@endsection

@section('scripts')
<script>

    $(document).on('click', '#videos .pagination-list a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];

        $.ajax({
            url: "{{ url('/creator/'.$user->id.'/'.$user->slug.'/paginate/?page=') }}" + page,
            data: {},
            success: function(response) {
                $('#videos').html(response);

                window.scroll({
                    top: 0, left: 0,
                    behavior: 'smooth'
                });
            }
        });

    });
</script>

@endsection
