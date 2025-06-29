@extends('layouts.front')

@section('content')

<div class="vine-header">
    <ul class="breadcrumbs">
        <li><a href="{{ route('home') }}"><span class="bi bi-house me-1"></span>{{ trans('home') }}</a></li>
        <li><a href="{{ route('categories') }}">{{ trans('categories') }}</a></li>
        <li>{{ $category->name }}</li>
    </ul>
</div>

<div class="leaderboard-box mb-2 border-bottom">
    <div class="d-flex flex-wrap flex-sm-nowrap">

        <div class="me-5 mb-4">
            <div class="leaderboard-box-img">
                <img src="{{ my_asset('uploads/categories/'.$category->image) }}" alt="image">
            </div>
        </div>

        <div class="flex-grow-1">

            <div class="d-flex flex-column mb-4">
                <h3>{{ $category->name }}</h3>
            </div>

            <div class="d-flex flex-column flex-grow-1">

                <div class="d-flex flex-wrap">

                    <div class="leaderboard-box-stats py-3 px-4 me-2 mb-3">
                        <div class="d-flex align-items-center">
                            <h3 class="fs-2 fw-bold">{{ App\Models\Video::where('category_id', $category->id)->count() }}</h3>
                        </div>
                        <p>{{ trans('videos') }}</p>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<h4 class="cat-title">{{ trans('videos') }}</h4>

<div class="videos" id="videos">
    @include('front.videos')
</div>

@endsection



@section('scripts')
<script>

    $(document).on('click', '#videos .pagination-list a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];

        $.ajax({
            url: "{{ url('/category/'.$category->slug.'/paginate/?page=') }}" + page,
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
