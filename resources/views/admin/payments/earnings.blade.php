@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
      <div class="row mt-50">

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-md-flex justify-content-between align-items-center mb-10">
                        <h5 class="h4 mb-0">{{ trans('earnings') }}</h5>
                    </div>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                    <table id="datatable_cms" class="table table-bordered table-reload">

                        <thead>
                            <tr>
                                <th>#</th>
                                <th>{{ trans('user_sender') }}</th>
                                <th>{{ trans('user_receiver') }}</th>
                                <th>{{ trans('amount') }}</th>
                                <th>{{ trans('date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($earnings as $key => $earning)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($earning->sender_id)->image) }}" class="img-fluid avatar avatar-rounded me-2" width="40px" height="40px" alt="Image">
                                     {{ App\Models\User::find($earning->sender_id)->name }}
                                    </td>
                                    <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($earning->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2" width="40px" height="40px" alt="Image">
                                     {{ App\Models\User::find($earning->user_id)->name }}
                                    </td>
                                    <td>{{ get_setting('currency_symbol') . $earning->amount }}</td>
                                    <td>{{ \Carbon\Carbon::parse($earning->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>

    </div><!-- row -->
   </div><!-- container -->
  </section>

</main>
@endsection
