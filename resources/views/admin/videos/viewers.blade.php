@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">

      <div class="row mt-50">

        <div class="card">
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
                            <th>{{ trans('video') }}</th>
                            <th>{{ trans('paid') }}</th>
                            <th>{{ trans('date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (App\Models\Earning::get() as $key => $video)
                            <tr>
                                <td>{{ ($key+1) }}</td>

                                <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($video->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2"
                                    width="40px" height="40px" alt="Image">
                                    {{ App\Models\User::find($video->user_id)->name }}
                                </td>

                                <td>
                                    <img src="{{ ytThumbnail( App\Models\Video::find($video->video_id)->video_id ) }}" class="img-fluid" width="150px" height="130px" alt="Image">
                                    <p class="small">{{ App\Models\Video::find($video->video_id)->title  }}</p>
                                </td>
                                <td>{{ get_setting('currency_symbol') . $video->amount }}</td>


                                <td>{{ \Carbon\Carbon::parse($video->created_at)->isoFormat('D MMMM YYYY') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            </div>
        </div>

      </div><!-- row -->
     </div><!-- container -->
    </section>

</main>
@endsection
