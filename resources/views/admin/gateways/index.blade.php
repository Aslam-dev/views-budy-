@extends('layouts.admin')


@section('content')

<main class="content">
    <!-- ========== section start ========== -->
    <section class="section">
     <div class="container-fluid">
      <div class="row mt-50">

        <div class="col-lg-3">

            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills flex-column" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.paypal') ? 'active' : '' }}" href="{{ route('admin.gateways.paypal') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> PayPal Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.stripe') ? 'active' : '' }}" href="{{ route('admin.gateways.stripe') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Stripe Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.razorpay') ? 'active' : '' }}" href="{{ route('admin.gateways.razorpay') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Razorpay Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.paystack') ? 'active' : '' }}" href="{{ route('admin.gateways.paystack') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Paystack Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.mollie') ? 'active' : '' }}" href="{{ route('admin.gateways.mollie') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Mollie Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.flutterwave') ? 'active' : '' }}" href="{{ route('admin.gateways.flutterwave') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Flutterwave Settings </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::is('admin.gateways.bank') ? 'active' : '' }}" href="{{ route('admin.gateways.bank') }}">
                            <i class="align-middle me-1" data-feather="compass"></i> Bank Transfer Settings </a>
                        </li>
                    </ul>
                </div>
            </div>


        </div>

        <div class="col-lg-9">

            @if(Route::is('admin.gateways.paypal') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.paypal') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                             <div class="select-style-1">
                                <label>Enable PayPal</label>
                                <div class="select-position">
                                    <select name="paypal_active" class="light-bg">
                                        <option @if (get_setting('paypal_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('paypal_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                             <div class="select-style-1">
                                <label>PayPal Mode</label>
                                <div class="select-position">
                                    <select name="paypal_mode" class="light-bg">
                                        <option @if (get_setting('paypal_mode') == 'sandbox') selected="selected" @endif value="sandbox">Sandbox</option>
                                        <option @if (get_setting('paypal_mode') == 'live') selected="selected" @endif value="live">Live</option>
                                    </select>
                                </div>
                              </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Client ID</label>
                                    <input type="text" name="paypal_client_id" value="{{ get_setting('paypal_client_id') }}" placeholder="Client ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Secret ID</label>
                                    <input type="text" name="paypal_secret" value="{{ get_setting('paypal_secret') }}" placeholder="Secret ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="paypal_fee" value="{{ get_setting('paypal_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="paypal_fee_cents" value="{{ get_setting('paypal_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.stripe') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.stripe') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Stripe</label>
                                <div class="select-position">
                                    <select name="stripe_active" class="light-bg">
                                        <option @if (get_setting('stripe_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('stripe_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Publishable Key</label>
                                    <input type="text" name="stripe_key" value="{{ get_setting('stripe_key') }}" placeholder="Publishable Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Secret Key</label>
                                    <input type="text" name="stripe_secret" value="{{ get_setting('stripe_secret') }}" placeholder="Secret ID" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="stripe_fee" value="{{ get_setting('stripe_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="stripe_fee_cents" value="{{ get_setting('stripe_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.razorpay') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.razorpay') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Razorpay</label>
                                <div class="select-position">
                                    <select name="razorpay_active" class="light-bg">
                                        <option @if (get_setting('razorpay_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('razorpay_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Razorpay Key ID</label>
                                    <input type="text" name="razorpay_key" value="{{ get_setting('razorpay_key') }}" placeholder="Razorpay Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Razorpay Key Secret</label>
                                    <input type="text" name="razorpay_secret" value="{{ get_setting('razorpay_secret') }}" placeholder="Razorpay Secret" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="razorpay_fee" value="{{ get_setting('razorpay_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="razorpay_fee_cents" value="{{ get_setting('razorpay_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.paystack') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.paystack') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Paystack</label>
                                <div class="select-position">
                                    <select name="paystack_active" class="light-bg">
                                        <option @if (get_setting('paystack_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('paystack_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Paystack Public Key</label>
                                    <input type="text" name="paystack_key" value="{{ get_setting('paystack_key') }}" placeholder="Paystack Public Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Paystack Secret Key</label>
                                    <input type="text" name="paystack_secret" value="{{ get_setting('paystack_secret') }}" placeholder="Paystack Secret Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="paystack_fee" value="{{ get_setting('paystack_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="paystack_fee_cents" value="{{ get_setting('paystack_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.mollie') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.mollie') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Mollie</label>
                                <div class="select-position">
                                    <select name="mollie_active" class="light-bg">
                                        <option @if (get_setting('mollie_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('mollie_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Mollie Key</label>
                                    <input type="text" name="mollie_key" value="{{ get_setting('mollie_key') }}" placeholder="Mollie Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="mollie_fee" value="{{ get_setting('mollie_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="mollie_fee_cents" value="{{ get_setting('mollie_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.flutterwave') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.flutterwave') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Flutterwave</label>
                                <div class="select-position">
                                    <select name="flutterwave_active" class="light-bg">
                                        <option @if (get_setting('flutterwave_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('flutterwave_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Flutterwave Public Key</label>
                                    <input type="text" name="flutterwave_key" value="{{ get_setting('flutterwave_key') }}" placeholder="Flutterwave Public Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Flutterwave Secret Key</label>
                                    <input type="text" name="flutterwave_secret" value="{{ get_setting('flutterwave_secret') }}" placeholder="Flutterwave Secret Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Flutterwave Encyption Key</label>
                                    <input type="text" name="flutterwave_hash" value="{{ get_setting('flutterwave_hash') }}" placeholder="Flutterwave Encyption Key" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="flutterwave_fee" value="{{ get_setting('flutterwave_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="flutterwave_fee_cents" value="{{ get_setting('flutterwave_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @elseif(Route::is('admin.gateways.bank') )

                <div class="card-style settings-card-2 mb-30">
                    <form action="{{ route('admin.gateways.bank') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-12">
                                <div class="select-style-1">
                                <label>Enable Bank</label>
                                <div class="select-position">
                                    <select name="bank_active" class="light-bg">
                                        <option @if (get_setting('bank_active') == 'Yes') selected="selected" @endif value="Yes">Yes</option>
                                        <option @if (get_setting('bank_active') == 'No') selected="selected" @endif value="No">No</option>
                                    </select>
                                </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Bank Details</label>
                                    <textarea name="bank_details" rows="4" placeholder="Bank Details">{{ get_setting('bank_details') }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Percentage Fee %</label>
                                    <input type="text" name="bank_fee" value="{{ get_setting('bank_fee') }}" placeholder="Percentage Fee %" />
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-style-1">
                                    <label>Fee Cents</label>
                                    <input type="text" name="bank_fee_cents" value="{{ get_setting('bank_fee_cents') }}" placeholder="Fee Cents" />
                                </div>
                            </div>


                            <div class="col-md-12">
                                <div class="form-group">
                                <button type="submit" class="main-btn primary-btn btn-hover">{{ trans('submit') }}</button>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

            @endif

        </div>

      </div>
     </div>
    </section>
</main>

@endsection
