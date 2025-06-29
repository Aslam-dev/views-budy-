

<div class="row">

    @forelse ($videos as $video)

        <div class="col-lg-4">
            <div class="card rounded mb-5">
                <div class="card-image">
                    <img class="img-fluid" src="{{ ytThumbnail($video->video_id) }}" alt="Thumbnail">
                </div>
                <div class="card-body text-center">
                    <div class="ad-title m-auto mb-2">
                        <h5>{{ $video->title }}</h5>
                    </div>
                    @if ($video->status == 4)
                        <p class="small"><span class="badge bg-red">{{ trans('deleted') }}</span></p>
                    @else
                        <a href="{{ route('user.videos.edit', ['id' => $video->id]) }}" class="btn btn-icon btn-soft-success" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('edit') }}">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <a href="javascript:void(0)" onclick="delete_item('{{ route('user.videos.destroy') }}','{{ $video->id }}','{{ trans('delete_this_video') }}');"
                            class="btn btn-icon btn-soft-danger" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('delete') }}">
                            <i class="bi bi-trash"></i>
                        </a>
                        <a href="{{ route('user.videos.view', ['id' => $video->id]) }}" class="btn btn-icon btn-soft-primary" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('view_details') }}">
                            <i class="bi bi-view-list"></i>
                        </a>
                        <a href="{{ route('user.videos.topup', ['id' => $video->id]) }}" class="btn btn-icon btn-soft-warning" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('add_more_money') }}">
                            <i class="bi bi-currency-dollar"></i>
                        </a>
                        @if ($video->hidden == 1)
                            <span class="btn btn-icon btn-mint cursor-default" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('visible_to_public') }}">
                                <i class="bi bi-eye"></i>
                            </span>
                        @else
                            <span class="btn btn-icon btn-red cursor-default" data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-original-title="{{ trans('hidden_to_public') }}">
                                <i class="bi bi-eye-slash"></i>
                            </span>
                        @endif
                        <div class="mt-3">
                            @if ($video->status == 1)
                                <p class="small"><span class="badge bg-green">{{ trans('approved') }}</span></p>
                            @elseif ($video->status == 2)
                                <p class="small"><span class="badge bg-red">{{ trans('pending_approval') }}</span></p>
                            @elseif ($video->status == 3)
                                <p class="small"><span class="badge bg-red">{{ trans('rejected') }}</span></p>
                            @endif
                        </div>
                    @endif
                </div>
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
    <div id="user_videos">
        {!! $videos->appends(request()->all())->links('layouts.pagination') !!}
    </div>
    @endif

</div>

<script>

    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl)
    });

</script>
