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
                        <h5 class="h4 mb-0">{{ trans('withdrawals') }}</h5>
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
                                <th>{{ trans('payout') }}</th>
                                <th>{{ trans('payout_details') }}</th>
                                <th>{{ trans('date_requested') }}</th>
                                <th>{{ trans('date_to_be_paid') }}</th>
                                <th>{{ trans('status') }}</th>
                                <th class="text-right">{{ trans('options') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($withdrawals as $key => $withdraw)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($withdraw->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2" width="40px" height="40px" alt="Image">
                                     {{ App\Models\User::find($withdraw->user_id)->name }}
                                    </td>
                                    <td>{{ get_setting('currency_symbol') }}{{ $withdraw->amount }}</td>
                                    <td>{{ App\Models\Admin\Payout::find($withdraw->payout_id)->name }}</td>
                                    <td>{{ $withdraw->payout_details }}</td>
                                    <td>{{ \Carbon\Carbon::parse($withdraw->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($withdraw->process_date)->isoFormat('D MMMM YYYY') }}</td>
                                    @if ($withdraw->status === 1)
                                        <td><span class="badge bg-success p-2">{{ trans('paid') }}</span></td>
                                    @else
                                        <td><span class="badge bg-danger p-2">{{ trans('not_paid') }}</span></td>
                                    @endif
                                    <td class="text-right">

                                        @if ($withdraw->status === 1)
                                            <a href="javascript:void(0)" class="btn btn-soft-danger btn-icon btn-circle btn-sm confirm-delete" title="Paid"
                                            onclick="paid('{{ route('admin.withdrawals.unpaid') }}','{{ $withdraw->id }}','{{ trans('cancel_user_payment') }}')">
                                                <i class="align-middle" data-feather="x-circle"></i>
                                            </a>
                                        @else
                                            <a href="javascript:void(0)" class="btn btn-soft-success btn-icon btn-circle btn-sm confirm-delete" title="Paid"
                                            onclick="paid('{{ route('admin.withdrawals.paid') }}','{{ $withdraw->id }}','{{ trans('pay_user') }}')">
                                                <i class="align-middle" data-feather="check-circle"></i>
                                            </a>
                                        @endif


                                    </td>
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
