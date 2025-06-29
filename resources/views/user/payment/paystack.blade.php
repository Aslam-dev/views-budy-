@extends('layouts.user')

@section('content')

    <div class="mb-4" data-aos="fade-down" data-aos-easing="linear">
        <h4><i class="bi bi-wallet2 me-2"></i> Paystack</h4>
    </div>


    <div class="dashboard-card mb-5 mb-xl-10" data-aos="fade-up" data-aos-easing="linear">
        <div class="dashboard-body p-0">

                <button type="button" class="btn btn-mint btn-lg w-50" onclick="payWithPaystack()"> {{ trans('pay') }} {{ $total }} {{ trans('with') }} Paystack</button>


            <script src="https://js.paystack.co/v2/inline.js"></script>
            <script>

                function payWithPaystack() {

                    let handler = PaystackPop.setup({

                        key: "{{ get_setting('paystack_key') }}", // Replace with your public key

                        email: '{{ Auth::user()->email }}',

                        amount: '{{ $total * 100}}',

                        currency: 'NGN',

                        metadata: {
                            custom_fields:
                                {
                                    display_name: "Original Amount",
                                    variable_name: "original_amount",
                                    value: "{{ $amount }}"
                                },
                        },

                        onClose: function() {

                            window.location.href = APP_URL + "/user/wallet";

                        },

                        callback: function(response) {
                            window.location.href = APP_URL + "/user/paystack/payment/" + response.reference;
                        }

                    });


                    handler.openIframe();

                }
            </script>

        </div>
    </div><!--/dashboard-card-->


@endsection

