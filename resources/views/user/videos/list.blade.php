@extends('layouts.user')

@section('content')


    <div class="d-flex justify-content-between mb-5">
        <h4><i class="bi bi-youtube me-2"></i> {{ trans('videos') }}</h4>
        <a href="{{ route('user.videos.add') }}" class="btn btn-sm btn-mint rounded-pill"><i class="bi bi-plus-circle-dotted me-2"></i>{{ trans('add_video') }}</a>
    </div>


    <div class="videos" id="videos">
        @include('user.videos.paginate')
    </div><!--/posts-->


@endsection
@section('scripts')
<script>

    $(document).on('click', '#user_videos .pagination-list a', function(e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];

        $.ajax({
            url: "{{ url('/user/videos/pagination/?page=') }}" + page,
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
