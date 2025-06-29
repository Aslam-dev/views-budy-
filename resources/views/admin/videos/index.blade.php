@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">

        @if (Route::is('admin.videos.view') || Route::is('admin.videos.edit'))
            <a href="{{ route('admin.videos.list') }}" class="btn btn-success"><i class="align-middle" data-feather="arrow-left"></i> {{ trans('videos') }}</a>
        @endif

      <div class="row mt-50">

            @if(Route::is('admin.videos.list'))

                <div class="card">
                    <div class="card-header">

                        <div class="d-md-flex justify-content-between align-items-center mb-10">
                            <h5 class="h4 mb-0">{{ trans('videos') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable_cms" class="table table-bordered table-reload">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('user') }}</th>
                                    <th>{{ trans('video') }}</th>
                                    <th>{{ trans('category') }}</th>
                                    <th>{{ trans('status') }}</th>
                                    <th>{{ trans('public') }}</th>
                                    <th>{{ trans('date') }}</th>
                                    <th class="text-right">{{ trans('options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($videos as $key => $video)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>

                                        <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($video->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2"
                                            width="40px" height="40px" alt="Image">
                                         {{ App\Models\User::find($video->user_id)->name }}
                                        </td>

                                        <td>
                                                <img src="{{ ytThumbnail($video->video_id) }}" class="img-fluid" width="150px" height="130px" alt="Image">

                                            <p class="small">{{ $video->title }}</p>
                                        </td>

                                        <td>{{ App\Models\Admin\Category::find($video->category_id)->name }}</td>

                                        @if ($video->status == 1)
                                            <td><span class="badge bg-success">{{ trans('approved') }}</span> </td>
                                        @elseif ($video->status == 2)
                                            <td><span class="badge bg-danger">{{ trans('pending_approval') }}</span> </td>
                                        @elseif ($video->status == 3)
                                            <td><span class="badge bg-danger">{{ trans('rejected') }}</span> </td>
                                        @elseif ($video->status == 4)
                                            <td><span class="badge bg-danger">{{ trans('deleted') }}</span> </td>
                                        @endif

                                        @if ($video->hidden == 1)
                                            <td><span class="badge bg-primary">{{ trans('visible_to_public') }}</span> </td>
                                        @elseif ($video->hidden == 2)
                                            <td><span class="badge bg-danger">{{ trans('hidden_to_public') }}</span></td>
                                        @endif

                                        <td>{{ \Carbon\Carbon::parse($video->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                        <td class="text-right">

                                            <a  href="{{ route('admin.videos.view', ['id' => $video->id]) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon" title="View">
                                                <i class="align-middle" data-feather="eye"></i>
                                            </a>

                                            <a href="{{ route('admin.videos.edit', ['id' => $video->id]) }}" class="btn btn-soft-success btn-icon btn-circle btn-sm btn icon" title="Edit">
                                                <i class="align-middle" data-feather="edit-2"></i>
                                            </a>
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Delete"
                                            onclick="delete_item('{{ route('admin.videos.destroy') }}','{{ $video->id }}','{{ trans('delete_this_video') }}?');">
                                                <i class="align-middle" data-feather="trash"></i>
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>

            @elseif (Route::is('admin.videos.edit'))

                <div class="card-style settings-card-2 mb-30">
                    <h4 class="mb-3">{{ trans('edit_video') }}</h4>
                    <form id="editpost_form" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label class="form-label">{{ trans('title') }}</label>
                                    <input type="text" name="title" id="title" value="{{ $video->title }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="select-style-1">
                                    <label>{{ trans('categories') }}</label>
                                    <div class="select-position">
                                        <select name="category_id" id="category_id">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}" {{ $video->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label class="form-label">Youtube Video URL</label>
                                    <input type="text" name="url" id="url"  value="{{ $video->url }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label class="form-label">{{ trans('cost_per_view') }} e.g 0.001</label>
                                    <input type="text" name="view_cost" id="view_cost"  value="{{ $video->view_cost }}">
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="select-style-1">
                                    <label>{{ trans('view_count') }}</label>
                                    <div class="select-position">
                                        <select name="view_count" id="view_count">
                                            <option value="1" {{ $video->view_count == '1' ? 'selected' : '' }}>1 Hrs</option>
                                            <option value="3" {{ $video->view_count == '3' ? 'selected' : '' }}>3 Hrs</option>
                                            <option value="6" {{ $video->view_count == '6' ? 'selected' : '' }}>6 Hrs</option>
                                            <option value="9" {{ $video->view_count == '9' ? 'selected' : '' }}>9 Hrs</option>
                                            <option value="12" {{ $video->view_count == '12' ? 'selected' : '' }}>12 Hrs</option>
                                            <option value="15" {{ $video->view_count == '15' ? 'selected' : '' }}>15 Hrs</option>
                                            <option value="24" {{ $video->view_count == '24' ? 'selected' : '' }}>24 Hrs</option>
                                        </select>
                                    </div>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>{{ trans('show_video_to_public') }}</label>
                                    <select name="hidden" id="hidden" class="form-select form-control">
                                        <option value="1" {{ $video->hidden == '1' ? 'selected' : '' }}>{{ trans('show') }}</option>
                                        <option value="2"{{ $video->hidden == '2' ? 'selected' : '' }}>{{ trans('hide') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label class="form-label">{{ trans('amount_paid') }}</label>
                                    <input type="number" name="amount" id="amount" value="{{ round($video->amount_original) }}" readonly>
                                    <div class="invalid-feedback"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>{{ trans('approve') }}</label>
                                    <select name="status" id="status" class="form-select form-control">
                                        <option value="1" {{ $video->status == '1' ? 'selected' : '' }}>{{ trans('approve') }}</option>
                                        <option value="3"{{ $video->status == '3' ? 'selected' : '' }}>{{ trans('reject') }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                            <button type="submit" id="editpost_btn" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif (Route::is('admin.videos.view'))

            <div class="row">
                <iframe width="560" height="415" src="https://www.youtube.com/embed/{{ $video->video_id }}"
                title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write;
                encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>

                <div class="row mt-4">

                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol'). round($video->amount_original) }}</span></h3>
                                            <p class="text-muted mb-0">{{ trans('original_amount') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol'). $video->amount }}</span></h3>
                                            <p class="text-muted mb-0">{{ trans('current_amount') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol'). round($video->view_cost, 3) }}</span></h3>
                                            <p class="text-muted mb-0">{{ trans('cost_per_view') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h3 class="mt-0 mb-0"><span class="counter">{{ $video->view_count }} {{ trans('hrs') }}</span></h3>
                                            <p class="text-muted mb-0">{{ trans('view_count') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <h3 class="mt-0 mb-0"><span class="counter">{{ short($video->views()->count()) }}</span></h3>
                                            <p class="text-muted mb-0">{{ trans('views') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">

                        <div class="d-md-flex justify-content-between align-items-center mb-10">
                            <h5 class="h4 mb-0">{{ trans('viewers') }}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable_cms" class="table table-bordered table-reload">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('user') }}</th>
                                    <th>{{ trans('amount') }}</th>
                                    <th>{{ trans('date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (App\Models\Earning::where('video_id', $video->id)->get() as $key => $views)
                                    <tr>
                                        <td>{{ ($key+1) }}</td>

                                        <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($views->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2"
                                            width="40px" height="40px" alt="Image">
                                         {{ App\Models\User::find($views->user_id)->name }}
                                        </td>
                                        <td>{{ get_setting('currency_symbol') . $views->amount }}</td>
                                        <td>{{ \Carbon\Carbon::parse($views->created_at)->isoFormat('D MMMM YYYY H:m:s') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    </div>
                </div>

            @endif


      </div><!-- row -->
     </div><!-- container -->
    </section>

</main>
@endsection

@section('scripts')

    @if(Route::is('admin.videos.edit'))
        <script>
            $(function() {
                // update user ajax request
                $(document).on('submit', '#editpost_form', function(e) {
                    e.preventDefault();
                    start_load();
                    const fd = new FormData(this);
                    $("#editpost_btn").text('{{ trans('submitting') }}...');

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        method: 'POST',
                        url: '{{ route('admin.videos.edit', ['id' => $video->id]) }}',
                        data: fd,
                        cache: false,
                        contentType: false,
                        processData: false,
                        dataType: 'json',
                        success: function(response) {
                            end_load();

                            if (response.status == 400) {

                                showError('title', response.messages.title);
                                showError('url', response.messages.url);
                                showError('view_cost', response.messages.view_cost);
                                showError('view_count', response.messages.view_count);
                                $("#editpost_btn").text('{{ trans('submit') }}');

                            }else if (response.status == 200) {

                                tata.success("Success", response.messages, {
                                position: 'tr',
                                duration: 3000,
                                animate: 'slide'
                                });

                                removeValidationClasses("#editpost_form");
                                $("#editpost_form")[0].reset();
                                window.location.reload();

                            }else if(response.status == 401){

                                tata.error("Error", response.messages, {
                                position: 'tr',
                                duration: 3000,
                                animate: 'slide'
                                });

                                $("#editpost_form")[0].reset();
                                window.location.reload();

                            }

                        }
                    });

                });
            });
        </script>
    @endif

@endsection
