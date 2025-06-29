@extends('layouts.user')

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-wallet2 me-2"></i> Mollie</h4>
    </div>


    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">

            <form action="{{ route('mollie.post') }}" method="post">
                @csrf
                <input type="hidden" name="product_name" value="Add Funds to {{ get_setting('site_name') }} Account">
                <input type="hidden" name="quantity" value="1">
                <input type="hidden" name="price" value="{{ $total }}">
                <input type="hidden" name="amount" value="{{ $amount }}">
                <button type="submit" class="btn btn-mint btn-lg w-50">{{ trans('pay') }} {{ get_setting('currency_symbol').$total }} {{ trans('with') }} Mollie</button>
            </form>

        </div>
    </div><!--/dashboard-card-->


@endsection

