@extends('layouts.user')

@section('content')

    <div class="mb-4">
        <h4><i class="bi bi-wallet2 me-2"></i>{{ trans('bank_transfer') }}</h4>
    </div>


    <div class="dashboard-card mb-5 mb-xl-10">
        <div class="dashboard-body p-0">
            <h4>{{ trans('make_payment_to_our_bank_account') }}</h4>
            {!!nl2br(get_setting('bank_details'))!!}
        </div>
    </div><!--/dashboard-card-->

    <div class="dashboard-card mb-5 mb-xl-10">
        <div class="dashboard-body p-0">

            <form action="{{ route('bank.post') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group mb-3">
                  <label class="label control-label">{{ trans('bank_transaction_code') }}</label>
                  <input type="text" name="bank_code" class="field form-control" required>
                </div>

                <div class="form-group mb-3">
                  <label for="name" class="label control-label">{{ trans('bank_receipt') }}</label>
                  <input type="file" name="bank_img" id="bank_img" accept="image/*">
                </div>

                <input type="hidden" name="total" value="{{ $total }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <button type="submit" class="btn btn-mint btn-lg w-50 mt-3">{{ trans('pay') }} {{ get_setting('currency_symbol').$total }} {{ trans('with') }} {{ trans('bank') }}</button>
            </form>

        </div>
    </div><!--/dashboard-card-->


@endsection
