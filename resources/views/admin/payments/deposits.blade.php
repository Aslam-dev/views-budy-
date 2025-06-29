@extends('layouts.admin')

@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
      <div class="container-fluid">
      <div class="row mt-50">


    @if(Route::is('admin.deposits'))

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                    <div class="d-md-flex justify-content-between align-items-center mb-10">
                        <h5 class="h4 mb-0">{{ trans('deposits') }}</h5>
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
                                <th>{{ trans('payment_gateway') }}</th>
                                <th>{{ trans('transaction_fee') }}</th>
                                <th>{{ trans('date') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($deposits as $key => $deposit)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td><img src="{{ my_asset('uploads/users/'.App\Models\User::find($deposit->user_id)->image) }}" class="img-fluid avatar avatar-rounded me-2" width="40px" height="40px" alt="Image">
                                     {{ App\Models\User::find($deposit->user_id)->name }}
                                    </td>
                                    <td>{{ get_setting('currency_symbol') }}{{ $deposit->amount }}</td>
                                    <td>
                                        <h5>{{ $deposit->gateway }}
                                            @if ($deposit->status == 2)
                                            <span class="badge bg-danger">{{ trans('pending') }}</span>
                                            @elseif ($deposit->status == 3)
                                            <span class="badge bg-danger">{{ trans('rejected') }}</span>
                                            @endif
                                        </h5>
                                        @if ($deposit->status == 2 && $deposit->gateway == 'Bank Transfer')
                                            <p class="mt-2">
                                                <a href="{{ route('admin.deposits.view', ['id' => $deposit->id]) }}" class="btn btn-soft-success">{{ trans('view') }}</a>
                                                <a href="javascript:void(0)" class="btn btn-soft-danger"
                                                onclick="approve('{{ route('admin.deposits.approve') }}','{{ $deposit->id }}','{{ trans('approve_payment') }}');">
                                                {{ trans('approve') }}
                                                </a>
                                                <a href="javascript:void(0)" class="btn btn-soft-danger"
                                                onclick="reject('{{ route('admin.deposits.reject') }}','{{ $deposit->id }}','{{ trans('reject_payment') }}');">
                                                {{ trans('reject') }}
                                                </a>
                                            </p>
                                        @endif
                                    </td>
                                    <td>{{ get_setting('currency_symbol') }}{{ $deposit->transaction_fee }}</td>
                                    <td>{{ \Carbon\Carbon::parse($deposit->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                </div>
            </div>
        </div>

    @elseif (Route::is('admin.deposits.view'))

        <div class="col-12">
            <a href="{{ route('admin.deposits') }}" class="btn btn-success mb-3"><i class="align-middle" data-feather="arrow-left"></i> {{ trans('deposits') }}</a>

            <div class="card">
                <div class="card-body">
                    <h5 class="h4 mb-2">{{ trans('bank_transaction_code') }}</h5>
                    <p>{{ $fund->fund_id }}</p>
                    <h5 class="h4 mb-3 mt-2">{{ trans('bank_receipt') }}</h5>
                    <img src="{{ my_asset('uploads/bank/'.$fund->img) }}" alt="Image">
                </div>
            </div>
        </div>

    @endif

    </div><!-- row -->
   </div><!-- container -->
  </section>

</main>
@endsection
