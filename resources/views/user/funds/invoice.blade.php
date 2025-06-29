@extends('layouts.user')

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-receipt me-2"></i> {{ trans('invoice') }}</h4>
    </div>

    <div class="dashboard-card invoice mb-5" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0 p-md-4">

                <div class="row">
                <div class="col-lg-6 mb-3">
                    <address>
                        <img src="{{ my_asset('uploads/settings/'.get_setting('logo')) }}" class="img-fluid mb-2" alt="logo">
                        <p><strong>{{ get_setting('site_name') }}</strong></p>
                        <p>{{ get_setting('contact_address') }}</p>
                        <p>{{ trans('email') }}: {{ get_setting('contact_email') }}</p>
                        <p>{{ trans('phone') }}: {{ get_setting('contact_phone') }}</p>
                    </address>
                </div>
                <div class="col-lg-6 ml-md-auto text-lg-end">
                    <h4>{{ trans('to') }}:</h4>
                    <address class="mb-5">
                        <p><strong>{{ Auth::user()->name }}</strong></p>
                        <p>{{ trans('email') }}: {{ Auth::user()->email }}</p>
                    </address>
                    <p><strong>{{ trans('invoice') }} {{ trans('date') }}:</strong>{{ \Carbon\Carbon::parse($fund->created_at)->isoFormat('D MMMM YYYY') }}</p>
                </div>
                </div>
                <div class="table-responsive my-5">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('quantity') }}</th>
                            <th>{{ trans('description') }}</th>
                            <th class="text-right">{{ trans('sub_total') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ trans('add_funds') }}</td>
                            <td class="text-right">{{ get_setting('currency_symbol') }}{{ $fund->amount }}</td>
                        </tr>
                    </tbody>
                </table>
                </div>
                <div class="row">
                <div class="col-lg-6">

                </div>
                <div class="col-lg-6 text-lg-end">
                    <span class="bt-1 d-inline-block pt-3 mb-4">
                    {{ trans('sub_total') }}: {{ get_setting('currency_symbol') }}{{ $fund->amount }}
                    <br>
                    {{ trans('transaction_fee') }} ({{ $fund->percentage_applied }}) : {{ get_setting('currency_symbol') }}{{ $fund->transaction_fee }}
                    </span>
                    <p class="text-bold">{{ trans('total') }}: <span class="tx-20 tx-gray-900">{{ $totalAmount }}</span></p>
                    <br>
                </div>
                </div>
                <hr>
                <div class="text-lg-end my-3">
                <button type="button" class="btn btn-mint" onclick="javascript:window.print();"><i class="bi bi-printer"></i> {{ trans('print') }}</button>
                </div>


        </div><!--/dashboard-body-->
    </div><!--/dashboard-card-->


@endsection
