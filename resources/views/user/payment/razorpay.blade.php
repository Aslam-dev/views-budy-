@extends('layouts.user')

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-wallet2 me-2"></i> Razorpay</h4>
    </div>


    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">


            <form action="{{ route('razorpay.payment') }}" method="POST" >

                @csrf

                <input type="hidden" name="amount" value="{{ $amount }}">

                <script src="https://checkout.razorpay.com/v1/checkout.js"

                        data-key="{{ get_setting('razorpay_key') }}"

                        data-amount="{{ $total * 100}}"

                        data-buttontext="Pay {{ $total }} INR"

                        data-name="{{ get_setting('site_name') }}"

                        data-description="Pay with Razorpay"

                        data-image="{{ my_asset('uploads/settings/'.get_setting('favicon')) }}"

                        data-prefill.name="{{ Auth::user()->name }}"

                        data-prefill.email="{{ Auth::user()->email }}"

                        data-theme.color="#ff7529">

                </script>
            </form>
        </div>
    </div><!--/dashboard-card-->


@endsection

