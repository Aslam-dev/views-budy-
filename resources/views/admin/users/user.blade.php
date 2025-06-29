@extends('layouts.admin')

@section('content')

<main class="content">
    <a href="{{ route('admin.users.list') }}" class="btn btn-success"><i class="align-middle" data-feather="arrow-left"></i> {{ trans('users') }}</a>
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">

        <div class="row mt-50">


            <div class="col-xl-4 col-lg-4 col-md-12">
                <div class="author-wrap-ngh">
                    <div class="author-wrap-head-ngh">
                        <div class="author-wrap-ngh-thumb">
                            <img src="{{ my_asset('uploads/users/'.$user->image) }}" class="img-fluid circle" alt="avatar">
                        </div>
                        <div class="author-wrap-ngh-info">
                            <h5>{{ $user->name }}</h5>
                        </div>
                    </div>

                    <div class="author-wrap-footer-ngh">
                        <ul>
                            <li>
                                <div class="jhk-list-inf">
                                    <div class="jhk-list-inf-ico"><i class="align-middle" data-feather="log-in"></i></div>
                                    <div class="jhk-list-inf-caption"><h5>{{ trans('joined') }}</h5><p>{{ \Carbon\Carbon::parse($user->created_at)->isoFormat('D MMMM YYYY') }}</p></div>
                                </div>
                            </li>
                            <li>
                                <div class="jhk-list-inf">
                                    <div class="jhk-list-inf-ico"><i class="align-middle" data-feather="droplet"></i></div>
                                    <div class="jhk-list-inf-caption"><h5>{{ trans('email') }}</h5><p>{{ $user->email }}</p></div>
                                </div>
                            </li>
                        </ul>
                    </div>

                </div>
            </div>

            <div class="col-xl-8 col-lg-8 col-md-12">
              <div class="row">

                <div class="col-lg-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="flex-grow-1">
                                    <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol'). App\Models\Earning::where('user_id', $user->id)->sum('amount') }}</span></h3>
                                    <p class="text-muted mb-0">{{ trans('earnings') }}</p>
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
                                    <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol') . $user->wallet }}</span></h3>
                                    <p class="text-muted mb-0">{{ trans('wallet') }}</p>
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
                                    <h3 class="mt-0 mb-0"><span class="counter">{{ $user->videos()->count() }}</span> </h3>
                                    <p class="text-muted mb-0">{{ trans('videos') }}</p>
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
                                    <h3 class="mt-0 mb-0"><span class="counter">{{ get_setting('currency_symbol'). App\Models\Payment::where('user_id', $user->id)->sum('amount') }}</span></h3>
                                    <p class="text-muted mb-0">{{ trans('spent') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              </div>
            </div>

        </div><!-- row -->



        <div class="card mt-5">
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
                            <th>{{ trans('video') }}</th>
                            <th>{{ trans('category') }}</th>
                            <th>{{ trans('date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Video::where('user_id', $user->id)->get() as $key => $video)
                            <tr>
                                <td>{{ ($key+1) }}</td>

                                <td>
                                    <a href="{{ route('user.videos.view', ['id' => $video->id]) }}">
                                        <img src="{{ ytThumbnail($video->video_id) }}" class="img-fluid" width="150px" height="130px" alt="Image">
                                    </a>
                                    <p class="small">{{ $video->title }}</p>
                                </td>

                                <td>{{ App\Models\Admin\Category::find($video->category_id)->name }}</td>

                                <td>{{ \Carbon\Carbon::parse($video->created_at)->isoFormat('D MMMM YYYY') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            </div>
        </div>


      </div><!-- container -->
  </section>

</main>
@endsection
