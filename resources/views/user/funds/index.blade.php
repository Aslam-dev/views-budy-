@extends('layouts.user')

@section('styles')
<link href="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.css') }}" rel="stylesheet">
<link href="{{ my_asset('assets/vendors/datatables/jquery.dataTables_them.css') }}" rel="stylesheet">
<style>
    /* Datatable */
    table.dataTable{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    table.dataTable tbody tr {
        background-color: var(--theme-white) !important;
    }
    .form-select{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    .form-control{
        background-color: var(--theme-white) !important;
        color: var(--text-color) !important;
    }
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_processing,
    .dataTables_wrapper .dataTables_paginate {
        color: var(--text-color) !important;
    }
</style>
@if (get_setting('site_direction') == 'rtl')
    <style>
        .dataTables_wrapper .dataTables_length {
            float: right !important;
        }
        .dataTables_wrapper .dataTables_filter {
            float: left !important;
            text-align: left !important;
        }
        .dataTables_wrapper .dataTables_paginate {
            float: left !important;
            text-align: left !important;
        }
        .dataTables_wrapper .dataTables_info {
            float: right !important;
        }
    </style>
@endif
@endsection

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-wallet2 me-2"></i> {{ trans('wallet') }}</h4>
        <p>{{ trans('add_funds_to_your_wallet') }}.</p>
    </div>

    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">
            <h4>{{ trans('available_funds') }}</h4>
            <div class="price-price mb-2">
                <span><b>{{ get_setting('currency_symbol') }}{{ Auth::user()->wallet }}</b></span>
            </div>
        </div>
    </div><!--/dashboard-card-->

    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">
            <h4 class="mb-3">{{ trans('add_funds') }}</h4>
            <form id="deposit_form" action="{{ route('user.funds.add') }}" method="POST">
                @csrf

                <div class="form-group">
                    <input id="onlyNumber" name="amount" min="{{ get_setting('min_deposit') }}" autocomplete="off" placeholder="{{ trans('amount') }} (Min - {{ get_setting('min_deposit') }})" type="number">
                </div>
                <div class="deposit-box mt-3 mb-4">
                    <div class="d-flex justify-content-between">
                        <p>{{ trans('transaction_fee') }}</p>
                        <p>{{ get_setting('currency_symbol') }} <span id="transactionFee">0.00</span></p>
                    </div>
                    <div class="d-flex justify-content-between">
                        <p>{{ trans('total') }}</p>
                        <p>{{ get_setting('currency_symbol') }} <span id="total">0.00</span></p>
                    </div>
                </div>

                <div class="row row-cols-2 row-cols-lg-3 g-1 g-lg-1">

                    @if(get_setting('paypal_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="PayPal" id="PayPal" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="PayPal">
                                <span><strong>PayPal</strong></span>
                                <small class="w-100 d-block">{{ get_setting('paypal_fee').'%' }} + {{ get_setting('paypal_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('stripe_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Stripe" id="Stripe" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Stripe">
                                <span><strong>Stripe</strong></span>
                                <small class="w-100 d-block">{{ get_setting('stripe_fee').'%' }} + {{ get_setting('stripe_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('razorpay_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Razorpay" id="Razorpay" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Razorpay">
                                <span><strong>Razorpay</strong></span>
                                <small class="w-100 d-block">{{ get_setting('razorpay_fee').'%' }} + {{ get_setting('razorpay_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('paystack_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Paystack" id="Paystack" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Paystack">
                                <span><strong>Paystack</strong></span>
                                <small class="w-100 d-block">{{ get_setting('paystack_fee').'%' }} + {{ get_setting('paystack_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('mollie_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Mollie" id="Mollie" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Mollie">
                                <span><strong>Mollie</strong></span>
                                <small class="w-100 d-block">{{ get_setting('mollie_fee').'%' }} + {{ get_setting('mollie_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('flutterwave_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Flutterwave" id="Flutterwave" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Flutterwave">
                                <span><strong>Flutterwave</strong></span>
                                <small class="w-100 d-block">{{ get_setting('flutterwave_fee').'%' }} + {{ get_setting('flutterwave_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                    @if(get_setting('bank_active') == 'Yes')
                        <div class="custom-control custom-radio mb-3">
                            <input name="payment_gateway" value="Bank" id="Bank" class="custom-control-input" type="radio">
                            <label class="custom-control-label" for="Bank">
                                <span><strong>Bank</strong></span>
                                <small class="w-100 d-block">{{ get_setting('bank_fee').'%' }} + {{ get_setting('bank_fee_cents') }}</small>
                            </label>
                        </div>
                    @endif

                </div>

                <input type="submit" class="btn btn-mint w-100 mt-4" id="deposit_btn" value="{{ trans('add_funds') }}" disabled>

            </form>
        </div>
    </div><!--/dashboard-card-->

    <div class="dashboard-card" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-header">
            <h4 class="m-0">{{ trans('deposits_history') }}</h4>
        </div>
        <div class="dashboard-body">
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="datatable_cms" class="table align-middle table-row-dashed gy-4 mb-0">
                    <thead>
                        <tr class="border-bottom border-gray-200 gs-0">
                            <th class="min-w-150px">ID</th>
                            <th class="min-w-125px">{{ trans('amount') }}</th>
                            <th class="min-w-125px">{{ trans('payment_gateway') }}</th>
                            <th class="min-w-125px">{{ trans('date') }}</th>
                            <th class="min-w-125px">{{ trans('status') }}</th>
                            <th class="min-w-70px">{{ trans('invoice') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($funds as $key => $fund)
                            <tr>
                                <td>{{ ($key+1) }}</td>
                                <td>{{ get_setting('currency_symbol') }}{{ $fund->amount }}</td>
                                <td>{{ $fund->gateway }}</td>
                                <td>{{ \Carbon\Carbon::parse($fund->created_at)->isoFormat('D MMMM YYYY') }}</td>
                                @if ($fund->status == 1)
                                    <td><span class="badge bg-green p-2">{{ trans('success') }}</span></td>
                                @elseif ($fund->status == 2)
                                    <td><span class="badge bg-danger p-2">{{ trans('pending') }}</span></td>
                                @elseif ($fund->status == 3)
                                    <td><span class="badge bg-danger p-2">{{ trans('rejected') }}</span></td>
                                @endif
                                <td class="text-right">
                                    @if ($fund->status === 1)
                                        <a href="{{ route('user.wallet.invoice', ['id' => $fund->id]) }}" class="btn btn-sm btn-light">
                                            {{ trans('view_invoice') }}</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

@endsection

@section('scripts')
<script src="{{ my_asset('assets/vendors/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ my_asset('assets/vendors/datatables/dataTables.bootstrap5.min.js') }}"></script>

<script>

    $('#datatable_cms').DataTable();

    $(document).ready(function(){
        var radios = $("input[type='radio']");
        var submit_btn = $("input[type='submit']");

        radios.click(function() {
            submit_btn.attr("disabled", !radios.is(":checked"));
        });

        $decimal = 2;

        function toFixed(number, decimals) {
            var x = Math.pow(10, Number(decimals) + 1);
            return (Number(number) + (1 / x)).toFixed(decimals);
        }

        $('input[name=payment_gateway]').on('click', function() {

            var valueOriginal = $('#onlyNumber').val();
            var value = parseFloat($('#onlyNumber').val());
            var element = $(this).val();

            if (element != '' && value >= {{ get_setting('min_deposit') }} && valueOriginal != '' ) {
            // Fees

                if (element == 'PayPal') {
                    $fee   = {{ get_setting('paypal_fee') }};
                    $cents =  {{ get_setting('paypal_fee_cents') }};
                }else if(element == 'Stripe'){
                    $fee   = {{ get_setting('stripe_fee') }};
                    $cents =  {{ get_setting('stripe_fee_cents') }};
                }else if(element == 'Razorpay'){
                    $fee   = {{ get_setting('razorpay_fee') }};
                    $cents =  {{ get_setting('razorpay_fee_cents') }};
                }else if(element == 'Paystack'){
                    $fee   = {{ get_setting('paystack_fee') }};
                    $cents =  {{ get_setting('paystack_fee_cents') }};
                }else if(element == 'Mollie'){
                    $fee   = {{ get_setting('mollie_fee') }};
                    $cents =  {{ get_setting('mollie_fee_cents') }};
                }else if(element == 'Flutterwave'){
                    $fee   = {{ get_setting('flutterwave_fee') }};
                    $cents =  {{ get_setting('flutterwave_fee_cents') }};
                }else if(element == 'Bank'){
                    $fee   = {{ get_setting('bank_fee') }};
                    $cents =  {{ get_setting('bank_fee_cents') }};
                }

                var amount = (value * $fee / 100) + $cents;
                var amountFinal = toFixed(amount, $decimal);

                var total = (parseFloat(value) + parseFloat(amountFinal));

                if (valueOriginal.length != 0 || valueOriginal != '' || value >= {{ get_setting('min_deposit') }} ) {
                    $('#transactionFee').html(amountFinal);
                    $('#total').html(total.toFixed($decimal));
                }else{
                    $('#transactionFee, #total').html('0');
                    $('#deposit_btn').prop('disabled', true);
                }
            }

        });

        $('#onlyNumber').on('keyup', function() {

            var valueOriginal = $('#onlyNumber').val();
            var value = parseFloat($('#onlyNumber').val());
            var paymentGateway = $('input[name=payment_gateway]:checked').val();

            if (valueOriginal.length == 0) {
                $('#transactionFee').html('0');
                $('#total').html('0');
            }

            if (paymentGateway && value >= {{ get_setting('min_deposit') }} && valueOriginal != '' ) {

                if (paymentGateway == 'PayPal') {
                    $fee   = {{ get_setting('paypal_fee') }};
                    $cents =  {{ get_setting('paypal_fee_cents') }};
                }else if(paymentGateway == 'Stripe'){
                    $fee   = {{ get_setting('stripe_fee') }};
                    $cents =  {{ get_setting('stripe_fee_cents') }};
                }else if(paymentGateway == 'Razorpay'){
                    $fee   = {{ get_setting('razorpay_fee') }};
                    $cents =  {{ get_setting('razorpay_fee_cents') }};
                }else if(paymentGateway == 'Paystack'){
                    $fee   = {{ get_setting('paystack_fee') }};
                    $cents =  {{ get_setting('paystack_fee_cents') }};
                }else if(paymentGateway == 'Mollie'){
                    $fee   = {{ get_setting('mollie_fee') }};
                    $cents =  {{ get_setting('mollie_fee_cents') }};
                }else if(paymentGateway == 'Flutterwave'){
                    $fee   = {{ get_setting('flutterwave_fee') }};
                    $cents =  {{ get_setting('flutterwave_fee_cents') }};
                }else if(paymentGateway == 'Bank'){
                    $fee   = {{ get_setting('bank_fee') }};
                    $cents =  {{ get_setting('bank_fee_cents') }};
                }

                var amount = (value * $fee / 100) + $cents;
                var amountFinal = toFixed(amount, $decimal);

                var total = (parseFloat(value) + parseFloat(amountFinal));

                if (valueOriginal.length != 0 || valueOriginal != '' || value >= {{ get_setting('min_deposit') }} ) {
                    $('#transactionFee').html(amountFinal);
                    $('#total').html(total.toFixed($decimal));
                } else {
                    $('#transactionFee, #total').html('0');
                    $('#deposit_btn').prop('disabled', true);
                }
            }
        });

    });

</script>

@endsection
