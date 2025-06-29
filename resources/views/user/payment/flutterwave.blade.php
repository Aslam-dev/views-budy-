@extends('layouts.user')

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-wallet2 me-2"></i> Flutterwave</h4>
    </div>


    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">

            <form action="{{ route('flutterwave.post') }}" method="post">
                @csrf
                <input type="hidden" name="total" value="{{ $total }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <button type="submit" class="btn btn-mint btn-lg w-50">{{ trans('pay') }} {{ get_setting('currency_symbol').$total }} {{ trans('with') }} Flutterwave</button>
            </form>

        </div>
    </div><!--/dashboard-card-->


@endsection

